@extends('layouts.layoutmaster')
@section('title', 'Karyawan')
@section('content')
@section('css')
<style>
/* ... (CSS yang sudah ada dari file Anda) ... */
/* PERBAIKI BAGIAN INI UNTUK DROPZONE */
.dropzone {
    /* Pastikan ini ada dan sesuai */
    border: 2px dashed #28a745; /* Mengganti var(--mainColor) dengan warna hijau solid (misal: Bootstrap's success color) */
    /* Atau jika Anda punya custom property --mainColor di layouts/layoutmaster, pastikan terdefinisi */
    /* border: 2px dashed var(--mainColor); */

    padding: 20px;
    text-align: center;
    cursor: pointer;
    background-color: #f8f9fa;
    border-radius: 10px;
}
/* END PERBAIKAN DROPZONE */

/* Tambahan CSS untuk wrapping teks */
.encrypted-or-plain-cell {
    white-space: normal;
    word-wrap: break-word;
    word-break: break-all; /* Lebih agresif untuk string Base64 */
    max-width: 200px; /* Sesuaikan lebar maksimum */
}

/* Untuk status kunci */
.text-info-status { color: #0dcaf0; }
.text-success-status { color: #198754; }
.text-danger-status { color: #dc3545; }
.text-warning-status { color: #ffc107; }

</style>
@endsection
@include('sweetalert::alert')
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Input Data Karyawan</h5>
          <form class="g-3" method="post" id="form-karyawan" action="{{ route('karyawan.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama Karyawan" value="{{ old('nama') }}">
                          <label for="nama">Nama Karyawan (*)</label>
                          @error('nama')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nik" type="number" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="NIK" value="{{ old('nik') }}">
                          <label for="nik">NIK (*)</label>
                          @error('nik')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}">
                          <label for="email">Email</label>
                          @error('email')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="no_hp" type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="No HP" value="{{ old('no_hp') }}">
                        <label for="no_hp">Nomor HP (*)</label>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="tanggal_masuk" type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk" value="{{ old('tanggal_masuk') }}">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
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
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Budha" {{ old('agama') == 'Budha' ? 'selected' : '' }}>Budha</option>
                            <option value="Lainnya" {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
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
                                <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}</option>
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
                            <option value="Aktif" {{ old('status_karyawan') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status_karyawan') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
                            <option value="Belum Kawin" {{ old('status_kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_kawin') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        </select>
                        <label for="status_kawin">Status Kawin</label>
                        @error('status_kawin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" id="user_id">
                          <option value="">Pilih User Akun</option>
                          @foreach($users as $user)
                              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                          @endforeach
                        </select>
                        <label for="user_id">User Akun </label>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div> -->


                  <div class="col-md-8 mt-2">
                      <div class="form-floating">
                          <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat lengkap" style="height: 100px">{{ old('alamat') }}</textarea>
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
              <div class="row">
                  <div class="col-md-4">
                      <div class="d-flex text-center mt-4">
                          <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Simpan Data</button>
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
            <h5 class="card-title">Data Karyawan</h5>
          </div>

            {{-- Bagian Input Kunci Admin --}}
            <div class="mb-4 p-3 border rounded" style="background-color: #e3f2fd;">
                <h5><i class='bx bx-key'></i> Kunci Dekripsi Admin</h5>
                <p class="text-muted small">Masukkan <strong>KEY </strong> Anda untuk mendekripsi data sensitif (Nama, NIK, Email, No. HP, Alamat).</p>
                <form action="{{ route('karyawan.decrypt') }}" method="post" id="decryption-form">
                  @csrf
                    <div class="input-group">
                        <input type="password" id="adminDecryptionKey" name="admin_key" class="form-control" placeholder="Masukkan APP_KEY Anda di sini" value="{{ $adminKey ?? '' }}">
                        <button class="btn btn-success" type="submit" id="applyKeyButton"><i class='bx bx-check'></i> Terapkan Kunci</button>
                            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary ms-2" id="resetDecryptionButton"><i class='bx bx-x'></i> Reset Dekripsi</a>
                    </div>

                </form>
            </div>

          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive  table-striped" style="font-size: 12px;">
              <thead>
                  <tr>
                      <th>Aksi</th>
                      <th>No</th>
                      <th>Nama</th>
                      <th>NIK</th>
                      <th>Email</th> {{-- Kolom baru --}}
                      <th>No HP</th> {{-- Kolom baru --}}
                      <th>Alamat</th>
                      <th>Join Date</th>
                      <th>Jabatan</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($karyawans as $karyawan)
                      <tr id="karyawan-row-{{ $karyawan->id }}">
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
                          {{-- Tampilkan langsung data dari objek $karyawan. --}}
                          {{-- Jika ada admin_key valid, ini sudah didekripsi oleh controller. --}}
                          {{-- Jika tidak, ini akan menampilkan data terenkripsi. --}}
                          <td class="encrypted-or-plain-cell">{{ $karyawan->nama }}</td>
                          <td class="encrypted-or-plain-cell">{{ $karyawan->nik }}</td>
                          <td class="encrypted-or-plain-cell">{{ $karyawan->email }}</td> {{-- Kolom baru --}}
                          <td class="encrypted-or-plain-cell">{{ $karyawan->no_hp }}</td> {{-- Kolom baru --}}
                          <td class="encrypted-or-plain-cell">{{ $karyawan->alamat }}</td>
                          <td>
                            {{ $karyawan->tanggal_masuk ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('l, d F Y') : '-' }}
                          </td>
                          <td>{{ $karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                      </tr>
                  @endforeach
                  @if ($karyawans->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data karyawan.</td>
                    </tr>
                  @endif
              </tbody>
            </table>
          </div>
          </div>
      </div>
    </section>
  </div>
@endsection
@section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      if ($.fn.DataTable) {
          $('#datatable').DataTable({
              // Konfigurasi DataTables lainnya
              "aoColumnDefs": [
                // Kolom Nama, NIK, Email, No HP, Alamat
                { "bSortable": false, "aTargets": [ 2, 3, 4, 5, 6 ] }
              ]
          });
      } else {
          console.warn('DataTables not initialized. Make sure its script is included.');
      }
    });

    // --- FUNGSI UNTUK FOTO UTAMA (tetap dari kode Anda) ---
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

    function removeImage(element) {
        if (typeof element === 'string') {
            document.getElementById(element).innerHTML = "";
        } else {
            element.parentElement.remove();
        }
    }
  </script>
@endsection