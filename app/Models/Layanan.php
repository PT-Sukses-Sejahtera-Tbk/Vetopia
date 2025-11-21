<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'harga'];

    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class);
    }
}
