@extends('layouts.layoutmaster')
@section('title', 'Detail Raw Material')
@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class='bx bx-cube'></i> Detail Raw Material</h5>
            <a href="{{ route('rawmaterial.index') }}" class="btn btn-sm btn-outline-light">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
        <div class="card-body mt-4">
            <div class="row gy-4">

                <div class="col-md-6">
                    <h6 class="text-muted">Nama Material</h6>
                    <p class="fs-8 fw-semibold">{{ $rawmaterial->nama }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Kode Material</h6>
                    <p class="fs-8">{{ $rawmaterial->kode ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Kategori</h6>
                    <p class="fs-8">{{ $rawmaterial->kategori ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Satuan</h6>
                    <p class="fs-8">{{ $rawmaterial->satuan ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Stok Tersedia</h6>
                    <p class="fs-8">{{ (int)$rawmaterial->stok }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Harga Satuan</h6>
                    <p class="fs-8">Rp{{ number_format($rawmaterial->harga, 0, ',', '.') }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Merk</h6>
                    <p class="fs-8">{{ $rawmaterial->merk ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Dibuat Oleh</h6>
                    <p class="fs-8">{{ $rawmaterial->createdBy->name ?? '-' }}</p>
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">Terakhir Diedit Oleh</h6>
                    <p class="fs-8">{{ $rawmaterial->updatedBy->name ?? '-' }}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
