<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Karyawan;
use App\Models\Kasbon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;


class AbsensiController extends Controller
{

    public function index()
    {
        // Mengambil rekap absensi dengan total karyawan per tanggal
        $absensis = DB::table('absensis')
            ->select('tanggal', DB::raw('COUNT(karyawan_id) as total_karyawan'))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();

        // return view('absensi.index', compact('absensis'));
        // $absensi = Absensi::with('karyawan')->orderBy('created_at', 'desc')->get();
        return view('absensi.index', compact('absensis'));
    }


    public function create()
    {
        $karyawans = Karyawan::where('status', 'Aktif')->get();
        return view('absensi.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        if (Absensi::where('tanggal', $request->tanggal)->exists()) {
            return redirect()->back()->with('error', 'Absensi untuk tanggal ini sudah ada.');
        }


        $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.karyawan_id' => 'required',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpha',
            'absensi.*.telat' => 'nullable|integer',
            'absensi.*.keterangan' => 'nullable|string',
        ]);

        foreach ($request->absensi as $item) {
            if ($item['telat'] > 15) {
                $telat = 15;
            } else {
                $telat =  $item['telat'];
            }
            Absensi::create([
                'karyawan_id' => $item['karyawan_id'],
                'tanggal' => $request->tanggal,
                'status_kehadiran' => $item['status'],        // pakai data dari form
                'telat' => $telat,        // pakai data dari form
                'keterangan' => $item['keterangan'] // pakai data dari form
            ]);
        }
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function show($id)
    {
        // Logic to display a specific absence
    }

    // Menampilkan form edit
    public function edit($tanggal)
    {
        $absensis = Absensi::with('karyawan')
            ->where('tanggal', $tanggal)
            ->get();

        return view('absensi.edit', compact('tanggal', 'absensis'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.karyawan_id' => 'required',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpha',
            'absensi.*.telat' => 'nullable|integer',
            'absensi.*.keterangan' => 'nullable|string',
        ]);

        foreach ($request->absensi as $item) {
            Absensi::where('tanggal', $id)->where('karyawan_id', $item['karyawan_id'])->update([
                'status_kehadiran' => $item['status'],
                'telat' => $item['telat'],
                'keterangan' => $item['keterangan']
            ]);
        }
        if ($request->tanggal) {
            Absensi::where('tanggal', $id)->update([
                'tanggal' => $request->tanggal
            ]);
        }


        return redirect()->route('absensi.index')->with(
            'success',
            'Absensi berhasil diperbarui.'
        );
    }

    public function destroy($tanggal)
    {
        $absensi = Absensi::where('tanggal', $tanggal)->delete();
        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil dihapus.');
    }


    public function rekapabsensi(Request $request)
    {
        $bulan = $request->input('bulan') ?? Carbon::now()->month;
        $tahun = $request->input('tahun') ?? Carbon::now()->year;

        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $karyawans = Karyawan::orderBy('nama')->get();

        // Hitung minggu dalam bulan
        $weeks = [];
        $current = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY); // Awal minggu Senin
        while ($current <= $endOfMonth) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->endOfWeek(Carbon::SUNDAY);
            if ($weekEnd > $endOfMonth) $weekEnd = $endOfMonth;

            $weeks[] = [
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d'),
            ];

            $current->addWeek();
        }

        $rekap = [];
        foreach ($karyawans as $karyawan) {
            $total_kasbon = 0;
            $data = [
                'nama' => $karyawan->nama,
                'karyawan_id' => $karyawan->id,
                'minggu' => [],
            ];

            foreach ($weeks as $week) {

                $kasbon_minggu = Kasbon::where('karyawan_id', $karyawan->id)
                    ->whereBetween('tanggal', [$week['start'], $week['end']])
                    ->sum('jumlah');

                $total_kasbon += $kasbon_minggu;

                $data['minggu'][] = [
                    'periode' => Carbon::parse($week['start'])->translatedFormat('l, d F Y') . ' s/d ' . Carbon::parse($week['end'])->translatedFormat('l, d F Y'),
                    'hadir' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Hadir')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'izin' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Izin')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'sakit' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Sakit')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'alpha' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Alpha')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),
                    'telat' => Absensi::where('karyawan_id', $karyawan->id)
                        ->whereNotNull('telat')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->sum('telat'),

                    'kasbon' => $kasbon_minggu, //  kasbon per minggu
                ];
            }
            $data['total_kasbon'] = $total_kasbon; // total kasbon sebulan per karyawan
            $rekap[] = $data;
        }
        // dd($rekap);
        return view('absensi.rekap', compact('rekap', 'weeks', 'bulan', 'tahun'));
    }

    public function grafikKehadiran(Request $request)
    {
        $tahun = $request->tahun ?? date('Y');
        $karyawanId = $request->karyawan_id;

        $karyawan = Karyawan::findOrFail($karyawanId);

        $data = [
            'hadir' => [],
            'izin' => [],
            'sakit' => [],
            'alpha' => [],
        ];

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            $data['hadir'][] = Absensi::where('karyawan_id', $karyawanId)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status_kehadiran', 'Hadir')
                ->count();

            $data['izin'][] = Absensi::where('karyawan_id', $karyawanId)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status_kehadiran', 'Izin')
                ->count();

            $data['sakit'][] = Absensi::where('karyawan_id', $karyawanId)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status_kehadiran', 'Sakit')
                ->count();

            $data['alpha'][] = Absensi::where('karyawan_id', $karyawanId)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->where('status_kehadiran', 'Alpha')
                ->count();
        }

        return view('absensi.grafik', compact('data', 'tahun', 'karyawan'));
    }

    public function cetakPdf()
    {
        $bulan = Carbon::now()->month;
        $tahun = Carbon::now()->year;

        return view('absensi.formcetakpdf', compact('bulan', 'tahun'));
    }
    public function cetakRekapPdf(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
        ]);

        $tanggal = Carbon::parse($request->tanggal)->format('Y-m-d');

        $absensi = Absensi::where('tanggal', $tanggal)->with('karyawan')->get();

        return view('absensi.cetakpdf', compact('absensi', 'tanggal'));
    }

    public function exportData(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $submit = $request->export;

        if ($submit == 'pdf') {
            return $this->postCetakPdf($bulan, $tahun);
        } elseif ($submit == 'excel') {
            return $this->postCetakExcel($bulan, $tahun);
        }

        return back();
    }

    public function postCetakPdf($param_bulan, $param_tahun)
    {
        $bulan = (int) $param_bulan ?? Carbon::now()->month;
        $tahun = (int) $param_tahun ?? Carbon::now()->year;

        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $karyawans = Karyawan::orderBy('nama')->get();

        // Hitung minggu dalam bulan
        $weeks = [];
        $current = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY); // Awal minggu Senin
        while ($current <= $endOfMonth) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->endOfWeek(Carbon::SUNDAY);
            if ($weekEnd > $endOfMonth) $weekEnd = $endOfMonth;

            $weeks[] = [
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d'),
            ];

            $current->addWeek();
        }

        $rekap = [];
        foreach ($karyawans as $karyawan) {
            $total_kasbon = 0;

            $data = [
                'nama' => $karyawan->nama,
                'karyawan_id' => $karyawan->id,
                'minggu' => [],
            ];

            foreach ($weeks as $week) {
                $kasbon_minggu = Kasbon::where('karyawan_id', $karyawan->id)
                    ->whereBetween('tanggal', [$week['start'], $week['end']])
                    ->sum('jumlah');

                $total_kasbon += $kasbon_minggu;
                $data['minggu'][] = [
                    'periode' => Carbon::parse($week['start'])->translatedFormat('l, d F Y') . ' s/d ' . Carbon::parse($week['end'])->translatedFormat('l, d F Y'),
                    'hadir' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Hadir')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'izin' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Izin')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'sakit' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Sakit')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'alpha' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Alpha')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),
                    'telat' => Absensi::where('karyawan_id', $karyawan->id)
                        ->whereNotNull('telat')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->sum('telat'),
                    'kasbon' => $kasbon_minggu, //  kasbon per minggu
                ];
            }
            $data['total_kasbon'] = $total_kasbon; // total kasbon
            $rekap[] = $data;
        }
        // Generate PDF
        $pdf = PDF::loadView('absensi.printabsen', compact('rekap', 'weeks', 'bulan', 'tahun'))->setPaper('A4');

        // Opsi download atau stream
        return $pdf->stream('rekap-absensi-' . $bulan . '-' . $tahun . '.pdf');
        // atau return $pdf->stream(); untuk preview di browser
    }



    public function postCetakExcel($param_bulan, $param_tahun)
    {

        $bulan = (int) $param_bulan;
        $tahun = (int) $param_tahun;

        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $karyawans = Karyawan::orderBy('nama')->get();

        // Hitung minggu dalam bulan
        $weeks = [];
        $current = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        while ($current <= $endOfMonth) {
            $weekStart = $current->copy();
            $weekEnd = $current->copy()->endOfWeek(Carbon::SUNDAY);
            if ($weekEnd > $endOfMonth) $weekEnd = $endOfMonth;

            $weeks[] = [
                'start' => $weekStart->format('Y-m-d'),
                'end' => $weekEnd->format('Y-m-d'),
            ];

            $current->addWeek();
        }

        $rekap = [];
        foreach ($karyawans as $karyawan) {
            $total_kasbon = 0;

            $data = [
                'nama' => $karyawan->nama,
                'karyawan_id' => $karyawan->id,
                'minggu' => [],
            ];

            foreach ($weeks as $week) {
                $kasbon_minggu = Kasbon::where('karyawan_id', $karyawan->id)
                    ->whereBetween('tanggal', [$week['start'], $week['end']])
                    ->sum('jumlah');

                $total_kasbon += $kasbon_minggu;
                $data['minggu'][] = [
                    'periode' => Carbon::parse($week['start'])->translatedFormat('l, d F Y') . ' s/d ' . Carbon::parse($week['end'])->translatedFormat('l, d F Y'),
                    'hadir' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Hadir')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'izin' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Izin')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'sakit' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Sakit')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),

                    'alpha' => Absensi::where('karyawan_id', $karyawan->id)
                        ->where('status_kehadiran', 'Alpha')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->count(),
                    'telat' => Absensi::where('karyawan_id', $karyawan->id)
                        ->whereNotNull('telat')
                        ->whereBetween('tanggal', [$week['start'], $week['end']])
                        ->sum('telat'),
                    'kasbon' => $kasbon_minggu, //  kasbon per minggu
                ];
            }
            $data['total_kasbon'] = $total_kasbon; // total kasbon

            $rekap[] = $data;
        }


        // Membuat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Absensi');

        // Header Perusahaan (Baris 1-3)
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'PT. Splatinum Skyreach Indonesia');
        $sheet->getStyle('A1')->getFont()
            ->setBold(true)
            ->setSize(16)
            ->setName('Arial');

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', 'Kec. Rawalumbu, Bekasi Timur, Jawa Barat 17115');
        $sheet->getStyle('A2')->getFont()
            ->setBold(false)
            ->setSize(12);


        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', 'Telp: 0812 1415 5598 | Email: marketing@splatinum.co.id | Website: www.splatinum.co.id');
        $sheet->getStyle('A3')->getFont()
            ->setBold(false)
            ->setSize(10);

        // Style alignment untuk header perusahaan
        $sheet->getStyle('A1:I3')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Jarak antara header perusahaan dan judul laporan
        $sheet->setCellValue('A4', ''); // Baris kosong

        // Judul Laporan (Baris 5)
        $sheet->mergeCells('A5:I5');
        $sheet->setCellValue('A5', 'Laporan Rekap Absensi Bulan ' . Carbon::create()->month($bulan)->locale('id')->monthName . ' Tahun ' . $tahun);
        $sheet->getStyle('A5')->getFont()
            ->setBold(true)
            ->setSize(14);
        $sheet->getStyle('A5')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Baris kosong sebelum header tabel
        $sheet->setCellValue('A6', '');

        // Header Kolom Tabel (Baris 7) - Kolom A untuk No
        $headers = ['No', 'Nama Karyawan', 'Periode Minggu', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Telat', 'Kasbon'];
        $sheet->fromArray($headers, null, 'A7');

        // Style untuk header tabel
        $headerTableStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A7:I7')->applyFromArray($headerTableStyle);

        $row = 8;
        $no = 1;

        foreach ($rekap as $data) {
            $totalHadir = 0;
            $totalIzin = 0;
            $totalSakit = 0;
            $totalAlpha = 0;
            $totalTelat = 0;
            $totalKasbon = 0;

            foreach ($data['minggu'] as $minggu) {
                // Nomor urut
                $sheet->setCellValue('A' . $row, $no);

                // Data mingguan
                $sheet->setCellValue('B' . $row, $data['nama']);
                $sheet->setCellValue('C' . $row, $minggu['periode']);
                $sheet->setCellValue('D' . $row, $minggu['hadir']);
                $sheet->setCellValue('E' . $row, $minggu['izin']);
                $sheet->setCellValue('F' . $row, $minggu['sakit']);
                $sheet->setCellValue('G' . $row, $minggu['alpha']);
                $sheet->setCellValue('H' . $row, $minggu['telat']);
                $sheet->setCellValue('I' . $row, $minggu['kasbon']);

                // Akumulasi
                $totalHadir += $minggu['hadir'];
                $totalIzin += $minggu['izin'];
                $totalSakit += $minggu['sakit'];
                $totalAlpha += $minggu['alpha'];
                $totalTelat += $minggu['telat'];
                $totalKasbon += $minggu['kasbon'];

                $row++;
                $no++;
            }

            // Merge kolom A–C dan isi "Total Kehadiran Bulanan"
            $sheet->mergeCells("A$row:C$row");
            $sheet->setCellValue('A' . $row, 'Total Keseluruhan');

            // Total per karyawan
            $sheet->setCellValue('D' . $row, $totalHadir);
            $sheet->setCellValue('E' . $row, $totalIzin);
            $sheet->setCellValue('F' . $row, $totalSakit);
            $sheet->setCellValue('G' . $row, $totalAlpha);
            $sheet->setCellValue('H' . $row, $totalTelat);
            $sheet->setCellValue('I' . $row, $totalKasbon);

            // Format bold untuk baris total
            $sheet->getStyle("A$row:I$row")->getFont()->setBold(true);
            $sheet->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            $row++; // Pindah baris
        }


        // Style untuk data
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'horizontal' => Alignment::HORIZONTAL_CENTER // Center untuk nomor urut
            ]
        ];
        $sheet->getStyle('A8:I' . ($row - 1))->applyFromArray($dataStyle);

        // Khusus untuk kolom B (Nama Karyawan), alignment left
        $sheet->getStyle('B8:B' . ($row - 1))->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_LEFT);

        // Auto size kolom
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set tinggi baris untuk header perusahaan
        $sheet->getRowDimension(1)->setRowHeight(25);
        $sheet->getRowDimension(2)->setRowHeight(20);
        $sheet->getRowDimension(3)->setRowHeight(18);


        // Set output ke XLSX
        $filename = 'rekap-absensi-' . $bulan . '-' . $tahun . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->setPreCalculateFormulas(false);
        $writer->save('php://output');
        exit;
    }
}
