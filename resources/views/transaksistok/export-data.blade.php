@extends('layouts.layoutmaster')
@section('css')
    <style>

    </style>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Rekapan Stok</h1>
</div>
<div class="card p-3">
    <form method="post" action="{{ route('stok.export') }}" class="row g-3 align-items-end mb-4">
    @csrf
    <div class="col-md-3">
        <label for="from" class="form-label">Dari Tanggal</label>
        <input type="date" name="from" id="from" class="form-control" required>
    </div>

    <div class="col-md-3">
        <label for="to" class="form-label">Sampai Tanggal</label>
        <input type="date" name="to" id="to" class="form-control" required>
    </div>

    <div class="col-md-3">
        <label for="tipe" class="form-label">Tipe Transaksi</label>
        <select name="tipe" id="tipe" class="form-select">
            <option value="all">Semua</option>
            <option value="masuk">Stok Masuk</option>
            <option value="keluar">Stok Keluar</option>
        </select>
    </div>

    <div class="col-md-3 d-flex gap-2">
        <button type="submit" name="export" value="pdf" class="btn btn-danger w-50">
            <i class="bi bi-file-earmark-pdf"></i> PDF
        </button>
        <button type="submit" name="export" value="excel" class="btn btn-success w-50">
            <i class="bi bi-file-earmark-excel"></i> Excel
        </button>
    </div>
    </form>
</div>


@endsection
