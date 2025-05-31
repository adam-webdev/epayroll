<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Gaji;
use App\Models\GajiPotongan;
use App\Models\HariLibur;
use App\Models\Karyawan;
use App\Models\Potongan;
use App\Models\SlipGaji;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        // $bulan = (int) ($request->bulan ?? now()->format('m'));
        // $tahun = (int) ($request->tahun ?? now()->format('Y'));

        // $gaji = Gaji::with([
        //     'karyawan.absensis' => function ($query) use ($bulan, $tahun) {
        //         $query->whereMonth('tanggal', $bulan)
        //             ->whereYear('tanggal', $tahun);
        //     },
        //     'gajiPotongans.potongan'
        // ])->where('bulan', $bulan)
        //     ->where('tahun', $tahun)
        //     ->get();


        $gajis = Gaji::selectRaw('bulan, tahun, SUM(gaji_bersih) as total_gaji, MAX(status) as status')
            ->groupBy('bulan', 'tahun')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get();


        return view('gaji.index', compact('gajis'));
    }

    // public function index()
    // {


    //     $gaji = Gaji::with(['karyawan', 'gajiPotongans.potongans', 'slipGaji', 'gajiPotongans'])->whereHas('karyawan', function ($query) {
    //         $query->where('status_karyawan', 'Aktif');
    //     })->get();
    //     // dd($gaji);
    //     return view('gaji.index', compact('gaji'));
    // }
    public function create()
    {
        // Logika untuk menampilkan form tambah gaji
        return view('gaji.create');
    }

    public function generateGaji(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2020',
        ]);

        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;

        $startDate = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $endDate = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $hariLibur = HariLibur::whereBetween('tanggal', [$startDate, $endDate])
            ->pluck('tanggal')
            ->map(fn($tgl) => $tgl->format('Y-m-d'))
            ->toArray();

        $potonganTetapList = Potongan::where('status', 'Aktif')->where('otomatis', 1)->get();
        $potonganAbsensiMaster = Potongan::where('nama_potongan', 'Absensi')->first();

        $karyawans = Karyawan::with('jabatan')->where('status_karyawan', 'Aktif')->get();

        foreach ($karyawans as $karyawan) {
            $gajiPokok = $karyawan->jabatan->gaji_pokok ?? 0;
            $tunjangan = $karyawan->jabatan->tunjangan_jabatan ?? 0;

            // Hitung hari kerja aktual
            $hariKerja = 0;
            $tanggal = $startDate->copy();
            while ($tanggal <= $endDate) {
                if (!$tanggal->isSunday() && !in_array($tanggal->format('Y-m-d'), $hariLibur)) {
                    $hariKerja++;
                }
                $tanggal->addDay();
            }

            $gajiPerHari = $hariKerja > 0 ? $gajiPokok / $hariKerja : 0;

            // Hitung ketidakhadiran
            $jumlahTidakHadir = Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', $startDate->month)
                ->whereYear('tanggal', $tahun)
                ->whereIn('status_kehadiran', ['Alpha', 'Izin', 'Sakit'])
                ->count();

            $potonganAbsensi = round($jumlahTidakHadir * $gajiPerHari);

            $totalPotonganTetap = 0;
            $gajiPotongans = [];

            foreach ($potonganTetapList as $potongan) {
                $jumlahPotongan = 0;
                if ($potongan->tipe === 'nominal') {
                    $jumlahPotongan = $potongan->nilai;
                } elseif ($potongan->tipe === 'persentase') {
                    $jumlahPotongan = ($gajiPokok * $potongan->nilai) / 100;
                }

                $jumlahPotongan = round($jumlahPotongan);

                if ($jumlahPotongan > 0) {
                    $totalPotonganTetap += $jumlahPotongan;

                    $gajiPotongans[] = [
                        'potongan_id' => $potongan->id,
                        'jumlah_potongan' => $jumlahPotongan,
                    ];
                }
            }

            if ($potonganAbsensi > 0 && $potonganAbsensiMaster) {
                $gajiPotongans[] = [
                    'potongan_id' => $potonganAbsensiMaster->id,
                    'jumlah_potongan' => $potonganAbsensi,
                ];
            }

            $totalPotongan = $totalPotonganTetap + $potonganAbsensi;
            $gajiBersih = $gajiPokok + $tunjangan - $totalPotongan;

            // Simpan ke tabel gaji
            $gaji = Gaji::create([
                'karyawan_id' => $karyawan->id,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'gaji_pokok' => round($gajiPokok),
                'tunjangan' => round($tunjangan),
                'total_potongan' => $totalPotongan,
                'gaji_bersih' => $gajiBersih,
                'status' => 'Draft',
                'tanggal_input' => now(),
            ]);

            // Simpan potongan ke tabel gaji_potongans
            foreach ($gajiPotongans as $gp) {
                GajiPotongan::create([
                    'gaji_id' => $gaji->id,
                    'potongan_id' => $gp['potongan_id'],
                    'jumlah_potongan' => $gp['jumlah_potongan'],
                ]);
            }

            // Simpan slip gaji
            SlipGaji::create([
                'gaji_id' => $gaji->id,
                'nomor_slip' => strtoupper('SLIP-' . Str::random(8)),
                'status' => 'Belum Dikirim',
            ]);
        }

        return redirect()->back()->with('success', 'Gaji berhasil digenerate untuk bulan ' . $bulan . ' ' . $tahun);
    }

    public function show($bulan, $tahun)
    {
        $gaji = Gaji::where('bulan', $bulan)->where('tahun', $tahun)->firstOrFail();
        return view('gaji.show', compact('gaji'));
    }

    public function edit($bulan, $tahun)
    {
        $gaji = Gaji::where('bulan', $bulan)->where('tahun', $tahun)->firstOrFail();
        return view('gaji.edit', compact('gaji'));
    }

    public function destroy($bulan, $tahun)
    {
        $gaji = Gaji::where('bulan', $bulan)->where('tahun', $tahun)->firstOrFail();
        $gaji->delete();

        return redirect()->route('gaji.index')->with('success', 'Gaji berhasil dihapus.');
    }

    // public function generateGaji(Request $request)
    // {
    //     $bulan = $request->bulan; // Contoh: 'Mei'
    //     $tahun = $request->tahun;

    //     $potonganAlpha = Potongan::where('nama', 'Alpha')->first(); // contoh potongan wajib

    //     $karyawans = Karyawan::with('jabatan')->get();

    //     foreach ($karyawans as $karyawan) {
    //         $gajiPokok = $karyawan->jabatan->gaji_pokok ?? 0;
    //         $tunjangan = $karyawan->jabatan->tunjangan ?? 0;

    //         // Hitung absensi alpha
    //         $jumlahAlpha = Absensi::where('karyawan_id', $karyawan->id)
    //             ->whereMonth('tanggal', Carbon::parse('01 ' . $bulan . ' ' . $tahun)->month)
    //             ->whereYear('tanggal', $tahun)
    //             ->where('status_kehadiran', 'Alpha')
    //             ->count();

    //         $jumlahPotongan = 0;
    //         if ($potonganAlpha && $jumlahAlpha > 0) {
    //             $jumlahPotongan = $jumlahAlpha * $potonganAlpha->jumlah;
    //         }

    //         $gajiBersih = $gajiPokok + $tunjangan - $jumlahPotongan;

    //         // Simpan ke tabel gajis
    //         $gaji = Gaji::create([
    //             'karyawan_id' => $karyawan->id,
    //             'bulan' => $bulan,
    //             'tahun' => $tahun,
    //             'gaji_pokok' => $gajiPokok,
    //             'tunjangan' => $tunjangan,
    //             'total_potongan' => $jumlahPotongan,
    //             'gaji_bersih' => $gajiBersih,
    //             'status' => 'Draft',
    //             'tanggal_input' => now(),
    //         ]);

    //         // Simpan ke gaji_potongans (khusus potongan alpha)
    //         if ($jumlahPotongan > 0 && $potonganAlpha) {
    //             GajiPotongan::create([
    //                 'gaji_id' => $gaji->id,
    //                 'potongan_id' => $potonganAlpha->id,
    //                 'jumlah_potongan' => $jumlahPotongan,
    //             ]);
    //         }

    //         // Simpan slip gaji
    //         SlipGaji::create([
    //             'gaji_id' => $gaji->id,
    //             'nomor_slip' => strtoupper('SLIP-' . Str::random(8)),
    //             'status' => 'Belum Dikirim',
    //         ]);
    //     }

    //     return redirect()->back()->with('success', 'Gaji berhasil digenerate untuk bulan ' . $bulan . ' ' . $tahun);
    // }
}