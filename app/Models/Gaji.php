<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    protected $table = 'gajis';
    protected $fillable = [
        'karyawan_id',
        'bulan',
        'tahun',
        'gaji_pokok',
        'tunjangan',
        'potongan',
        'gaji_bersih',
        'status',
        'tanggal_input',
        'total_potongan'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
    // public function potongans()
    // {
    //     return $this->belongsToMany(Potongan::class, 'gaji_potongans', 'gaji_id', 'potongan_id')
    //         ->withPivot('nilai')
    //         ->withTimestamps();
    // }


    public function slipGaji()
    {
        return $this->hasOne(SlipGaji::class);
    }

    public function gajiPotongans()
    {
        return $this->hasMany(GajiPotongan::class);
    }
}