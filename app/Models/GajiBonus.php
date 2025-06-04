<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiBonus extends Model
{
    protected $table = 'gaji_bonus';
    protected $fillable = [
        'gaji_id',
        'bonus_id',
        'jumlah_bonus',
    ];

    public function gaji()
    {
        return $this->belongsTo(Gaji::class);
    }

    public function bonus()
    {
        return $this->belongsTo(Bonus::class);
    }
    public function scopeActive($query)
    {
        return $query->whereHas('bonus', function ($q) {
            $q->where('status', 'Aktif');
        });
    }
}