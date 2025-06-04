@extends('layouts.layoutmaster')
@section('title', 'Update Bonus')
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
          <h5 class="card-title">Edit Data bonus</h5>
          <form class="g-3" method="post" id="form-bonus" action="{{ route('bonus.update', $bonus->id) }}">
              @csrf
              @method('PUT')

              <div class="row">
                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nama_bonus" type="text" class="form-control @error('nama_bonus') is-invalid @enderror" id="nama_bonus" placeholder="Nama bonus" value="{{ old('nama_bonus', $bonus->nama_bonus) }}">
                          <label for="nama_bonus">Nama bonus (*)</label>
                          @error('nama_bonus')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" id="tipe">
                              <option value="nominal" {{ old('tipe', $bonus->tipe) == 'nominal' ? 'selected' : '' }}>Nominal</option>
                              <option value="persentase" {{ old('tipe', $bonus->tipe) == 'persentase' ? 'selected' : '' }}>Persentase</option>
                          </select>
                          <label for="tipe">Tipe bonus (*)</label>
                          @error('tipe')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <input name="nilai" type="number" class="form-control @error('nilai') is-invalid @enderror" id="nilai" placeholder="Nilai bonus" value="{{ old('nilai', $bonus->nilai) }}">
                          <label for="nilai">Nilai bonus (*)</label>
                          @error('nilai')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <select name="status" class="form-select @error('status') is-invalid @enderror" id="status">
                              <option value="Aktif" {{ old('status', $bonus->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                              <option value="Nonaktif" {{ old('status', $bonus->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                          </select>
                          <label for="status">Status</label>
                          @error('status')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-4 mt-2">
                      <div class="form-floating">
                          <select name="otomatis" class="form-select @error('otomatis') is-invalid @enderror" id="otomatis">
                              <option value="0" {{ old('otomatis', $bonus->otomatis) == 0 ? 'selected' : '' }}>Tidak</option>
                              <option value="1" {{ old('otomatis', $bonus->otomatis) == 1 ? 'selected' : '' }}>Ya</option>
                          </select>
                          <label for="otomatis">Otomatis Diterapkan?</label>
                          @error('otomatis')
                              <div class="invalid-feedback">{{ $message }}</div>
                          @enderror
                      </div>
                  </div>

                  <div class="col-md-8 mt-2">
                      <div class="form-floating">
                          <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" placeholder="Deskripsi lengkap" style="height: 100px">{{ old('deskripsi', $bonus->deskripsi) }}</textarea>
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
