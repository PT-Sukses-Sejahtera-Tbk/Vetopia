<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Nama tabel: penitipan_hewan (singular/tunggal)
        Schema::create('penitipan_hewan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Informasi Pemilik (Otomatis)
            $table->string('nama_pemilik');
            
            // Informasi Hewan & Layanan
            $table->string('nama_hewan');
            $table->string('umur');
            $table->string('spesies');
            $table->string('ras');
            $table->text('alamat_rumah');
            
            // Tanggal
            $table->date('tanggal_titip');
            $table->date('tanggal_ambil');
            
            // Jenis Service (Pick-up / Drop-off)
            $table->string('jenis_service');
            
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penitipan_hewan');
    }
};