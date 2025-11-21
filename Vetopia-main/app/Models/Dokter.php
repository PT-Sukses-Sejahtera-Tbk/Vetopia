<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = ['user_id', 'spesialisasi', 'deskripsi'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
