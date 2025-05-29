@extends('layouts.layoutmaster')
@section('title', 'Karyawan')
@section('content')
@section('css')
<style>
.dropzone {
    border: 2px dashed var(--mainColor);
    padding: 20px;
    text-align: center;
    cursor: pointer;
    background-color: #f8f9fa;
    border-radius: 10px;
  }
  .preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
  }
  .preview-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    position: relative;
  }
  .remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: var(--mainColor);
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 14px;
    cursor: pointer;
  }
  .image-wrapper {
    position: relative;
    display: inline-block;
  }
  .add-image-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    border: 2px dashed #ccc;
    border-radius: 5px;
    font-size: 24px;
    cursor: pointer;
    background-color: #f8f9fa;
  }
</style>
@endsection
@include('sweetalert::alert')
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Input Data Karyawan</h5>
          <!-- Floating Labels Form -->
          <form class="g-3" method="post" id="form-karyawan" action="{{ route('karyawan.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama Karyawan">
                          <label for="nama">Nama Karyawan (*)</label>
                          @error('nama')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nik" type="number" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="NIK">
                          <label for="nik">NIK (*)</label>
                          @error('nik')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
                          <label for="email">Email</label>
                          @error('email')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="No HP">
                        <label for="no_hp">Nomor HP (*)</label>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="tanggal_masuk" type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="agama" class="form-select @error('agama') is-invalid @enderror" id="agama">
                            <option value="">Pilih Agama</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Budha">Budha</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <label for="agama">Agama</label>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" id="jenis_kelamin">
                            <option value="Laki-laki" selected>Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" id="jabatan_id">
                            <option value="">Pilih Jabatan</option>
                            @foreach($jabatans as $jabatan)
                                <option value="{{ $jabatan->id }}">{{ $jabatan->nama_jabatan }}</option>
                            @endforeach
                        </select>
                        <label for="jabatan_id">Jabatan</label>
                        @error('jabatan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="status_karyawan" class="form-select @error('status_karyawan') is-invalid @enderror" id="status_karyawan">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                        <label for="status_karyawan">Status Karyawan</label>
                        @error('status_karyawan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="status_kawin" class="form-select @error('status_kawin') is-invalid @enderror" id="status_kawin">
                            <option value="Belum Kawin" selected>Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                        </select>
                        <label for="status_kawin">Status Kawin</label>
                        @error('status_kawin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                  <div class="col-md-8 mt-2">
                      <div class="form-floating">
                          <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat lengkap" style="height: 100px"></textarea>
                          <label for="alamat">Alamat</label>
                          @error('alamat')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>
              </div>
              <div class="row mt-3">
                  <div class="col-md-12 ">
                    <label for="foto">Foto </label>
                    <div id="foto-dropzone" class="dropzone">Drag & Drop  Foto   Disini atau Klik</div>
                    <input type="file" id="foto" name="foto" class="form-control d-none @error('foto') is-invalid @enderror">
                        @error('foto')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <div id="foto-preview" class="preview-container"></div>
                  </div>
              </div>
              @role('admin')
              <div class="row">
                  <div class="col-md-4">
                      <div class="d-flex text-center mt-4">
                          <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Simpan Data</button>
                      </div>
                  </div>
              </div>
              @endrole
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
            <h5 class="card-title">Data Karyawan</h5>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive  table-striped" style="font-size: 12px;">
              <thead>
                  <tr>
                      <th>Aksi</th>
                      <th>No</th>
                      <th>Nama</th>
                      <th>Join Date</th>
                      <th>Jabatan</th>
                      <th>NIK</th>
                      <th>No HP</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($karyawans as $karyawan)
                      <tr>
                          <td class="text-center" width="18%">
                              <a title="Detail" href="{{ route('karyawan.show', $karyawan->id) }}" class="btn btn-sm btn-detail-soft">
                                  <i class='bx bx-show'></i>
                              </a>
                              <a title="Edit" href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-edit-soft">
                                  <i class='bx bxs-edit'></i>
                              </a>
                              <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                                      <i class='bx bxs-trash'></i>
                                  </button>
                              </form>
                          </td>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $karyawan->nama }}</td>
                          <td>
                            {{ $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->translatedFormat('l, d F Y') : '-' }}
                          <td>{{ $karyawan->jabatan }}</td>
                          <td>{{ $karyawan->nik }}</td>
                          <td>{{ $karyawan->no_hp }}</td>
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

     // Fungsi untuk menangani upload foto utama
  document.getElementById("foto-dropzone").addEventListener("click", function() {
    document.getElementById("foto").click();
  });

  document.getElementById("foto").addEventListener("change", function(event) {
    let file = event.target.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById("foto-preview").innerHTML = `
          <div class="image-wrapper">
            <img src="${e.target.result}" class="preview-image">
            <button class="remove-btn" onclick="removeImage('foto-preview')">&times;</button>
          </div>
        `;
      };
      reader.readAsDataURL(file);
    }
  });

  // Fungsi untuk menghapus gambar
  function removeImage(element) {
    if (typeof element === 'string') {
      // Jika element adalah string (foto utama), hapus semua gambar di container
      document.getElementById(element).innerHTML = "";
    } else {
      // Jika element adalah tombol x, hapus gambar yang sesuai
      element.parentElement.remove();
    }
  }
  </script>
@endsection

