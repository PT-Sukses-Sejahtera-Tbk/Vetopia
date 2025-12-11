<?php

namespace App\Http\Controllers;

use App\Models\BookingKonsultasi;
use App\Models\Hewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingKonsultasiController extends Controller
{
    // Menampilkan halaman form
    public function index()
    {
        // Get authenticated user's hewans
        $hewans = Hewan::where('user_id', auth()->id())->get();

        return view('bookConsultation.index', compact('hewans'));
    }

    // Menyimpan data booking (Backend Logic utama)
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'hewan_id' => 'required|exists:hewans,id',
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
}