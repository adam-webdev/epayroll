@extends('layouts.layoutmaster')
@section('title', 'Update Supplier')
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
          <h5 class="card-title">Update Data</h5>
          <!-- Floating Labels Form -->
         <form class="g-3" method="POST" id="form-supplier" action="{{ route('supplier.update', $supplier->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" value="{{ old('nama', $supplier->nama) }}">
                  <label for="nama">Nama Supplier (*)</label>
                  @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $supplier->email) }}">
                  <label for="email">Email</label>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="no_hp" type="number" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" value="{{ old('no_hp', $supplier->no_hp) }}">
                  <label for="no_hp">No Hp</label>
                  @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
 <div class="row mt-3">
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="nama_bank" type="text" class="form-control @error('nama_bank') is-invalid @enderror" id="nama_bank" value="{{ old('nama_bank', $supplier->nama_bank) }}">
                  <label for="nama_bank">Nama Bank</label>
                  @error('nama_bank')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="no_rekening" type="number" class="form-control @error('no_rekening') is-invalid @enderror" id="no_rekening" value="{{ old('no_rekening', $supplier->no_rekening) }}">
                  <label for="no_rekening">No Rekening</label>
                  @error('no_rekening')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="kota" type="text" class="form-control @error('kota') is-invalid @enderror" id="kota" value="{{ old('kota', $supplier->kota) }}">
                  <label for="kota">Kota</label>
                  @error('kota')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row mt-3">

              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="negara" type="text" class="form-control @error('negara') is-invalid @enderror" id="negara" value="{{ old('negara', $supplier->negara) }}">
                  <label for="negara">Negara</label>
                  @error('negara')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-8 mt-2">
                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat..." style="height: 100px">{{ old('alamat', $supplier->alamat) }}</textarea>
                @error('alamat')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>


            <div class="row">
              <div class="col-md-4">
                <div class="d-flex text-center mt-4">
                  <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Simpan Perubahan</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>

@endsection
