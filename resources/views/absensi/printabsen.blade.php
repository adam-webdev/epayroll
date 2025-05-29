@extends('layouts.templatepdf')

@section('content')

<style>
    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    .table th, .table td {
        border: 1px solid black;
        padding: 6px;
        text-align: center;
    }
    .table th {
        background-color: #f2f2f2;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .header img {
        height: 80px;
    }

    .header-title {
        flex-grow: 1;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
    }



</style>
    <hr>
   <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="text-align: center;">Data Rekapan Kehadiran Karyawan Bulan {{ \Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F') }}
         Tahun {{$tahun}}</h3>
        <br>
    </div>

@foreach($rekap as $karyawan)
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Nama : {{ $karyawan['nama'] }}</h3>
    </div>
    <table class="table table-bordered mb-4" style="font-size: 11px;">
    <thead>
        <tr>
            <th>Rekap Mingguan</th>
            <th>Hadir</th>
            <th>Izin</th>
            <th>Sakit</th>
            <th>Alpha</th>
            <th>Telat</th>
            <th>Kasbon</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalHadir = 0;
            $totalIzin = 0;
            $totalSakit = 0;
            $totalAlpha = 0;
            $totalTelat = 0;
            $totalKasbon = 0;
        @endphp

        @foreach($karyawan['minggu'] as $data)
            <tr>
                <td>{{ $data['periode'] }}</td>
                <td>{{ $data['hadir'] }}</td>
                <td>{{ $data['izin'] }}</td>
                <td>{{ $data['sakit'] }}</td>
                <td>{{ $data['alpha'] }}</td>
                <td>{{ $data['telat'] }}</td>
                <td>{{ number_format($data['kasbon'],0,0) }}</td>
            </tr>
            @php
                $totalHadir += $data['hadir'];
                $totalIzin += $data['izin'];
                $totalSakit += $data['sakit'];
                $totalAlpha += $data['alpha'];
                $totalTelat += $data['telat'];
                $totalKasbon += $data['kasbon'];
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>Total Keseluruhan</th>
            <th>{{ $totalHadir }}</th>
            <th>{{ $totalIzin }}</th>
            <th>{{ $totalSakit }}</th>
            <th>{{ $totalAlpha }}</th>
            <th>{{ $totalTelat }}</th>
            <th>{{ number_format($totalKasbon,0,0) }}</th>
        </tr>
    </tfoot>
</table>

    </table>
@endforeach

@endsection
