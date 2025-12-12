<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanLab;
use App\Models\Hewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemeriksaanLabController extends Controller
{
    // === BAGIAN USER (CUSTOMER) ===

    public function index()
    {
        // Ambil data hewan milik user yang sedang login
        $hewans = Hewan::where('user_id', auth()->id())->get();

        // REVISI: Memanggil file resources/views/pemeriksaanLab.blade.php
        return view('pemeriksaanLab', compact('hewans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewans,id',
            'jenis_pemeriksaan' => 'required|string',
            'keluhan_atau_alasan' => 'required|string',
            'tanggal_booking' => 'required|date|after_or_equal:today',
        ]);

        try {
            $hewan = Hewan::findOrFail($request->hewan_id);

            if ($hewan->user_id !== Auth::id()) {
                abort(403, 'Unauthorized action.');
            }

            $umur_lengkap = $hewan->umur . ' Tahun';

            PemeriksaanLab::create([
                'user_id' => Auth::id(),
                'nama_pemilik' => Auth::user()->name,
                'nama_hewan' => $hewan->nama,
                'umur' => $umur_lengkap,
                'spesies' => $hewan->jenis,
                'ras' => $hewan->ras,
                'jenis_pemeriksaan' => $request->jenis_pemeriksaan,
                'keluhan_atau_alasan' => $request->keluhan_atau_alasan,
                'tanggal_booking' => $request->tanggal_booking,
                'status' => 'pending',
            ]);

            // Redirect kembali ke halaman form dengan pesan sukses
            return redirect()->route('pemeriksaan.lab.index')->with('success', 'Booking pemeriksaan lab berhasil dikirim!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // === BAGIAN ADMIN / DOKTER (Manajemen) ===
    // Nantinya view untuk ini baru bisa diletakkan di folder, misal: resources/views/pemeriksaanLab/manage.blade.php
    
    public function manage()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized action.');
        }

        $pemeriksaans = PemeriksaanLab::orderBy('created_at', 'desc')->get();
        
        // Contoh jika nanti Anda buat view admin: return view('pemeriksaanLab.manage', compact('pemeriksaans'));
        // Untuk sekarang saya komen dulu atau sesuaikan dengan kebutuhan Anda
        return view('pemeriksaanLab.manage', compact('pemeriksaans')); 
    }

    public function updateStatus(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,selesai,dibatalkan',
        ]);

        $lab = PemeriksaanLab::findOrFail($id);
        $lab->status = $request->status;
        $lab->save();

        return redirect()->route('pemeriksaan.lab.manage')->with('success', 'Status pemeriksaan berhasil diperbarui!');
    }
}