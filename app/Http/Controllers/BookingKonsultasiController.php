<?php

namespace App\Http\Controllers;

use App\Models\BookingKonsultasi;
use App\Models\Hewan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification; // Import Notifikasi
use Carbon\Carbon; // Import Carbon untuk urus tanggal

class BookingKonsultasiController extends Controller
{
    // Menampilkan halaman form
    public function index()
    {
        $hewans = Hewan::where('user_id', auth()->id())->get();
        $dokters = User::role('doctor')->with('dokter')->get();
        return view('bookingKonsultasi', compact('hewans', 'dokters'));
    }

    // Menyimpan data booking
    public function store(Request $request)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewans,id',
            'dokter_user_id' => 'required|exists:users,id',
            'keluhan' => 'required|string',
            'tanggal_booking' => 'required|date|after_or_equal:today',
        ]);

        try {
            $hewan = Hewan::findOrFail($request->hewan_id);
            $umur_lengkap = $hewan->umur . ' Tahun';

            BookingKonsultasi::create([
                'user_id' => Auth::id(),
                'dokter_user_id' => $request->dokter_user_id,
                'nama_pemilik' => Auth::user()->name,
                'nama_hewan' => $hewan->nama,
                'umur' => $umur_lengkap,
                'spesies' => $hewan->jenis,
                'ras' => $hewan->ras,
                'keluhan' => $request->keluhan,
                'tanggal_booking' => $request->tanggal_booking,
                'status' => 'pending',
            ]);

            return redirect()->route('booking.konsultasi')->with('success', 'Booking berhasil! Mohon tunggu konfirmasi admin.');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }
    
    // Halaman Manage (Dokter/Admin)
    public function manage()
    {
        if (!auth()->user()->hasAnyRole(['doctor', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $bookings = BookingKonsultasi::with('dokter')->orderBy('created_at', 'desc')->get();
        return view('bookConsultation.index', compact('bookings'));
    }

    // === Update Status & Logika Notifikasi Otomatis ===
    public function updateStatus(Request $request, $id)
    {
        if (!auth()->user()->hasRole('doctor')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,diperiksa,menunggu pembayaran,selesai',
        ]);

        $booking = BookingKonsultasi::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        // LOGIKA KHUSUS DEMO:
        // Cek jika status diubah jadi 'dikonfirmasi'
        if ($request->status == 'dikonfirmasi') {
            
            // Ambil tanggal booking dari database
            $tglBooking = Carbon::parse($booking->tanggal_booking);
            
            // Cek apakah tanggalnya HARI INI?
            if ($tglBooking->isToday()) {
                // Jika YA (Hari Ini) -> Kirim Notif Hari H
                try {
                    $booking->user->notify(new SystemNotification(
                        'Jadwal Konsultasi Hari Ini',
                        // PERUBAHAN DISINI: Menghapus "kak"
                        "Halo {$booking->nama_pemilik}, hari ini jadwal konsultasi untuk {$booking->nama_hewan} telah dikonfirmasi. Harap bersiap ya!",
                        route('booking.myBookings')
                    ));
                } catch (\Exception $e) {}

            } else {
                // Jika BUKAN Hari Ini (misal besok) -> Kirim Notif Konfirmasi Biasa
                try {
                    $booking->user->notify(new SystemNotification(
                        'Booking Dikonfirmasi',
                        "Jadwal konsultasi untuk {$booking->nama_hewan} pada tanggal " . $tglBooking->format('d M Y') . " telah disetujui dokter.",
                        route('booking.myBookings')
                    ));
                } catch (\Exception $e) {}
            }
        }

        return redirect()->route('booking.konsultasi.manage')->with('success', 'Status berhasil diperbarui!');
    }

    // Form Selesai Periksa
    public function showCompleteForm($id)
    {
        $booking = BookingKonsultasi::findOrFail($id);

        if ($booking->status !== 'diperiksa') {
            return redirect()->route('booking.konsultasi.manage')->with('error', 'Booking harus dalam status diperiksa.');
        }

        $hewan = \App\Models\Hewan::where('nama', $booking->nama_hewan)
            ->where('user_id', $booking->user_id)
            ->first();

        $dokter = \App\Models\Dokter::where('user_id', auth()->id())->first();

        return view('bookConsultation.complete', compact('booking', 'hewan', 'dokter'));
    }

    // Simpan Rekam Medis & Notif Tagihan
    public function complete(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
            'biaya' => 'required|numeric|min:0',
        ]);

        $booking = BookingKonsultasi::findOrFail($id);

        $hewan = \App\Models\Hewan::where('nama', $booking->nama_hewan)
            ->where('user_id', $booking->user_id)
            ->first();

        if (!$hewan) {
            return redirect()->back()->with('error', 'Hewan tidak ditemukan.');
        }

        $dokter = \App\Models\Dokter::where('user_id', auth()->id())->first();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Profil dokter tidak ditemukan.');
        }

        \App\Models\RekamMedis::create([
            'hewan_id' => $hewan->id,
            'dokter_id' => $dokter->id,
            'tanggal_periksa' => $booking->tanggal_booking,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
        ]);

        $booking->biaya = $request->biaya;
        $booking->status = 'menunggu pembayaran';
        $booking->save();

        // Notifikasi Tagihan
        try {
            $booking->user->notify(new SystemNotification(
                'Tagihan Pembayaran',
                "Pemeriksaan {$booking->nama_hewan} selesai. Total tagihan: Rp " . number_format($booking->biaya, 0, ',', '.'),
                route('payment.show', $booking->id)
            ));
        } catch (\Exception $e) {}

        return redirect()->route('booking.konsultasi.manage')->with('success', 'Konsultasi selesai! Menunggu pembayaran dari pasien.');
        
    }

    public function myBookings()
    {
        $bookings = BookingKonsultasi::with('dokter')
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('bookConsultation.myBookings', compact('bookings'));
    }
}