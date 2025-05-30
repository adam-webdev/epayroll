@extends('layouts.layoutmaster')
@section('title', 'Data Rekap Absensi Karyawan')
@section('css')
 <style>
    /* Style default untuk desktop */
    table tr td, table tr th {
        font-size: 14px;
    }

    /* Responsive untuk HP / layar kecil */
    @media (max-width: 576px) {
        table tr td, table tr th {
            font-size: 12px !important;
            padding: 6px 8px;
        }
        h5{
            font-size: 14px;
        }
        .grafik-text{
            font-size: 12px;
            text-decoration: underline!important;
        }
        select option{
            font-size: 12px !important;
        }
        .card-header {
            font-size: 13px;
            padding: 8px 12px;
        }
        h2 {
            font-size: 18px;
        }
        .btn {
            font-size: 12px;
            padding: 6px 12px;
        }
    }
</style>

@endsection
@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between ">
            <h5 class="card-title">Data Rekap Absensi Karyawan</h5>
            <div class="mt-2">
                <a class="btn btn-sm btn-success" href="{{route('absensi.pdf')}}"><i class='bx bxs-file-pdf'></i>Export Data</a>
            </div>
          </div>

            <form action="{{ route('absensi.rekap') }}" method="GET" class="mb-4 d-flex">
                <select name="bulan" class="form-select me-2" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" class="form-select me-2" required>
                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>

                <button type="submit" class="btn button-tambah">Filter</button>
            </form>

            @foreach($rekap as $karyawan)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>{{ $karyawan['nama'] }}</h5>
                    <div>
                        <a class="grafik-text" href="{{ route('grafik.kehadiran', ['karyawan_id' => $karyawan['karyawan_id']]) }}"><i class='bx bx-line-chart' style="font-size: 14px;"></i>Lihat Grafik </a>
                    </div>
                </div>
                <table class="table table-bordered mb-4">
                    <thead>
                        @php
                            $totalHadir = 0;
                            $totalIzin = 0;
                            $totalSakit = 0;
                            $totalAlpha = 0;
                        @endphp
                        <tr>
                            <th>Rekap Mingguan</th>
                            <th>Hadir</th>
                            <th>Izin</th>
                            <th>Sakit</th>
                            <th>Alpha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawan['minggu'] as $data)
                            <tr>
                                <td>{{ $data['periode'] }}</td>
                                <td>{{ $data['hadir'] }}</td>
                                <td>{{ $data['izin'] }}</td>
                                <td>{{ $data['sakit'] }}</td>
                                <td>{{ $data['alpha'] }}</td>
                            </tr>
                            @php
                                $totalHadir += $data['hadir'];
                                $totalIzin += $data['izin'];
                                $totalSakit += $data['sakit'];
                                $totalAlpha += $data['alpha'];
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Total Keseluruhan</strong></td>
                            <td><strong>{{ $totalHadir }}</strong></td>
                            <td><strong>{{ $totalIzin }}</strong></td>
                            <td><strong>{{ $totalSakit }}</strong></td>
                            <td><strong>{{ $totalAlpha }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            @endforeach

        </div>
    </div>
</div>
@endsection
