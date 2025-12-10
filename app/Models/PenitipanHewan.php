<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenitipanHewan extends Model
{
    use HasFactory;

    protected $table = 'penitipan_hewan';

    protected $fillable = [
        'user_id',
        'nama_pemilik',
        'nama_hewan',
        'umur',
        'spesies',
        'ras',
        'alamat_rumah',
        'tanggal_titip',
        'tanggal_ambil',
        'jenis_service',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}