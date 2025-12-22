<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hewan;
use App\Models\BookingKonsultasi;
use App\Models\PenitipanHewan;
// Tambahkan Model PemeriksaanLab
use App\Models\PemeriksaanLab; 

class DashboardController extends Controller
{
    public function setPet(Hewan $hewan)
    {
        if ($hewan->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }
        session(['mainPet_id' => $hewan->id]);
        return redirect()->route('dashboard')->with('success', 'Hewan dipilih.');
    }

    public function index()
    {
        $user = Auth::user();

        // === DASHBOARD UNTUK ADMIN / DOKTER ===
        if ($user->hasRole(['admin', 'doctor'])) {
            $data = [
                'total_users' => User::role('user')->count(),
                'total_hewan' => Hewan::count(),
                'pending_consultations' => BookingKonsultasi::where('status', 'pending')->count(),
                
                // Tambahkan hitungan antrean lab
                'pending_lab' => PemeriksaanLab::where('status', 'menunggu_approval')->count(), 
                
                'pending_penitipan' => PenitipanHewan::where('status', 'pending')->count(),
                'recent_users' => User::role('user')->latest()->take(5)->get(),
            ];

            return view('dashboard', compact('data'));
        }

        // === DASHBOARD UNTUK USER ===
        $userHewans = Hewan::where('user_id', $user->id)->get();
        $mainPet = $userHewans->first();

        // 1. Ambil Jadwal Konsultasi (Antrean)
        $upcomingSchedules = BookingKonsultasi::with(['dokter'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'dikonfirmasi', 'diperiksa'])
            ->orderBy('tanggal_booking', 'asc')
            ->take(3)
            ->get();

        // 2. Ambil Hasil Lab yang SUDAH SELESAI
        $labResults = PemeriksaanLab::where('user_id', $user->id)
            ->where('status', 'selesai') // Hanya yang sudah diapprove admin
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', [
            'mainPet' => $mainPet,
            'upcomingSchedules' => $upcomingSchedules,
            'labResults' => $labResults, // Kirim variabel ini ke view
            'userHewans' => $userHewans,
        ]);
    }
}