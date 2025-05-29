<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    protected $table = 'slip_gajis';

    protected $fillable = [
        'gaji_id',
        'status',
        'nomor_slip',
    ];

    public function gaji()
    {
        return $this->belongsTo(Gaji::class);
    }
}