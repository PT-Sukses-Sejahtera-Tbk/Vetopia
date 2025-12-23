<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemeriksaan_labs', function (Blueprint $table) {
            // Menambahkan kolom hasil pemeriksaan dan catatan dokter
            // after('status') berfungsi agar kolom baru muncul urut setelah kolom status
            $table->text('hasil_pemeriksaan')->nullable()->after('status');
            $table->text('catatan_dokter')->nullable()->after('hasil_pemeriksaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_labs', function (Blueprint $table) {
            $table->dropColumn(['hasil_pemeriksaan', 'catatan_dokter']);
        });
    }
};