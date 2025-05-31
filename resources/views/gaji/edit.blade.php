@extends('layouts.layoutmaster')
@section('title', 'Update Jabatan')
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
        <h5 class="card-title">Edit Data Jabatan</h5>
        <form class="g-3" method="post" id="form-jabatan" action="{{ route('jabatan.update', $jabatan->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="nama_jabatan" type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan" placeholder="Nama Jabatan" value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}">
                        <label for="nama_jabatan">Nama Jabatan (*)</label>
                        @error('nama_jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="tunjangan_jabatan" type="number" class="form-control @error('tunjangan_jabatan') is-invalid @enderror" id="tunjangan_jabatan" placeholder="Tunjangan Jabatan" value="{{ old('tunjangan_jabatan', $jabatan->tunjangan_jabatan) }}">
                        <label for="tunjangan_jabatan">Tunjangan Jabatan (*)</label>
                        @error('tunjangan_jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="gaji_pokok" type="number" class="form-control @error('gaji_pokok') is-invalid @enderror" id="gaji_pokok" placeholder="Gaji Pokok" value="{{ old('gaji_pokok', $jabatan->gaji_pokok) }}">
                        <label for="gaji_pokok">Gaji Pokok (*)</label>
                        @error('gaji_pokok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="status" class="form-select @error('status') is-invalid @enderror" id="status">
                            <option value="Aktif" {{ old('status', $jabatan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Nonaktif" {{ old('status', $jabatan->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        <label for="status">Status </label>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-8 mt-2">
                    <div class="form-floating">
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" placeholder="Deskripsi lengkap" style="height: 100px">{{ old('deskripsi', $jabatan->deskripsi) }}</textarea>
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
                        <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Update Data</button>
                    </div>
                </div>
            </div>
        </form>
      </div>
    </div>
  </section>
</div>


@endsection

@section('scripts')
 <script>



</script>
@endsection
