
@extends('layouts.layoutmaster')

@section('content')


    <!-- Floating Labels Form -->
    <form class="row g-3" method="post" action="{{ route('kategori.update', $kategori->id) }}">
      @csrf
      @method('PUT') <!-- Menambahkan method PUT untuk form update -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Data Kategori</h5>
            <div class="form-floating">
              <input name="name_id" type="text" class="form-control @error('name_id') is-invalid @enderror" id="floatingKategori" placeholder="kategori" value="{{$kategori->name_id}}">
              <label for="floatingKategori">Nama Kategori ID</label>
              @error('name_id')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-floating mt-3">
                <input name="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" value="{{$kategori->name_en}}" id="floatingKategori2" placeholder="Inggris">
                <label for="floatingKategori2">Nama Kategori EN</label>
                  @error('name_en')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center mt-3">
              <button type="submit" class="btn button-tambah w-100">Update</button>
              <a href="{{ route('kategori.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
            </div>
          </div>
        </div>
      </div>
    </form><!-- End floating Labels Form -->


@endsection
