<?php

namespace App\Http\Controllers;

use App\Models\PenitipanHewan;
use App\Models\Hewan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenitipanHewanController extends Controller
{
    public function index()
    {
        // Get authenticated user's hewans
        $hewans = Hewan::where('user_id', auth()->id())->get();

        return view('PenitipanHewan.index', compact('hewans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hewan_id' => 'required|exists:hewans,id',
            'alamat_rumah' => 'required|string',
            'tanggal_titip' => 'required|date|after_or_equal:today',
            'tanggal_ambil' => 'required|date|after_or_equal:tanggal_titip',
            'jenis_service' => 'required|in:pick-up,drop-off',
        ]);

        try {
            // Get hewan data
            $hewan = Hewan::findOrFail($request->hewan_id);

            // Format umur
            $umur_lengkap = $hewan->umur . ' Tahun';

            PenitipanHewan::create([
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

            return redirect()->route('penitipan.hewan')->with('success', 'Permintaan penitipan berhasil dikirim!');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}