<?php

namespace App\Http\Controllers;

use App\Models\PenitipanHewan;
use App\Models\Hewan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SystemNotification; // Import Notifikasi
use Carbon\Carbon; // Import Carbon

class PenitipanHewanController extends Controller
{
    public function index()
    {
        // Doctors cannot access this page
        if (auth()->user()->hasRole('doctor')) {
            abort(403, 'Unauthorized action.');
        }

        // Get penitipan hewan records based on user role
        if (auth()->user()->hasRole('user')) {
            $penitipans = PenitipanHewan::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Admin can see all records
            $penitipans = PenitipanHewan::orderBy('created_at', 'desc')->get();
        }

        return view('PenitipanHewan.index', compact('penitipans'));
    }

    public function create()
    {
        $hewans = Hewan::where('user_id', auth()->id())->get();
        return view('penitipanHewan', compact('hewans'));
    }

    public function store(Request $request)
    {
        // Validasi menggunakan 'tanggal_ambil' sesuai kodingan asli Anda
        $request->validate([
            'hewan_id' => 'required|exists:hewans,id',
            'alamat_rumah' => 'required|string',
            'tanggal_titip' => 'required|date|after_or_equal:today',
            'tanggal_ambil' => 'required|date|after_or_equal:tanggal_titip',
            'jenis_service' => 'required|in:pick-up,drop-off',
        ]);

        try {
            $hewan = Hewan::findOrFail($request->hewan_id);
            $umur_lengkap = $hewan->umur . ' Tahun';

            $penitipan = PenitipanHewan::create([
                'user_id' => Auth::id(),
                'nama_pemilik' => Auth::user()->name,
                'nama_hewan' => $hewan->nama,
                'umur' => $umur_lengkap,
                'spesies' => $hewan->jenis,
                'ras' => $hewan->ras,
                'alamat_rumah' => $request->alamat_rumah,
                'tanggal_titip' => $request->tanggal_titip,
                'tanggal_ambil' => $request->tanggal_ambil,
                'jenis_service' => $request->jenis_service,
                'status' => 'pending',
            ]);

            return redirect()->route('penitipan.hewan.create')->with('success', 'Permintaan penitipan berhasil dikirim!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,dititip,selesai',
        ]);

        $penitipan = PenitipanHewan::findOrFail($id);
        $oldStatus = $penitipan->status;
        $penitipan->status = $request->status;
        $penitipan->save();

        // --- FITUR NOTIFIKASI OTOMATIS (DEMO READY) ---

        // 1. Notifikasi: Staff sedang di perjalanan (Saat status berubah ke 'dititip')
        // Sesuai permintaan: Jika Admin confirm (ubah status), muncul notif staff sedang di jalan
        if ($request->status == 'dititip' && $oldStatus == 'pending') {
            try {
                $user = User::find($penitipan->user_id);
                if ($user) {
                    $user->notify(new SystemNotification(
                        'Staff Sedang Menuju Lokasi',
                        "Halo {$user->name}, permintaan penitipan untuk {$penitipan->nama_hewan} telah dikonfirmasi. Staff kami sedang berada di perjalanan menuju lokasi Anda untuk penjemputan.",
                        route('penitipan.hewan.index')
                    ));
                }
            } catch (\Exception $e) {}
        }

        // 2. Notifikasi: Pengingat Jadwal Penjemputan/Ambil (Hari H)
        // Kita gunakan 'tanggal_ambil' sesuai kolom asli Anda
        if ($request->status == 'dititip') {
            if (Carbon::parse($penitipan->tanggal_ambil)->isToday()) {
                try {
                    $user = User::find($penitipan->user_id);
                    if ($user) {
                        $user->notify(new SystemNotification(
                            'Jadwal Penjemputan Hari Ini',
                            "Halo {$user->name}, hari ini adalah jadwal pengambilan {$penitipan->nama_hewan} dari penitipan. Harap segera dilakukan ya.",
                            route('penitipan.hewan.index')
                        ));
                    }
                } catch (\Exception $e) {}
            }
        }

        return redirect()->route('penitipan.hewan.index')->with('success', 'Status berhasil diperbarui!');
    }
}