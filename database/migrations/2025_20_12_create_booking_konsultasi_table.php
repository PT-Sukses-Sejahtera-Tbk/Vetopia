<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('booking_konsultasi', function (Blueprint $table) {
            $table->id();
            // Menghubungkan dengan user yang login
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Menghubungkan dengan dokter (user dengan role doctor)
            $table->foreignId('dokter_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama_pemilik');

            // Field sesuai request Anda
            $table->string('nama_hewan');
            $table->string('umur'); // Asumsi umur dalam tahun/bulan (angka)
            $table->string('spesies'); // Contoh: Kucing, Anjing
            $table->string('ras')->nullable(); // Boleh kosong
            $table->text('keluhan');
            $table->date('tanggal_booking');

            // Status booking (Pending, Disetujui, Selesai, Dibatalkan)
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_konsultasi');
    }
};