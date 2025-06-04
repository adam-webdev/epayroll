@extends('layouts.layoutmaster')
@section('title', 'Detail Gaji Tenaga Pendidik')
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
            color: #007bff; /* Warna biru untuk bonus, kamu bisa ubah */
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
                Detail Gaji Bulan {{ date('F', mktime(0, 0, 0, $gaji->first()->bulan, 1)) }} Tahun {{ $gaji->first()->tahun }}
            </h4>
            <p class="text-center text-muted mb-4" style="font-size: 0.9em;">
                Informasi gaji terperinci untuk setiap tenaga pendidik dalam periode ini.
            </p>

            <div class="accordion" id="gajiAccordion">
                @foreach ($gaji as $item)
                <div class="accordion-item mb-3 rounded-3 border">
                    <h6 class="accordion-header" id="heading{{ $item->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $item->id }}" aria-expanded="false" aria-controls="collapse{{ $item->id }}">
                            <i class='bx bxs-user me-2'></i> {{ $item->karyawan->nama }} <span class="badge bg-secondary ms-3">{{ $item->karyawan->jabatan->nama_jabatan ?? 'Tidak Ada Jabatan' }}</span>
                        </button>
                    </h6>
                    <div id="collapse{{ $item->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $item->id }}" data-bs-parent="#gajiAccordion">
                        <div class="accordion-body">
                            <h6 class="text-primary">Informasi Umum</h6>
                            <ul class="list-group mb-4">
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-user'></i> Nama</span>
                                    <span class="item-value">{{ $item->karyawan->nama }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-briefcase'></i> Jabatan</span>
                                    <span class="item-value">{{ $item->karyawan->jabatan->nama_jabatan ?? '-' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-id-card'></i> NIP</span>
                                    <span class="item-value">{{ $item->karyawan->nip ?? '-' }}</span>
                                </li>
                                {{-- Tambahkan info karyawan lainnya jika ada --}}
                            </ul>

                            <h6 class="text-success">Penghasilan</h6>
                            <ul class="list-group mb-4">
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-money'></i> Gaji Pokok</span>
                                    <span class="item-value">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-wallet-alt'></i> Tunjangan</span>
                                    <span class="item-value">Rp {{ number_format($item->tunjangan, 0, ',', '.') }}</span>
                                </li>

                                {{-- Section for Bonuses --}}
                                @if($item->gajiBonuses->isNotEmpty())
                                    <li class="list-group-item">
                                        <span class="item-label"><i class='bx bx-gift'></i> Total Bonus</span>
                                        <span class="item-value bonus-amount">Rp {{ number_format($item->gajiBonuses->sum('jumlah_bonus'), 0, ',', '.') }}</span>
                                    </li>
                                    @foreach ($item->gajiBonuses as $bonusItem)
                                    <li class="list-group-item ps-4">
                                        {{-- Ensure $bonusItem->bonus exists before trying to access its properties --}}
                                        <span class="item-label"><i class='bx bx-chevrons-right'></i> {{ $bonusItem->bonus->nama_bonus ?? 'Nama Bonus Tidak Ditemukan' }}</span>
                                        <span class="item-value bonus-amount">Rp {{ number_format($bonusItem->jumlah_bonus, 0, ',', '.') }}</span>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="list-group-item ps-4">
                                        <span class="item-label">Tidak ada rincian bonus untuk periode ini.</span>
                                    </li>
                                @endif
                                {{-- End Section for Bonuses --}}

                                {{-- You can uncomment this if you have total_jam_lembur and tunjangan_lembur attributes --}}
                                {{-- @if(isset($item->total_jam_lembur) && $item->total_jam_lembur > 0)
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-time'></i> Total Jam Lembur</span>
                                    <span class="item-value">{{ $item->total_jam_lembur }} jam</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-plus-circle'></i> Tunjangan Lembur</span>
                                    <span class="item-value">Rp {{ number_format($item->tunjangan_lembur, 0, ',', '.') }}</span>
                                </li>
                                @endif --}}
                            </ul>

                            <h6 class="text-danger">Potongan</h6>
                            <ul class="list-group mb-4">
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-minus-circle'></i> Total Potongan</span>
                                    <span class="item-value potongan-amount">Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</span>
                                </li>
                                @forelse ($item->gajiPotongans as $potongan)
                                <li class="list-group-item ps-4"> {{-- Kurangi padding-left untuk kesederhanaan --}}
                                    <span class="item-label"><i class='bx bx-chevrons-right'></i> {{ $potongan->potongan->nama_potongan }}</span>
                                    <span class="item-value potongan-amount">Rp {{ number_format($potongan->jumlah_potongan, 0, ',', '.') }}</span>
                                </li>
                                @empty
                                <li class="list-group-item ps-4">
                                    <span class="item-label">Tidak ada rincian potongan.</span>
                                </li>
                                @endforelse
                            </ul>

                            <h6 class="text-end mt-4">
                                **Gaji Bersih:** <span class="text-gaji-bersih">Rp {{ number_format($item->gaji_bersih, 0, ',', '.') }}</span>
                            </h6>

                            <div class="d-flex justify-content-end mt-4">
                                @if (isset($item->slipGaji) && $item->slipGaji->file_path)
                                    <a href="{{ asset('storage/' . $item->slipGaji->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class='bx bx-download me-1'></i> Unduh Slip Gaji</a>
                                @else
                                    <span class="text-muted fst-italic" style="font-size: 0.85em;">Slip gaji belum tersedia.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection