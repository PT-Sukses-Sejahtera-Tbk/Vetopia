<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan_labs', function (Blueprint $table) {
            $table->id();
            // Relasi ke user
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informasi Pemilik & Hewan (Snapshot data saat booking)
            $table->string('nama_pemilik');
            $table->string('nama_hewan');
            $table->string('umur');
            $table->string('spesies');
            $table->string('ras')->nullable();
            
            // Detail Pemeriksaan Lab
            $table->string('jenis_pemeriksaan'); // Contoh: Cek Darah, Rontgen, USG, dll.
            $table->text('keluhan_atau_alasan'); // Alasan kenapa butuh lab
            $table->date('tanggal_booking');
            
            // Status: pending, dikonfirmasi, selesai, dibatalkan
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_labs');
    }
};