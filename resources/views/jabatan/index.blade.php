@extends('layouts.layoutmaster')
@section('title', 'Jabatan')
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
          <h5 class="card-title">Input Data Jabatan</h5>
          <!-- Floating Labels Form -->
          <form class="g-3" method="post" id="form-jabatan" action="{{ route('jabatan.store') }}" >
              @csrf

              <div class="row">
                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nama_jabatan" type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan" placeholder="Nama Jabatan">
                          <label for="nama_jabatan">Nama Jabatan (*)</label>
                          @error('nama_jabatan')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="tunjangan_jabatan" type="number" class="form-control @error('tunjangan_jabatan') is-invalid @enderror" id="tunjangan_jabatan" placeholder="tunjangan_jabatan">
                          <label for="tunjangan_jabatan">Tunjangan Jabatan (*)</label>
                          @error('tunjangan_jabatan')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="gaji_pokok" type="number" class="form-control @error('gaji_pokok') is-invalid @enderror" id="gaji_pokok" placeholder="gaji_pokok">
                          <label for="gaji_pokok">Gaji Pokok(*)</label>
                          @error('gaji_pokok')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
                  <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="status" class="form-select @error('status') is-invalid @enderror" id="status">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                        <label for="status">Status </label>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                  <div class="col-md-8 mt-2">
                      <div class="form-floating">
                          <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" placeholder="deskripsi lengkap" style="height: 100px"></textarea>
                          <label for="deskripsi">Deskripsi</label>
                          @error('deskripsi')
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
            <h5 class="card-title">Data Jabatan</h5>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive  table-striped" style="font-size: 12px;">
              <thead>
                  <tr>
                      <th>Aksi</th>
                      <th>No</th>
                      <th>Jabatan</th>
                      <th>Gaji Pokok</th>
                      <th>Tunjangan Jabatan</th>
                      <th>Status</th>
                      <th>Deskripsi</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($jabatans as $jabatan)
                      <tr>
                          <td class="text-center" width="18%">
                              <a title="Detail" href="{{ route('jabatan.show', $jabatan->id) }}" class="btn btn-sm btn-detail-soft">
                                  <i class='bx bx-show'></i>
                              </a>
                              <a title="Edit" href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-sm btn-edit-soft">
                                  <i class='bx bxs-edit'></i>
                              </a>
                              <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                                      <i class='bx bxs-trash'></i>
                                  </button>
                              </form>
                          </td>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $jabatan->nama_jabatan }}</td>
                          <td>Rp. {{ number_format( $jabatan->gaji_pokok,0,0) }}</td>
                          <td>Rp. {{ number_format(  $jabatan->tunjangan_jabatan,0,0) }}</td>
                          <td>{{ $jabatan->status }}</td>
                          <td>{{ $jabatan->deskripsi }}</td>
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

