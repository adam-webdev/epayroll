@extends('layouts.layoutmaster')
@section('title', 'Detail Transaksi Stok')
@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class='bx bx-package'></i> Detail Transaksi Stok</h5>
            <a href="{{ route('transaksistok.index') }}" class="btn btn-sm btn-outline-light">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
        <div class="card-body mt-4">
            <div class="row gy-4">
                <div class="col-md-6">
                    <h6 class="text-muted">ID Transaksi</h6>
                    <p class="fs-8 fw-semibold">{{ $transaksi->id }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Raw Material</h6>
                    <p class="fs-8">{{ $transaksi->rawmaterial->nama ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Status Transaksi</h6>
                    <p class="fs-8">
                        @if ($transaksi->tipe == 'masuk')
                            <span class="badge bg-success"><i class='bx bx-up-arrow-alt'></i> Masuk</span>
                        @else
                            <span class="badge bg-danger"><i class='bx bx-down-arrow-alt'></i> Keluar</span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Stok Sebelumnya</h6>
                    <p class="fs-8">{{ $transaksi->stok_sebelumnya }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Tanggal Transaksi</h6>
                    <p class="fs-8">{{ $transaksi->tanggal}}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Jumlah Perubahan</h6>
                    <p class="fs-8">{{ $transaksi->jumlah }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Catatan</h6>
                    <p class="fs-8">{{ $transaksi->catatan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Stok Setelah Transaksi</h6>
                    <p class="fs-8">{{ $transaksi->stok_sesudah }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Dibuat Oleh</h6>
                    <p class="fs-8">{{ $transaksi->createdBy->name ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Terakhir Diedit Oleh</h6>
                    <p class="fs-8">{{ $transaksi->updatedBy->name ?? '-' }}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
