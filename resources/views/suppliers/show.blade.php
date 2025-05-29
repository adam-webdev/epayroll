@extends('layouts.layoutmaster')
@section('title', 'Detail Supplier')
@section('content')
<div class="container py-4">
    <div class="card shadow rounded-4">
        <div class="card-header bg-success text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class='bx bx-user-pin'></i> Detail Supplier</h5>
            <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-outline-light">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>
        <div class="card-body mt-4">
            <div class="row gy-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Nama Supplier</h6>
                    <p class="fs-8 fw-semibold">{{ $supplier->nama }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Email</h6>
                    <p class="fs-8">{{ $supplier->email ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">No HP</h6>
                    <p class="fs-8">{{ $supplier->no_hp ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Alamat</h6>
                    <p class="fs-8">{{ $supplier->alamat ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Kota</h6>
                    <p class="fs-8">{{ $supplier->kota ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Negara</h6>
                    <p class="fs-8">{{ $supplier->negara ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Nama Bank</h6>
                    <p class="fs-8">{{ $supplier->nama_bank ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">No Rekening</h6>
                    <p class="fs-8">{{ $supplier->no_rekening ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
