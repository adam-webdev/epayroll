@extends('layouts.layoutmaster')
@section('title', 'Update Karyawan')
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

</style>
@endsection
@include('sweetalert::alert')
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Update Data</h5>
          <!-- Floating Labels Form -->
            <form class="g-3" method="post" id="form-karyawan" action="{{ route('karyawan.update', $karyawan->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama Karyawan" value="{{ old('nama', $karyawan->nama) }}">
                            <label for="nama">Nama Karyawan (*)</label>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <input name="nik" type="number" class="form-control @error('nik') is-invalid @enderror" id="nik" placeholder="NIK" value="{{ old('nik', $karyawan->nik) }}">
                            <label for="nik">NIK (*)</label>
                            @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email', $karyawan->email) }}">
                            <label for="email">Email</label>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <input name="no_hp" type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="No HP" value="{{ old('no_hp', $karyawan->no_hp) }}">
                            <label for="no_hp">No HP (*)</label>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                      <div class="form-floating">
                        <select name="jabatan_id" class="form-select @error('jabatan_id') is-invalid @enderror" id="jabatan_id">
                          <option value="" disabled selected>Pilih Jabatan</option>
                          @foreach($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}" {{ old('jabatan_id', $karyawan->jabatan_id) == $jabatan->id ? 'selected' : '' }}>
                              {{ $jabatan->nama_jabatan }}
                            </option>
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
                            <input name="tanggal_masuk" type="date" class="form-control @error('tanggal_masuk') is-invalid @enderror" id="tanggal_masuk" value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk ? $karyawan->tanggal_masuk->format('Y-m-d') : '') }}">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <input name="tanggal_lahir" type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror" id="tanggal_lahir" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir ? $karyawan->tanggal_lahir->format('Y-m-d') : '') }}">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <select name="agama" class="form-select @error('agama') is-invalid @enderror" id="agama">
                                <option value="" disabled {{ old('agama', $karyawan->agama) === null ? 'selected' : '' }}>Pilih Agama</option>
                                @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                    <option value="{{ $agama }}" {{ old('agama', $karyawan->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                @endforeach
                            </select>
                            <label for="agama">Agama</label>
                            @error('agama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <select name="status_kawin" class="form-select @error('status_kawin') is-invalid @enderror" id="status_kawin">
                                @foreach(['Belum Kawin', 'Kawin', 'Cerai'] as $status)
                                    <option value="{{ $status }}" {{ old('status_kawin', $karyawan->status_kawin) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            <label for="status_kawin">Status Kawin</label>
                            @error('status_kawin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                        <div class="form-floating">
                            <select name="status" class="form-select @error('status') is-invalid @enderror" id="status">
                                <option value="Aktif" {{ old('status', $karyawan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="Non Aktif" {{ old('status', $karyawan->status) == 'Non Aktif' ? 'selected' : '' }}>Non Aktif</option>
                            </select>
                            <label for="status">Status Karyawan</label>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4 mt-2">
                      <div class="form-floating">
                        <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" id="user_id">
                          @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $karyawan->user_id ?? '') == $user->id ? 'selected' : '' }}>
                              {{ $user->name }}
                            </option>
                          @endforeach
                        </select>
                        <label for="user_id">User Akun</label>
                        @error('user_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>

                    <div class="col-md-8 mt-2">
                        <div class="form-floating">
                            <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat lengkap" style="height: 100px">{{ old('alamat', $karyawan->alamat) }}</textarea>
                            <label for="alamat">Alamat</label>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                  <div class="col-md-12 ">
                    <label for="foto">Foto</label>
                    <div id="foto-dropzone" class="dropzone">Drag & Drop  Foto  Disini atau Klik</div>
                    <input type="file" id="foto" name="foto" class="form-control d-none @error('foto') is-invalid @enderror">
                        @error('foto')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    <div id="foto-preview" class="preview-container">
                      <div class="image-wrapper " id="old-foto">
                        <img src="/storage/{{$karyawan->foto}}" class="preview-image">
                        <button class="remove-btn" onclick="removeImage('foto-preview')">&times;</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex text-center mt-4">
                            <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Update Data</button>
                        </div>
                    </div>
                </div>
            </form>
          <!-- End Floating Labels Form -->

        </div>
      </div>
    </section>
  </div>

@endsection

@section('scripts')
 <script>


  // Fungsi untuk menangani upload foto utama
  document.getElementById("foto-dropzone").addEventListener("click", function() {
    document.getElementById("foto").click();
  });

  document.getElementById("foto").addEventListener("change", function(event) {
    document.getElementById("old-foto").remove();
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
