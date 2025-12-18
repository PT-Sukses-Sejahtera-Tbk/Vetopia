<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingKonsultasi extends Model
{
    use HasFactory;

    protected $table = 'booking_konsultasi';

    protected $fillable = [
        'user_id',
        'dokter_user_id',
        'nama_pemilik',
        'nama_hewan',
        'umur',
        'spesies',
        'ras',
        'keluhan',
        'tanggal_booking',
        'status',
    ];

    // Relasi balik ke User (pemilik hewan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Dokter (user dengan role doctor)
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_user_id');
    }
}