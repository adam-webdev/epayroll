<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KasbonController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PotonganController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RawMaterialController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiStokController;
use App\Http\Controllers\UserController;
use App\Models\Gaji;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('karyawan', KaryawanController::class);


    Route::resource('absensi', AbsensiController::class);
    Route::get('/absensi/{tanggal}/edit', [AbsensiController::class, 'edit'])->name('absensi.edit');
    Route::put('/absensi/{tanggal}', [AbsensiController::class, 'update'])->name('absensi.update');
    Route::get('/rekapan-absensi', [AbsensiController::class, 'rekapabsensi'])->name('absensi.rekap');
    Route::get('/grafik/{karyawan_id}', [AbsensiController::class, 'grafikKehadiran'])->name('grafik.kehadiran');
    Route::get('/export-absensi', [AbsensiController::class, 'cetakPdf'])->name('absensi.pdf');
    Route::post('/export-absensi', [AbsensiController::class, 'exportData'])->name('absensi.cetaknow');

    // Jabatan
    Route::resource('jabatan', JabatanController::class);


    // Potongan
    Route::resource('potongan', PotonganController::class);

    // Gaji
    Route::resource('gaji', GajiController::class);
});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');