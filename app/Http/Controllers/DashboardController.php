<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\RawMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function testEmail()
    {
        Mail::raw('Ini adalah email uji coba.', function ($message) {
            $message->to('adamdwimaulana2605@gmail.com')->subject('Uji Coba Mailtrap');
        });
        return "Email uji coba telah dikirim (ke Gmail).";
    }

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