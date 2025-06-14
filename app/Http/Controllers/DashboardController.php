<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\HariLibur;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\RawMaterial;
use App\Models\User;
use Carbon\Carbon;
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
        // Total Karyawan
        $totalKaryawan = Karyawan::count();

        // Total Jabatan
        $totalJabatan = Jabatan::count();

        // Hari Libur Bulan Ini
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $hariLiburBulanIni = HariLibur::whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->count();

        // Absensi Hari Ini
        $today = Carbon::today()->toDateString(); // Get today's date in 'YYYY-MM-DD' format
        $absensiHariIni = Absensi::whereDate('tanggal', $today)->count();

        // You can also get specific attendance statuses if needed, e.g.:
        $hadirHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status_kehadiran', 'Hadir')
            ->count();
        $izinHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status_kehadiran', 'Izin')
            ->count();
        $sakitHariIni = Absensi::whereDate('tanggal', $today)
            ->where('status_kehadiran', 'Sakit')
            ->count();

        return view('dashboard', compact(
            'totalKaryawan',
            'totalJabatan',
            // 'hariLiburBulanIni',
            'absensiHariIni',
            'hadirHariIni', // Optional: if you want to show specific attendance types
            'izinHariIni',  // Optional: if you want to show specific attendance types
            'sakitHariIni'  // Optional: if you want to show specific attendance types
        ));
    }
}
