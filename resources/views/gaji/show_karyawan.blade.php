@extends('layouts.layoutmaster')
@section('title', 'Slip Gaji Karyawan')
@section('content')
@section('css')
    <style>
        /* Mengatur font dasar untuk isi slip gaji */
        .slip-gaji-content {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 0.9em;
        }

        /* Styling untuk judul bagian */
        .slip-gaji-content h6 {
            font-weight: 600;
            color: #34495e;
            margin-top: 1.2em;
            margin-bottom: 0.5em;
            font-size: 1em;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.3em;
        }

        /* Styling untuk item daftar gaji */
        .list-group-item {
            padding: 0.4rem 1rem;
            border: none;
            background-color: transparent;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-group-item .item-label {
            color: #2c3e50;
            font-weight: 500;
            display: flex;
            align-items: center;
        }
        .list-group-item .item-label i {
            margin-right: 0.6em;
            color: #888;
            font-size: 1.1em;
        }
        .list-group-item .item-value {
            font-weight: 500;
            color: #34495e;
        }

        /* Warna untuk gaji bersih */
        .text-gaji-bersih {
            color: #28a745 !important;
            font-weight: 700 !important;
            font-size: 1.2em;
        }

        /* Warna untuk nominal potongan */
        .item-value.potongan-amount {
            color: #e74c3c;
        }

        /* Warna untuk nominal bonus */
        .item-value.bonus-amount {
            color: #007bff;
        }

        /* Styling untuk accordion header */
        .accordion-button {
            font-weight: 600;
            font-size: 1.05em;
            color: #2c3e50;
            background-color: #f8f9fa;
            border-radius: 0.5rem !important;
            padding: 0.8rem 1.25rem;
        }

        .accordion-button:not(.collapsed) {
            color: #0056b3;
            background-color: #e2f0ff;
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
                Slip Gaji Karyawan
            </h4>
            <p class="text-center text-muted mb-4" style="font-size: 0.9em;">
                Detail slip gaji Anda untuk Bulan {{ \Carbon\Carbon::createFromDate($slipGaji->gaji->tahun, $slipGaji->gaji->bulan, 1)->translatedFormat('F Y') }}
                (Nomor Slip: {{ $slipGaji->nomor_slip }})
            </p>

            {{-- Pesan error jika ada dari dekripsi di controller --}}
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif

            <div class="accordion" id="slipGajiAccordion">
                {{-- Informasi Karyawan --}}
                <div class="accordion-item mb-3 rounded-3 border">
                    <h6 class="accordion-header" id="headingKaryawan">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseKaryawan" aria-expanded="true" aria-controls="collapseKaryawan">
                            <i class='bx bxs-user me-2'></i> Informasi Karyawan
                        </button>
                    </h6>
                    <div id="collapseKaryawan" class="accordion-collapse collapse show" aria-labelledby="headingKaryawan" data-bs-parent="#slipGajiAccordion">
                        <div class="accordion-body">
                            <ul class="list-group mb-4">
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-user'></i> Nama</span>
                                    <span class="item-value">{{ $slipGaji->gaji->karyawan->nama_plain ?? $slipGaji->gaji->karyawan->nama }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-id-card'></i> NIK</span>
                                    <span class="item-value">{{ $slipGaji->gaji->karyawan->nik_plain ?? $slipGaji->gaji->karyawan->nik }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-envelope'></i> Email</span>
                                    <span class="item-value">{{ $slipGaji->gaji->karyawan->email_plain ?? $slipGaji->gaji->karyawan->email }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-phone'></i> No. HP</span>
                                    <span class="item-value">{{ $slipGaji->gaji->karyawan->no_hp_plain ?? $slipGaji->gaji->karyawan->no_hp }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-briefcase'></i> Jabatan</span>
                                    <span class="item-value">{{ $slipGaji->gaji->karyawan->jabatan->nama_jabatan ?? '-' }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-map'></i> Alamat</span>
                                    <span class="item-value">{{ $slipGaji->gaji->karyawan->alamat_plain ?? $slipGaji->gaji->karyawan->alamat }}</span>
                                </li>
                                {{-- Anda bisa tambahkan info karyawan lain di sini --}}
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Detail Gaji --}}
                <div class="accordion-item mb-3 rounded-3 border">
                    <h6 class="accordion-header" id="headingGaji">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGaji" aria-expanded="true" aria-controls="collapseGaji">
                            <i class='bx bx-dollar-circle me-2'></i> Rincian Gaji
                        </button>
                    </h6>
                    <div id="collapseGaji" class="accordion-collapse collapse show" aria-labelledby="headingGaji" data-bs-parent="#slipGajiAccordion">
                        <div class="accordion-body">
                            {{-- Pesan error jika ada dari dekripsi Gaji di controller --}}
                            @if(isset($gajiDecryptionError) && $gajiDecryptionError)
                                <p class="text-danger">Mohon maaf, terjadi masalah saat mendekripsi beberapa data nominal gaji Anda.</p>
                            @endif

                            <h6 class="text-success">Penghasilan</h6>
                            <ul class="list-group mb-4">
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-money'></i> Gaji Pokok</span>
                                    <span class="item-value">Rp {{ number_format($slipGaji->gaji->gaji_pokok, 0, ',', '.') }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-wallet-alt'></i> Tunjangan</span>
                                    <span class="item-value">Rp {{ number_format($slipGaji->gaji->tunjangan, 0, ',', '.') }}</span>
                                </li>
                                <li class="list-group-item">
                                    <span class="item-label"><i class='bx bx-gift'></i> Total Bonus</span>
                                    <span class="item-value bonus-amount">Rp {{ number_format($slipGaji->gaji->total_bonus, 0, ',', '.') }}</span>
                                </li>
                                @if($slipGaji->gaji->gajiBonuses->isNotEmpty())
                                    @foreach ($slipGaji->gaji->gajiBonuses as $bonusItem)
                                        <li class="list-group-item ps-4">
                                            <span class="item-label"><i class='bx bx-chevrons-right'></i> {{ $bonusItem->bonus->nama_bonus ?? 'Nama Bonus Tidak Ditemukan' }}</span>
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
                                    <span class="item-value potongan-amount">Rp {{ number_format($slipGaji->gaji->total_potongan, 0, ',', '.') }}</span>
                                </li>
                                @if($slipGaji->gaji->gajiPotongans->isNotEmpty())
                                    @foreach ($slipGaji->gaji->gajiPotongans as $potonganItem)
                                        <li class="list-group-item ps-4">
                                            <span class="item-label"><i class='bx bx-chevrons-right'></i> {{ $potonganItem->potongan->nama_potongan ?? 'Nama Potongan Tidak Ditemukan' }}</span>
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
                                <strong>Gaji Bersih:</strong> <span class="text-gaji-bersih">Rp {{ number_format($slipGaji->gaji->gaji_bersih, 0, ',', '.') }}</span>
                            </h6>
                        </div>
                    </div>
                </div>
            </div> {{-- End accordion --}}

              <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('gaji.downloadSlipGajiPdf', ['nomor_slip' => $slipGaji->nomor_slip]) }}" target="_blank" class="btn btn-primary me-2">
                    <i class='bx bx-download me-1'></i> Unduh Slip Gaji PDF
                </a>
                <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class='bx bx-arrow-back'></i> Kembali</a>
            </div>

        </div>
    </div>
</div>
@endsection