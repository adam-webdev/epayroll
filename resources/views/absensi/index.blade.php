@extends('layouts.layoutmaster')
@section('title', 'Data Absensi Karyawan')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between ">
            <h5 class="card-title">Data Absensi Karyawan</h5>
            @role('admin')
            <div class="mt-2">
              <a href="{{route('absensi.rekap')}}" class="btn btn-sm btn-success mt-2"><i class='bx bx-task'></i>Rekap Kehadiran</a>
              <a href="{{route('absensi.create')}}" class="btn btn-sm button-tambah mt-2">+ Input Absen</a>
            </div>
            @endrole
          </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-responsive" id="datatable">
                    <thead class="table-light">
                        <tr>
                            <th>Aksi</th>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Total Karyawan</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($absensis as $index => $absen)
                        <tr>
                          <td class="text-center" width="18%">
                              <!-- <a title="Detail" href="{{ route('absensi.show', $absen->tanggal) }}" class="btn btn-sm btn-detail-soft">
                                  <i class='bx bx-show'></i>
                              </a> -->

                              <a title="Edit" href="{{ route('absensi.edit', $absen->tanggal) }}" class="btn btn-sm btn-edit-soft">
                                  <i class='bx bxs-edit'></i>
                              </a>
                              <form action="{{ route('absensi.destroy', $absen->tanggal) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                                      <i class='bx bxs-trash'></i>
                                  </button>
                              </form>
                            </td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($absen->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $absen->total_karyawan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Data absensi belum ada</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });
  </script>
@endsection
