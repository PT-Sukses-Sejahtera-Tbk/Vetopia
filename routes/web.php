<?php

use App\Http\Controllers\HewanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ManageUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeminibotController;
use App\Http\Controllers\BookingKonsultasiController;
use App\Http\Controllers\PenitipanHewanController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/hubungi-kami', function () {
    $title = 'Hubungi Kami'; // <-- Tambahkan variabel title
    return view('HubungiKami.index', compact('title')); // <-- Kirim variabel ke view
})->name('contact');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/booking-konsultasi', [BookingKonsultasiController::class, 'index'])->name('booking.konsultasi');
    Route::post('/booking-konsultasi', [BookingKonsultasiController::class, 'store'])->name('booking.konsultasi.store');

    Route::get('/konsultasi-online', function () {
        return view('konsultasiOnline/index');
    })->name('konsultasi.online');

    Route::get('/rawat-jalan', function () {
        return view('rawatJalan/index');
    })->name('rawat.jalan');

    Route::get('/penitipan-hewan', [PenitipanHewanController::class, 'index'])->name('penitipan.hewan');
    Route::post('/penitipan-hewan', [PenitipanHewanController::class, 'store'])->name('penitipan.hewan.store');

    // Temporary test route for hewan view
    Route::get('/dummy', function () {
        return view('dummy.index'); // or whatever your view path is
    })->name('dummy');

    Route::middleware('role:admin')->group(function () {
        // User Manage Section
        Route::get('/manage-user', [ManageUserController::class, 'index'])->name('admin.userManage.index');
        Route::get('/manage-user/add-user', [ManageUserController::class, 'create'])->name('admin.userManage.create');
        Route::post('/manage-user/store', [ManageUserController::class, 'store'])->name('admin.userManage.store');
        Route::get('/manage-user/{user}/edit', [ManageUserController::class, 'edit'])->name('admin.userManage.edit');
        Route::put('/manage-user/{user}', [ManageUserController::class, 'update'])->name('admin.userManage.update');
        Route::delete('/manage-user/{user}', [ManageUserController::class, 'destroy'])->name('admin.userManage.destroy');
    });

    // Hewan Manage Section
    Route::get('/hewan', [HewanController::class, 'index'])->name('hewan.index');
    Route::get('/hewan/create', [HewanController::class, 'create'])->name('hewan.create');
    Route::post('/hewan', [HewanController::class, 'store'])->name('hewan.store');
    Route::get('/hewan/{hewan}', [HewanController::class, 'show'])->name('hewan.show');
    Route::get('/hewan/{hewan}/edit', [HewanController::class, 'edit'])->name('hewan.edit');
    Route::put('/hewan/{hewan}', [HewanController::class, 'update'])->name('hewan.update');
    Route::delete('/hewan/{hewan}', [HewanController::class, 'destroy'])->name('hewan.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/konsultasi-online', [GeminibotController::class, 'index'])->name('chat.index');
    Route::post('/konsultasi-chat', [GeminibotController::class, 'chat'])->name('chat.process');
});

require __DIR__ . '/auth.php';
