@extends('layouts.layoutmaster')
@section('css')
    <style>

    </style>
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Rekapan Absensi</h1>
</div>

<form action="{{ route('absensi.cetaknow') }}" method="post">
    @csrf
    <div class="card p-4 flex justify-content-between">
        <div class="row">
            <div class="col-md-3">
                <label for="bulan">Pilih Dari Bulan:</label>
                <select name="bulan" class="form-select me-2" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3">
                <label for="tahun">Tahun:</label>
                <select name="tahun" class="form-select me-2" required>
                    @for ($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                            {{ $y }}
                        </option>
                    @endfor
                </select>
            </div>
             <div class="col-md-3">
                <label for="">Submit :</label>
                <div class=" d-flex gap-2">
                    <button type="submit" name="export" value="pdf" class="btn btn-danger ">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                    <button type="submit" name="export" value="excel" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </button>
                </div>

            </div>

        </div>
    </div>
</form>
@endsection
