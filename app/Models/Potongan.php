<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    protected $table = 'potongans';

    protected $fillable = [
        'nama_potongan',
        'deskripsi',
        'status',
        'tipe',
        'nilai',
        'otomatis',
    ];

    public function gajiPotongans()
    {
        return $this->hasMany(GajiPotongan::class);
    }
}