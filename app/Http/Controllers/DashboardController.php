<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Hewan;
use App\Models\BookingKonsultasi;
use App\Models\PenitipanHewan;

class DashboardController extends Controller
{
    public function setPet(Hewan $hewan)
    {
        // Verify user owns this hewan
        if ($hewan->user_id !== auth()->id()) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized');
        }

        session(['mainPet_id' => $hewan->id]);

        return redirect()->route('dashboard')->with('success', 'Hewan dipilih.');
    }

    public function index()
    {
        $user = Auth::user();

        // ------------------------------------------------
        // 1. LOGIKA UNTUK ADMIN & DOKTER
        // ------------------------------------------------
        if ($user->hasRole(['admin', 'doctor'])) {
            // Ambil data statistik untuk admin
            $data = [
                'total_users' => User::role('user')->count(),
                'total_hewan' => Hewan::count(),
                'pending_consultations' => BookingKonsultasi::where('status', 'pending')->count(),
                'pending_penitipan' => PenitipanHewan::where('status', 'pending')->count(),
                'recent_users' => User::role('user')->latest()->take(5)->get(),
            ];
            
            return view('dashboard', compact('data'));
        }

        // ------------------------------------------------
        // 2. LOGIKA UNTUK USER (PET OWNER)
        // ------------------------------------------------
        // Ambil hewan pertama milik user untuk ditampilkan di "Pet Profile Card"
        $mainPet = Hewan::where('user_id', $user->id)->first(); 
        // Ambil semua hewan milik user untuk header/avatar list
        $userHewans = Hewan::where('user_id', $user->id)->get();
        
        // Ambil jadwal konsultasi yang akan datang (status selain completed/cancelled)
        $upcomingSchedules = BookingKonsultasi::with(['dokter', 'hewan'])
                            ->where('user_id', $user->id)
                            ->whereIn('status', ['pending', 'confirmed', 'approved']) // Sesuaikan status dengan database Anda
                            ->orderBy('tanggal_booking', 'asc')
                            ->take(3)
                            ->get();

        // (Opsional) Ambil riwayat medis jika ada model RekamMedis yang terhubung
        // $history = ...

        return view('dashboard', compact('mainPet', 'upcomingSchedules', 'userHewans'));
    }
}