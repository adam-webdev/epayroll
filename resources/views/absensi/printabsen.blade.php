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
    @page {
        margin: 10mm 15mm 10mm 15mm; /* atas kanan bawah kiri */
    }


</style>
    <hr>
   <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Data Absensi Bulan {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F') }} {{ $tahun }}</h4>

        <br>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead >
                <tr>
                    <th >Nama</th>
                    @foreach($harian as $tanggal)
                    <th style="{{ $tanggal['is_libur'] ? 'background-color: #dc3545; color: white;' : '' }}">
                        {{ \Carbon\Carbon::parse($tanggal['tanggal'])->format('d') }}
                    </th>

                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($rekap as $item)
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        @foreach($item['harian'] as $hari)
                        <td style="{{ $hari['is_libur'] ? 'background-color: #dc3545; color: white;' : '' }}">
                            {{ $hari['status'] }}
                        </td>

                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


@endsection
