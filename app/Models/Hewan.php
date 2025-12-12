<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    protected $fillable = ['user_id', 'nama', 'jenis', 'umur', 'ras', 'photo'];

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
