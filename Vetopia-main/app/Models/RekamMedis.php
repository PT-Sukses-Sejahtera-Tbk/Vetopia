<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $fillable = [
        'hewan_id',
        'dokter_id',
        'layanan_id',
        'tanggal_periksa',
        'diagnosa',
        'tindakan'
    ];

    public function hewan()
    {
        return $this->belongsTo(Hewan::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}
