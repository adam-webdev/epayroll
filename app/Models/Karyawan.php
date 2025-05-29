<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';
    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_lahir' => 'date',
    ];

    protected $fillable = [
        'nama',
        'nik',
        'jabatan_id',
        'tanggal_masuk',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'agama',
        'jenis_kelamin',
        'status_karyawan',
        'status_kawin',
        'email',
        'foto',
        'user_id', // Assuming you have a user_id to link to the User model
    ];

    public function gajis()
    {
        return $this->hasMany(Gaji::class);
    }
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/default-avatar.png');
    }
}