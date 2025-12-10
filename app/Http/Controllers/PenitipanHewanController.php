<?php

namespace App\Http\Controllers;

use App\Models\PenitipanHewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenitipanHewanController extends Controller
{
    public function index()
    {
        // Pastikan nama folder view sesuai (PenitipanHewan atau penitipanHewan)
        return view('PenitipanHewan.index');
    }

public function store(Request $request)
    {
        $request->validate([
            'nama_hewan' => 'required|string|max:255',
            
            // Validasi Umur Baru (Terpisah)
            'umur_angka' => 'required|integer|min:1',
            'satuan_umur' => 'required|in:Tahun,Bulan,Minggu',
            
            'spesies' => 'required|string|max:255',
            'ras' => 'required|string|max:255',
            'alamat_rumah' => 'required|string',
            'tanggal_titip' => 'required|date|after_or_equal:today',
            'tanggal_ambil' => 'required|date|after_or_equal:tanggal_titip',
            'jenis_service' => 'required|in:pick-up,drop-off',
        ]);

        try {
            // Gabungkan Angka + Satuan (Contoh: "5" + " " + "Bulan" = "5 Bulan")
            $umur_lengkap = $request->umur_angka . ' ' . $request->satuan_umur;

            PenitipanHewan::create([
                'user_id' => Auth::id(),
                'nama_pemilik' => Auth::user()->name,
                'nama_hewan' => $request->nama_hewan,
                
                'umur' => $umur_lengkap, // Simpan hasil gabungan
                
                'spesies' => $request->spesies,
                'ras' => $request->ras,
                'alamat_rumah' => $request->alamat_rumah,
                'tanggal_titip' => $request->tanggal_titip,
                'tanggal_ambil' => $request->tanggal_ambil,
                'jenis_service' => $request->jenis_service,
                'status' => 'pending',
            ]);

            return redirect()->route('penitipan.hewan')->with('success', 'Permintaan penitipan berhasil dikirim!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}