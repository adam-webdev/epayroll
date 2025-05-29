@extends('layouts.layoutmaster')
@section('title', 'Detail Jabatan')
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
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class='bx bx-briefcase'></i> Detail Jabatan</h5>
            <a href="{{ route('jabatan.index') }}" class="btn btn-sm btn-outline-light">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
        <div class="card-body mt-4">
            <div class="text-center mb-4">
                <h5 class="fw-bold">Nama Jabatan: {{ $jabatan->nama_jabatan }}</h5>
                <p class="text-muted mb-0">{{ $jabatan->status }}</p>
            </div>

            <div class="row gy-4 mt-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Tunjangan Jabatan</h6>
                    <p class="fs-8">
                        {{ $jabatan->tunjangan_jabatan ? 'Rp ' . number_format($jabatan->tunjangan_jabatan, 0, ',', '.') : '-' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Gaji Pokok</h6>
                    <p class="fs-8">
                        {{ $jabatan->gaji_pokok ? 'Rp ' . number_format($jabatan->gaji_pokok, 0, ',', '.') : '-' }}
                    </p>
                </div>
                <div class="col-md-12">
                    <h6 class="text-muted">Deskripsi</h6>
                    <p class="fs-8">
                        {{ $jabatan->deskripsi ?? '-' }}
                    </p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Status</h6>
                    <p class="fs-8">{{ $jabatan->status }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
