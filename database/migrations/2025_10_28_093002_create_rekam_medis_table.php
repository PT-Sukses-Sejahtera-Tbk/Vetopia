<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hewan_id')->constrained()->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained()->onDelete('cascade');
            $table->foreignId('layanan_id')->nullable()->constrained()->nullOnDelete();
            $table->date('tanggal_periksa');
            $table->text('diagnosa');
            $table->text('tindakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
