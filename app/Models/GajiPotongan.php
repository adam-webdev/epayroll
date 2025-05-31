<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiPotongan extends Model
{
    protected $table = 'gaji_potongans';

    protected $fillable = [
        'gaji_id',
        'potongan_id',
        'jumlah_potongan',
    ];

    public function gaji()
    {
        return $this->belongsTo(Gaji::class);
    }

    public function potongan()
    {
        return $this->belongsTo(Potongan::class);
    }
}