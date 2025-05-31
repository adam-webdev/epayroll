@extends('layouts.layoutmaster')
@section('title', 'Hari Libur')
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
          <h5 class="card-title">Input Data Hari Libur</h5>
          <!-- Floating Labels Form -->
          <form class="g-3" method="post" id="form-jabatan" action="{{ route('harilibur.store') }}" >
              @csrf

              <div class="row">
                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama Jabatan">
                          <label for="nama">Nama Hari Libur (*)</label>
                          @error('nama')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" placeholder="tanggal">
                          <label for="tanggal">Tanggal (*)</label>
                          @error('tanggal')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="tahun" type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" placeholder="tahun">
                          <label for="tahun">Tahun (*)</label>
                          @error('tahun')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="is_nasional" class="form-select @error('is_nasional') is-invalid @enderror" id="is_nasional">
                            <option value="1" selected>Libur Nasional</option>
                            <option value="0">Libur Cuti Bersama </option>
                        </select>
                        <label for="is_nasional">Libur Nasional / Cuti Bersama (*)</label>
                        @error('is_nasional')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
              </div>

              <div class="row">
                  <div class="col-md-4">
                      <div class="d-flex text-center mt-4">
                          <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Simpan Data</button>
                      </div>
                  </div>
              </div>
          </form>
              <!-- End Floating Labels Form -->

        </div>
      </div>
    </section>
  </div>
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between ">
            <h5 class="card-title">Data Hari Libur</h5>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive  table-striped" style="font-size: 12px;">
              <thead>
                  <tr>
                      <th>Aksi</th>
                      <th>No</th>
                      <th>Hari Libur</th>
                      <th>Tanggal</th>
                      <th>Keterangan</th>
                      <th>Tahun</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($hariLibur as $hariLibur)
                      <tr>
                          <td class="text-center" width="18%">
                              <a title="Detail" href="{{ route('harilibur.show', $hariLibur->id) }}" class="btn btn-sm btn-detail-soft">
                                  <i class='bx bx-show'></i>
                              </a>
                              <a title="Edit" href="{{ route('harilibur.edit', $hariLibur->id) }}" class="btn btn-sm btn-edit-soft">
                                  <i class='bx bxs-edit'></i>
                              </a>
                              <form action="{{ route('harilibur.destroy', $hariLibur->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                                      <i class='bx bxs-trash'></i>
                                  </button>
                              </form>
                          </td>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $hariLibur->nama }}</td>
                          <td>{{ $hariLibur->tanggal }}</td>
                          <td>{{ $hariLibur->is_nasional == 1 ? 'Libur Nasional' : 'Libur Cuti Bersama' }}</td>
                          <td>{{ $hariLibur->tahun }}</td>
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

