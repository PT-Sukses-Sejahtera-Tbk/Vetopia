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
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole(['admin', 'doctor'])) {
            $data = [
                'total_users' => User::role('user')->count(),
                'total_hewan' => Hewan::count(),
                'pending_consultations' => BookingKonsultasi::where('status', 'pending')->count(),
                'pending_penitipan' => PenitipanHewan::where('status', 'pending')->count(),
                'recent_users' => User::role('user')->latest()->take(5)->get(),
            ];

            return view('dashboard', compact('data'));
        }

        $userHewans = Hewan::where('user_id', $user->id)->get();
        $mainPet = $userHewans->first();

        $upcomingSchedules = BookingKonsultasi::with(['dokter'])
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'dikonfirmasi', 'diperiksa'])
            ->orderBy('tanggal_booking', 'asc')
            ->take(3)
            ->get();

        return view('dashboard', [
            'mainPet' => $mainPet,
            'upcomingSchedules' => $upcomingSchedules,
            'userHewans' => $userHewans,
        ]);
    }
}