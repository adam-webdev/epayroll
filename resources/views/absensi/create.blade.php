@extends('layouts.layoutmaster')
@section('title', 'Input Absensi Karyawan')
@section('css')
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        .telat{
            width: 140px;
            border: grey 1px solid;
            border-radius: 4px;
        }
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }

            input::placeholder {
                font-size: 14px;
            }

            .table th, .table td,input {
              font-size: 14px;
            }
            select, option{
                font-size: 12px;
            }
        }
        @media (max-width: 540px) {
            .table th, .table td, input {
              font-size: 12px;
              white-space: nowrap;
            }
            input::placeholder {
              font-size: 12px;
            }
            select,option{
                font-size: 12px;
            }
        }
    </style>
@endsection
@section('content')
<div class="container">
  <div class="card">
    <div class="card-body">
        <h5 class="card-title">Input Data Absensi</h5>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('absensi.store') }}" method="POST">
            @csrf
          <div class="row">
            <div class="col-sm-12 col-md-6">

              <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Absensi</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
              </div>
            </div>
          </div>
            <hr>
            <h4 class="my-3">Daftar Karyawan Aktif</h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Karyawan</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($karyawans as $index => $karyawan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $karyawan->nama }}
                                <input type="hidden" name="absensi[{{ $index }}][karyawan_id]" value="{{ $karyawan->id }}">
                            </td>
                            <td>
                                <select name="absensi[{{ $index }}][status]" class="form-select" required>
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                    <option value="Alpha">Alpha</option>
                                </select>
                            </td>

                            <td>
                                <input type="text" name="absensi[{{ $index }}][keterangan]" class="form-control" placeholder="Opsional">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex text-center mt-4">
                        <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Simpan Absensi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
