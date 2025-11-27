<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminibotController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/booking-konsultasi', function () {
        return view('bookConsultation/index');
    })->name('booking.konsultasi');

    Route::get('/konsultasi-online', function () {
        return view('konsultasiOnline/index');
    })->name('konsultasi.online');

    Route::get('/rawat-jalan', function () {
        return view('rawatJalan/index');
    })->name('rawat.jalan');

    // Temporary test route for hewan view
    Route::get('/hewan', function () {
        return view('hewan.index'); // or whatever your view path is
    })->name('hewan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/konsultasi-online', [GeminibotController::class, 'index'])->name('chat.index');
    Route::post('/konsultasi-chat', [GeminibotController::class, 'chat'])->name('chat.process');
});

require __DIR__ . '/auth.php';
