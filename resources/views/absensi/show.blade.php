@extends('layouts.layoutmaster')
@section('title', 'Detail Karyawan')
@section('content')
@section('css')
    <style>
        p.text-muted {
            font-size: 14px;
            color: black;
            font-weight: 700;
        }
    </style>
@endsection
<div class="container py-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class='bx bx-user-pin'></i> Detail Karyawan</h5>
            <a href="{{ route('karyawan.index') }}" class="btn btn-sm btn-outline-light">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
        <div class="card-body mt-4">
            <div class="text-center mb-4">
                @if($karyawan->foto)
                    <img src="/storage/{{$karyawan->foto}}"
                        class="rounded-circle shadow"
                        alt="Foto {{ $karyawan->nama }}"
                        width="150" height="150" style="object-fit: cover;">
                @else
                    <img src="{{asset('assets/img/profile-img.jpg') }}"
                        class="rounded-circle shadow"
                        alt="Foto Default"
                        width="150" height="150" style="object-fit: cover;">
                @endif
                <h5 class="mt-3 fw-bold">{{ $karyawan->nama }}</h5>
                <p class="text-muted mb-0">{{ $karyawan->jabatan ?? '-' }}</p>
            </div>

            <div class="row gy-4 mt-4">
                <div class="col-md-6">
                    <h6 class="text-muted">NIK</h6>
                    <p class="fs-8">{{ $karyawan->nik ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Email</h6>
                    <p class="fs-8">{{ $karyawan->email ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">No HP</h6>
                    <p class="fs-8">{{ $karyawan->no_hp ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Jabatan</h6>
                    <p class="fs-8">{{ $karyawan->jabatan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Tanggal Masuk</h6>
                    <p class="fs-8">{{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->translatedFormat('l, d F Y') : '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Tanggal Lahir</h6>
                    <p class="fs-8">{{ $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->translatedFormat('l, d F Y') : '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Agama</h6>
                    <p class="fs-8">{{ $karyawan->agama ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Status Kawin</h6>
                    <p class="fs-8">{{ $karyawan->status_kawin ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Gaji Pokok</h6>
                    <p class="fs-8">{{ $karyawan->gaji_pokok ? number_format($karyawan->gaji_pokok,0,0) : '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Status Karyawan</h6>
                    <p class="fs-8">{{ $karyawan->status ?? '-' }}</p>
                </div>
                <div class="col-md-12">
                    <h6 class="text-muted">Alamat</h6>
                    <p class="fs-8">{{ $karyawan->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
