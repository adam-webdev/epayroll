@extends('layouts.layoutmaster')
@section('title', 'Riwayat Gaji Anda')
@section('content')
@section('css')
    <style>
        /* Mengatur font dasar untuk isi slip gaji */
        .slip-gaji-content {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9em; /* Huruf sedikit lebih kecil */
        }

        /* Styling untuk judul bagian */
        .slip-gaji-content h6 {
            font-weight: 600;
            color: #34495e; /* Warna gelap tapi tidak hitam pekat */
            margin-top: 1.2em;
            margin-bottom: 0.5em;
            font-size: 1em; /* Ukuran h6 normal */
            border-bottom: 1px solid #eee; /* Garis bawah tipis untuk judul bagian */
            padding-bottom: 0.3em;
        }

        /* Styling untuk item daftar gaji */
        .list-group-item {
            padding: 0.4rem 1rem; /* Padding lebih kecil lagi */
            border: none; /* Hilangkan border item default */
            background-color: transparent; /* Transparan */
            display: flex; /* Untuk mensejajarkan label dan nilai */
            justify-content: space-between; /* Untuk meletakkan nilai di kanan */
            align-items: center;
        }

        .list-group-item .item-label {
            color: #2c3e50; /* Warna lebih gelap untuk label */
            font-weight: 500;
            display: flex; /* Untuk ikon dan teks label */
            align-items: center;
        }
        .list-group-item .item-label i {
            margin-right: 0.6em; /* Spasi antara ikon dan teks */
            color: #888;
            font-size: 1.1em; /* Ukuran ikon */
        }
        .list-group-item .item-value {
            font-weight: 500;
            color: #34495e;
        }

        /* Warna untuk gaji bersih */
        .text-gaji-bersih {
            color: #28a745 !important; /* Hijau yang lebih cerah */
            font-weight: 700 !important;
            font-size: 1.2em; /* Lebih besar untuk gaji bersih */
        }

        /* Warna untuk nominal potongan */
        .item-value.potongan-amount {
            color: #e74c3c; /* Warna merah untuk potongan */
        }

        /* Warna untuk nominal bonus (baru) */
        .item-value.bonus-amount {
            color: #007bff; /* Warna biru untuk bonus */
        }

        /* Styling untuk accordion header */
        .accordion-button {
            font-weight: 600;
            font-size: 1.05em;
            color: #2c3e50;
            background-color: #f8f9fa; /* Warna latar sedikit abu-abu */
            border-radius: 0.5rem !important; /* Sudut lebih membulat */
            padding: 0.8rem 1.25rem;
        }

        .accordion-button:not(.collapsed) {
            color: #0056b3; /* Warna biru saat aktif */
            background-color: #e2f0ff; /* Latar biru muda saat aktif */
            box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .08);
        }

        /* Styling untuk accordion body */
        .accordion-body {
            padding: 1.5rem;
            background-color: #ffffff;
            border-top: 1px solid #dee2e6;
        }
    </style>
@endsection

