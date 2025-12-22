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
        $hewans = Hewan::where('user_id', auth()->id())->get();
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

            return redirect()->route('pemeriksaan.lab.index')->with('success', 'Booking pemeriksaan lab berhasil dikirim!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // === BAGIAN ADMIN / DOKTER (Manajemen) ===

    public function manage()
    {
        if (!auth()->user()->hasAnyRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized action.');
        }

        $pemeriksaans = PemeriksaanLab::orderBy('created_at', 'desc')->get();
        return view('pemeriksaanLab.manage', compact('pemeriksaans')); 
    }

    public function updateStatus(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'status' => 'required|in:pending,dikonfirmasi,selesai,dibatalkan,menunggu_approval',
        ]);

        $lab = PemeriksaanLab::findOrFail($id);
        $lab->status = $request->status;
        $lab->save();

        return redirect()->route('pemeriksaan.lab.manage')->with('success', 'Status pemeriksaan berhasil diperbarui!');
    }

    // Menampilkan Form Pengisian Hasil Lab
    public function showCompleteForm($id)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized action.');
        }

        $lab = PemeriksaanLab::findOrFail($id);
        
        // Perbaikan: Kirim variabel $lab (single object), bukan collection
        return view('pemeriksaanLab.complete', compact('lab'));
    }

    // Menyimpan Hasil Lab
    public function complete(Request $request, $id)
    {
        if (!auth()->user()->hasAnyRole(['admin', 'doctor'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'hasil_pemeriksaan' => 'required|string',
            'catatan_dokter' => 'nullable|string',
        ]);

        $lab = PemeriksaanLab::findOrFail($id);
        
        $lab->update([
            'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
            'catatan_dokter' => $request->catatan_dokter,
            'status' => 'menunggu_approval', // Kirim ke Admin untuk Approval
        ]);

        return redirect()->route('pemeriksaan.lab.manage')
            ->with('success', 'Hasil pemeriksaan disimpan. Menunggu approval Admin.');
    }
}