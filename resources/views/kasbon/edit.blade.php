@extends('layouts.layoutmaster')
@section('title', 'Edit Kasbon')
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
                <h5 class="card-title">Edit Data Kasbon</h5>
                <form method="post" action="{{ route('kasbon.update', $kasbon->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="form-floating">
                                <select name="karyawan_id" id="karyawan_id" class="form-select form-control material-select @error('karyawan_id') is-invalid @enderror" data-placeholder="Pilih Karyawan">
                                    <option value="">-- Pilih Karyawan --</option>
                                    @foreach($karyawan as $k)
                                        <option value="{{ $k->id }}" {{ $kasbon->karyawan_id == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="karyawan_id">Karyawan (*)</label>
                                @error('karyawan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <div class="form-floating">
                                <input type="date" name="tanggal" value="{{ $kasbon->tanggal }}" class="form-control @error('tanggal') is-invalid @enderror">
                                <label for="tanggal">Tanggal (*)</label>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6 mt-2">
                            <div class="form-floating">
                                <input type="number" name="jumlah" value="{{ $kasbon->jumlah }}" class="form-control @error('jumlah') is-invalid @enderror">
                                <label for="jumlah">Jumlah (*)</label>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mt-2">
                            <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Keterangan...">{{ $kasbon->keterangan }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex text-center mt-4">
                        <button type="button" class="btn btn-secondary w-100 me-3" onclick="window.history.back();"><i class="bi bi-arrow-left-circle"></i> Kembali</button>
                        <button type="submit" class="button-tambah w-100"><i class="bi bi-database-fill-check"></i> Update</button>
                    </div>
                </form>
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