<div class="container py-4">
    <div class="card shadow rounded-4 p-4">
        <div class="container slip-gaji-content">
            <h4 class="mb-4 text-center" style="font-weight: 700; color: #2c3e50;">
                Riwayat Gaji Anda
            </h4>
            <p class="text-center text-muted mb-4" style="font-size: 0.9em;">
                Daftar semua slip gaji yang telah Anda terima.
            </p>

            {{-- Pesan sukses/error/warning --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif

            @if($karyawan)
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="card-title text-primary">Informasi Anda</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="item-label"><i class='bx bx-user'></i> Nama</span>
                                <span class="item-value">{{ $karyawan->nama }}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="item-label"><i class='bx bx-id-card'></i> NIK</span>
                                <span class="item-value">{{ $karyawan->nik }}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="item-label"><i class='bx bx-briefcase'></i> Jabatan</span>
                                <span class="item-value">{{ $karyawan->jabatan->nama_jabatan ?? '-' }}</span>
                            </li>
                             <li class="list-group-item">
                                <span class="item-label"><i class='bx bx-envelope'></i> Email</span>
                                <span class="item-value">{{ $karyawan->email }}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="item-label"><i class='bx bx-phone'></i> No. HP</span>
                                <span class="item-value">{{ $karyawan->no_hp }}</span>
                            </li>
                            <li class="list-group-item">
                                <span class="item-label"><i class='bx bx-map'></i> Alamat</span>
                                <span class="item-value">{{ $karyawan->alamat }}</span>
                            </li>
                            {{-- Tambahkan info karyawan lain yang relevan --}}
                        </ul>
                    </div>
                </div>

                @if($riwayatGajiKaryawan->isNotEmpty())
                    <h5 class="mb-3">Detail Slip Gaji Per Bulan:</h5>
                    <div class="accordion" id="riwayatGajiAccordion">
                        @foreach ($riwayatGajiKaryawan as $gajiItem)
                        <div class="accordion-item mb-3 rounded-3 border">
                            <h6 class="accordion-header" id="headingGaji{{ $gajiItem->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGaji{{ $gajiItem->id }}" aria-expanded="false" aria-controls="collapseGaji{{ $gajiItem->id }}">
                                    <i class='bx bx-calendar me-2'></i>
                                    Gaji Bulan {{ \Carbon\Carbon::createFromDate($gajiItem->tahun, $gajiItem->bulan, 1)->translatedFormat('F Y') }}
                                    <span class="badge bg-info ms-3">Rp {{ number_format($gajiItem->gaji_bersih, 0, ',', '.') }}</span>
                                </button>
                            </h6>
                            <div id="collapseGaji{{ $gajiItem->id }}" class="accordion-collapse collapse" aria-labelledby="headingGaji{{ $gajiItem->id }}" data-bs-parent="#riwayatGajiAccordion">
                                <div class="accordion-body">
                                    <h6 class="text-success">Penghasilan</h6>
                                    <ul class="list-group mb-4">
                                        <li class="list-group-item">
                                            <span class="item-label"><i class='bx bx-money'></i> Gaji Pokok</span>
                                            <span class="item-value">Rp {{ number_format($gajiItem->gaji_pokok, 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="item-label"><i class='bx bx-wallet-alt'></i> Tunjangan</span>
                                            <span class="item-value">Rp {{ number_format($gajiItem->tunjangan, 0, ',', '.') }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="item-label"><i class='bx bx-gift'></i> Total Bonus</span>
                                            <span class="item-value bonus-amount">Rp {{ number_format($gajiItem->total_bonus, 0, ',', '.') }}</span>
                                        </li>
                                        @if($gajiItem->gajiBonuses->isNotEmpty())
                                            @foreach ($gajiItem->gajiBonuses as $bonusItem)
                                            <li class="list-group-item ps-4">
                                                <span class="item-label"><i class='bx bx-chevrons-right'></i> {{ $bonusItem->bonus->nama_bonus ?? 'Tidak Ditemukan' }}</span>
                                                <span class="item-value bonus-amount">Rp {{ number_format($bonusItem->jumlah_bonus, 0, ',', '.') }}</span>
                                            </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item ps-4">
                                                <span class="item-label">Tidak ada rincian bonus.</span>
                                            </li>
                                        @endif
                                    </ul>

                                    <h6 class="text-danger">Potongan</h6>
                                    <ul class="list-group mb-4">
                                        <li class="list-group-item">
                                            <span class="item-label"><i class='bx bx-minus-circle'></i> Total Potongan</span>
                                            <span class="item-value potongan-amount">Rp {{ number_format($gajiItem->total_potongan, 0, ',', '.') }}</span>
                                        </li>
                                        @if($gajiItem->gajiPotongans->isNotEmpty())
                                            @foreach ($gajiItem->gajiPotongans as $potonganItem)
                                            <li class="list-group-item ps-4">
                                                <span class="item-label"><i class='bx bx-chevrons-right'></i> {{ $potonganItem->potongan->nama_potongan ?? 'Tidak Ditemukan' }}</span>
                                                <span class="item-value potongan-amount">Rp {{ number_format($potonganItem->jumlah_potongan, 0, ',', '.') }}</span>
                                            </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item ps-4">
                                                <span class="item-label">Tidak ada rincian potongan.</span>
                                            </li>
                                        @endif
                                    </ul>

                                    <h6 class="text-end mt-4">
                                        <strong>Gaji Bersih:</strong> <span class="text-gaji-bersih">Rp {{ number_format($gajiItem->gaji_bersih, 0, ',', '.') }}</span>
                                    </h6>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center mt-4">
                        Belum ada riwayat gaji yang ditemukan untuk Anda.
                    </div>
                @endif

            @else
                <div class="alert alert-warning text-center">
                    Data karyawan Anda tidak ditemukan. Silakan hubungi administrator.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection