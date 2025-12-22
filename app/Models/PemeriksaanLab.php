<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanLab extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_labs';

    protected $fillable = [
        'user_id',
        'nama_pemilik',
        'nama_hewan',
        'umur',
        'spesies',
        'ras',
        'jenis_pemeriksaan',
        'keluhan_atau_alasan',
        'tanggal_booking',
        'status',
        'hasil_pemeriksaan',
        'catatan_dokter',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}