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

    /* Style untuk bagian ringkasan libur di bawah tabel */
    .summary-section {
        margin-top: 30px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        font-size: 0.9em; /* Ukuran font lebih kecil untuk ringkasan */
    }
    .summary-section h6 {
        margin-top: 0;
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }
    .summary-section ul {
        list-style: none; /* Hilangkan bullet point */
        padding-left: 0;
        margin-bottom: 0;
    }
    .summary-section ul li {
        margin-bottom: 5px;
        line-height: 1.4;
    }
    .summary-section ul li .libur-date {
        font-weight: bold;
        color: #000;
        margin-right: 5px;
    }
    .summary-section ul li .libur-name {
        color: #dc3545; /* Warna merah untuk nama libur */
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

            <h5>Data Absensi Bulan {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F') }} {{ $tahun }}</h5>

            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead >
                        <tr>
                            <th >Nama</th>
                            @foreach($harian as $hari) {{-- Gunakan $hari bukan $tanggal --}}
                                <th class="{{ $hari['is_libur'] ? 'bg-danger text-white' : '' }}">
                                    {{ \Carbon\Carbon::parse($hari['tanggal'])->format('d') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekap as $item)
                            <tr>
                                <td>{{ $item['nama'] }}</td>
                                @foreach($item['harian'] as $hari)
                                    <td class="{{ $hari['is_libur'] ? 'bg-danger text-white' : '' }}">
                                        {{ $hari['status'] }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            ---

            {{-- Bagian Ringkasan Hari Libur --}}
            <div class="summary-section">
                <h6>Informasi Hari Libur Bulan Ini:</h6>
                <ul>
                    @php
                        // Filter hanya tanggal yang benar-benar libur dan punya nama libur
                        $liburDetected = collect($harian)->filter(function($item) {
                            return $item['is_libur'] && $item['nama_libur'];
                        })->unique('tanggal'); // Pastikan tidak ada duplikasi jika ada hari libur ganda

                        // Sortir berdasarkan tanggal
                        $liburDetected = $liburDetected->sortBy('tanggal');
                    @endphp

                    @forelse ($liburDetected as $libur)
                        <li>
                            <span class="libur-date">{{ \Carbon\Carbon::parse($libur['tanggal'])->translatedFormat('d F Y') }} ({{ \Carbon\Carbon::parse($libur['tanggal'])->translatedFormat('l') }}):</span>
                            <span class="libur-name">{{ $libur['nama_libur'] }}</span>
                        </li>
                    @empty
                        <li>Tidak ada hari libur nasional atau Hari Minggu yang terdeteksi di bulan ini.</li>
                    @endforelse
                </ul>
            </div>


        </div>
    </div>
</div>
@endsection