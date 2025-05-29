@extends('layouts.layoutmaster')
@section('title', 'Edit Absensi Karyawan')
@section('css')
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        @media (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
            }
            input::placeholder {
                font-size: 14px;
            }
            .table th, .table td, input {
                font-size: 14px;
            }
            select, option {
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
            select, option {
                font-size: 12px;
            }
        }
    </style>
@endsection

@section('content')
<div class="container">
  <div class="card">
    <div class="card-body">
        <h5 class="card-title">Edit Data Absensi</h5>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('absensi.update', $tanggal) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Absensi</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $tanggal }}" >
                    </div>
                </div>
            </div>

            <hr>
            <h4 class="my-3">Daftar Absensi Karyawan</h4>
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
                    @foreach($absensis as $index => $absen)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $absen->karyawan->nama }}
                                <input type="hidden" name="absensi[{{ $index }}][karyawan_id]" value="{{ $absen->karyawan_id }}">
                            </td>
                            <td>
                              <select name="absensi[{{ $index }}][status]" class="form-select" required>
                                  <option value="Hadir" {{ (optional($absen)->status_kehadiran == 'Hadir') ? 'selected' : '' }}>Hadir</option>
                                  <option value="Izin" {{ (optional($absen)->status_kehadiran == 'Izin') ? 'selected' : '' }}>Izin</option>
                                  <option value="Sakit" {{ (optional($absen)->status_kehadiran == 'Sakit') ? 'selected' : '' }}>Sakit</option>
                                  <option value="Alpha" {{ (optional($absen)->status_kehadiran == 'Alpha') ? 'selected' : '' }}>Alpha</option>
                              </select>
                          </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <input class="telat" type="number" name="absensi[{{ $index }}][telat]" class="form-control" value="{{$absen->telat}}" min="0" max="15" placeholder=" Jika Telat...">
                                <small>Menit</small>
                            </div>
                        </td>
                            <td>
                                <input type="text" name="absensi[{{ $index }}][keterangan]" class="form-control" placeholder="Opsional" value="{{ optional($absen)->keterangan }}">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @role('admin')
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex text-center mt-4">
                        <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Update Absensi</button>
                    </div>
                </div>
            </div>
            @endrole
        </form>
    </div>
  </div>
</div>
@endsection
