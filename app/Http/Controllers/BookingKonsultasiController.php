<?php

namespace App\Http\Controllers;

use App\Models\BookingKonsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingKonsultasiController extends Controller
{
    // Menampilkan halaman form
    public function index()
    {
        return view('bookConsultation.index');
    }

    // Menyimpan data booking (Backend Logic utama)
public function store(Request $request)
{
    // 1. Validasi
    $request->validate([
        'nama_hewan' => 'required|string|max:255',
        // Validasi angka dan satuan terpisah
        'umur_angka' => 'required|integer|min:1',
        'satuan_umur' => 'required|in:Tahun,Bulan,Minggu',
        'spesies' => 'required|string|max:255',
        'ras' => 'nullable|string|max:255', // Ubah jadi nullable jika ras tidak wajib
        'keluhan' => 'required|string',
        'tanggal_booking' => 'required|date|after_or_equal:today',
    ]);

    try {
        // GABUNGKAN ANGKA DAN SATUAN
        // Contoh hasil: "3" + " " + "Bulan" = "3 Bulan"
        $umur_lengkap = $request->umur_angka . ' ' . $request->satuan_umur;

        // 2. Simpan ke Database
        BookingKonsultasi::create([
            'user_id' => Auth::id(),
            'nama_hewan' => $request->nama_hewan,
            'umur' => $umur_lengkap, // Simpan hasil gabungan
            'spesies' => $request->spesies,
            'ras' => $request->ras,
            'keluhan' => $request->keluhan,
            'tanggal_booking' => $request->tanggal_booking,
            'status' => 'pending',
        ]);

        return redirect()->route('booking.konsultasi')->with('success', 'Booking berhasil! Mohon tunggu konfirmasi admin.');
        
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    }
}
}