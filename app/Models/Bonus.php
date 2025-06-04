<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $table = 'bonuses';
    protected $fillable = [
        'nama_bonus',
        'deskripsi',
        'status',
        'tipe',
        'nilai',
        'otomatis',
    ];

    public function gajiBonuses()
    {
        return $this->hasMany(GajiBonus::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Aktif');
    }
}