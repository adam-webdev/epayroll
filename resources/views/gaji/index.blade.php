@extends('layouts.layoutmaster')
@section('title', 'Gaji')
@section('content')
@section('css')
<style>

</style>
@endsection
@include('sweetalert::alert')
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Generate Gaji</h5>
          <!-- Floating Labels Form -->
            <form action="{{ route('gaji.generate') }}" method="post">
              @csrf
              <div class="card p-4 flex justify-content-between">
                  <div class="row">
                      <div class="col-md-3">
                          <label for="bulan">Bulan</label>
                          <select name="bulan" class="form-control">
                            @foreach([
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember'
                            ] as $num => $name)
                                <option value="{{ $num }}">{{ $name }}</option>
                            @endforeach
                        </select>

                      </div>
                      <div class="col-md-3">
                          <label for="tahun">Tahun</label>
                          <input type="number" name="tahun" class="form-control" value="{{ date('Y') }}">
                      </div>
                      <div class="col-md-3">
                          <label for="">Submit :</label>
                          <div class=" d-flex gap-2">
                              <button type="submit" name="export" value="pdf" class="btn btn-primary ">
                                  <i class="bi bi-gear-fill"></i> Generate
                              </button>
                              <!-- <button type="submit" name="export" value="excel" class="btn btn-success">
                                  <i class="bi bi-file-earmark-excel"></i> Excel
                              </button> -->
                          </div>

                      </div>

                  </div>
              </div>
            </form>

        </div>
      </div>
    </section>
  </div>
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between ">
            <h5 class="card-title">Data Gaji</h5>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive  table-striped" style="font-size: 12px;">
              <thead>
                  <tr>
                      <th>Aksi</th>
                      <th>No</th>
                      <th>Bulan</th>
                      <th>Tahun</th>
                      <th>Total Gaji Karyawan</th>
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($gajis as $gaji)
                <tr>
                  <td class="text-center">
                    <a title="Detail" href="{{ route('gaji.show', [$gaji->bulan, $gaji->tahun]) }}" class="btn btn-sm btn-detail-soft">
                      <i class='bx bx-show'></i>
                    </a>
                    <a title="Edit" href="{{ route('gaji.edit', [$gaji->bulan, $gaji->tahun]) }}" class="btn btn-sm btn-edit-soft">
                      <i class='bx bxs-edit'></i>
                    </a>
                    <form action="{{ route('gaji.destroy', [$gaji->bulan, $gaji->tahun]) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                        <i class='bx bxs-trash'></i>
                      </button>
                    </form>
                  </td>

                  <td>{{ $loop->iteration }}</td>
                  <td>{{ date('F', mktime(0, 0, 0, $gaji->bulan, 1)) }}</td>
                  <td>{{ $gaji->tahun }}</td>
                  <td>Rp. {{ number_format($gaji->total_gaji, 0, ',', '.') }}</td>
                  <td>
                    @if ($gaji->status == "Draft")
                      <span class="badge bg-secondary">Draft</span>
                    @elseif ($gaji->status === "Terkirim")
                      <span class="badge bg-success">Terkirim</span>
                    @endif
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>

          </div>
          <!-- End Table with stripped rows -->
        </div>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });

  </script>
@endsection

