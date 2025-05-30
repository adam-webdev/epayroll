<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HariLibur extends Model
{
    protected $table = 'hari_liburs';

    protected $fillable = [
        'tanggal',
        'nama',
        'is_nasional',
        'tahun',
    ];

    public function gajis()
    {
        return $this->hasMany(Gaji::class);
    }
}