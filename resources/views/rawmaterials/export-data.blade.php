@extends('layouts.layoutmaster')
@section('css')
    <style>

    </style>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Rekapan Raw Material</h1>
</div>
<div class="card p-3">
    <form method="post" action="{{ route('rawmaterial.export') }}" class="row g-3 align-items-end mb-4">
    @csrf
    <div class="col-md-3">
        <label for="kategori" class="form-label">Kategori :</label>
        <select name="kategori" id="kategori" class="form-select">
            <option value="all">Semua</option>
            <option value="Alumunium">Alumunium</option>
            <option value="Upvc">Upvc</option>
            <option value="Aksesoris Alumunium">Aksesoris Alumunium</option>
            <option value="Aksesoris Upvc">Aksesoris Upvc</option>
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
