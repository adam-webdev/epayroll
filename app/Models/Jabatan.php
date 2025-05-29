<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatans';

    protected $fillable = [
        'nama_jabatan',
        'deskripsi',
        'status',
        'gaji_pokok',
        'tunjangan_jabatan',
    ];

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}