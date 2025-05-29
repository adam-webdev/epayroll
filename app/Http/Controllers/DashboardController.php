<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\RawMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $latestMasuk = 0;

        $latestKeluar = 0;

        $totalNilaiStok = 0;
        $jumlahKaryawan = 0; // sesuaikan kalau ada role tertentu
        $jumlahRawMaterial = 0;

        return view('dashboard', [
            'latestMasuk' => $latestMasuk,
            'latestKeluar' => $latestKeluar,
            'totalAssetStok' => $totalNilaiStok,
            'jumlahKaryawan' => $jumlahKaryawan,
            'jumlahRawMaterial' => $jumlahRawMaterial,

        ]);
    }
}