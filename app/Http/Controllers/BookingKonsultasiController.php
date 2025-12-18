<?php

namespace App\Http\Controllers;

use App\Models\BookingKonsultasi;
use App\Models\Hewan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingKonsultasiController extends Controller
{
    // Menampilkan halaman form
    public function index()
    {
        // Get authenticated user's hewans
        $hewans = Hewan::where('user_id', auth()->id())->get();

        // Get all doctors (users with doctor role)
        $dokters = User::role('doctor')->with('dokter')->get();

        return view('bookingKonsultasi', compact('hewans', 'dokters'));
    }

    // Menyimpan data booking (Backend Logic utama)
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'hewan_id' => 'required|exists:hewans,id',
            'dokter_user_id' => 'required|exists:users,id',
            'keluhan' => 'required|string',
            'tanggal_booking' => 'required|date|after_or_equal:today',
        ]);

        try {
            // Get hewan data
            $hewan = Hewan::findOrFail($request->hewan_id);

            // Format umur
            $umur_lengkap = $hewan->umur . ' Tahun';

            // 2. Simpan ke Database
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
    // Doctor and Admin management page
    public function manage()
    {
        // Only doctors and admins can access
        if (!auth()->user()->hasAnyRole(['doctor', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $bookings = BookingKonsultasi::with('dokter')->orderBy('created_at', 'desc')->get();
        return view('bookConsultation.index', compact('bookings'));
    }

    // Update booking status (doctor only)
    public function updateStatus(Request $request, $id)
    {
        // Only doctors can update status
        if (!auth()->user()->hasRole('doctor')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,diperiksa,selesai',
        ]);

        $booking = BookingKonsultasi::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return redirect()->route('booking.konsultasi.manage')->with('success', 'Status berhasil diperbarui!');
    }

    // Show form to complete consultation with rekam medis
    public function showCompleteForm($id)
    {
        $booking = BookingKonsultasi::findOrFail($id);

        if ($booking->status !== 'diperiksa') {
            return redirect()->route('booking.konsultasi.manage')->with('error', 'Booking harus dalam status diperiksa.');
        }

        // Get hewan_id from booking's nama_hewan
        $hewan = \App\Models\Hewan::where('nama', $booking->nama_hewan)
            ->where('user_id', $booking->user_id)
            ->first();

        $dokter = \App\Models\Dokter::where('user_id', auth()->id())->first();

        return view('bookConsultation.complete', compact('booking', 'hewan', 'dokter'));
    }

    // Complete consultation and create rekam medis
    public function complete(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required|string',
            'tindakan' => 'required|string',
        ]);

        $booking = BookingKonsultasi::findOrFail($id);

        // Get hewan
        $hewan = \App\Models\Hewan::where('nama', $booking->nama_hewan)
            ->where('user_id', $booking->user_id)
            ->first();

        if (!$hewan) {
            return redirect()->back()->with('error', 'Hewan tidak ditemukan.');
        }

        // Get dokter
        $dokter = \App\Models\Dokter::where('user_id', auth()->id())->first();

        if (!$dokter) {
            return redirect()->back()->with('error', 'Profil dokter tidak ditemukan.');
        }

        // Create rekam medis
        \App\Models\RekamMedis::create([
            'hewan_id' => $hewan->id,
            'dokter_id' => $dokter->id,
            'tanggal_periksa' => $booking->tanggal_booking,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
        ]);

        // Update booking status to selesai
        $booking->status = 'selesai';
        $booking->save();

        return redirect()->route('booking.konsultasi.manage')->with('success', 'Konsultasi selesai dan rekam medis berhasil dibuat!');
    }
}