@extends('layouts.layoutmaster')
@section('title', 'Update Hari Libur')
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
        <h5 class="card-title">Edit Data Hari Libur</h5>
        <form class="g-3" method="post" id="form-jabatan" action="{{ route('harilibur.update', $harilibur->id) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        {{-- Isi nilai 'nama' dengan data yang sudah ada --}}
                        <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama Hari Libur" value="{{ old('nama', $harilibur->nama) }}">
                        <label for="nama">Nama Hari Libur (*)</label>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        {{-- Isi nilai 'tanggal' dengan data yang sudah ada --}}
                        <input name="tanggal" type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" placeholder="tanggal" value="{{ old('tanggal', $harilibur->tanggal) }}">
                        <label for="tanggal">Tanggal (*)</label>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        {{-- Isi nilai 'tahun' dengan data yang sudah ada --}}
                        <input name="tahun" type="number" class="form-control @error('tahun') is-invalid @enderror" id="tahun" placeholder="tahun" value="{{ old('tahun', $harilibur->tahun) }}">
                        <label for="tahun">Tahun (*)</label>
                        @error('tahun')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="is_nasional" class="form-select @error('is_nasional') is-invalid @enderror" id="is_nasional">
                            {{-- Pilih opsi berdasarkan nilai 'is_nasional' yang sudah ada --}}
                            <option value="1" {{ old('is_nasional', $harilibur->is_nasional) == '1' ? 'selected' : '' }}>Libur Nasional</option>
                            <option value="0" {{ old('is_nasional', $harilibur->is_nasional) == '0' ? 'selected' : '' }}>Libur Cuti Bersama</option>
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
                        <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Perbarui Data</button>
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
