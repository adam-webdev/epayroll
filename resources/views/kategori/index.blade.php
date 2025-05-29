@extends('layouts.layoutmaster')
@section('title', 'Kategori')
@section('content')
@section('css')
<style>
  /*--------------------------------------------------------------
# Datatable
--------------------------------------------------------------*/
.dataTables_wrapper .dataTables_paginate .paginate_button {
  color: #fff;
  background-color: var(--mainColor)!important;
  /* Warna coklat */
  border-color: var(--mainColor)!important;
}

/* Gaya untuk warna pagination coklat pada hover */
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  color: #fff;
  background-color: var(--mainColor)!important;
  /* Warna coklat tua pada hover */
  border-color: var(--mainColor)!important;
}

/* Gaya untuk warna pagination coklat pada current page */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  color: #fff;
  background-color: var(--mainColor)!important;
  /* Warna coklat tua pada current page */
  border-color: var(--mainColor)!important;
}
</style>
@endsection
@include('sweetalert::alert')
<div class="row">
  <div class="col-md-5">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Input Data</h5>
          <!-- Floating Labels Form -->
          <form class=" g-3" method="post" action="{{route('kategori.store')}}">
            @csrf
              <div class="form-floating">
                <input name="name_id" type="text" class="form-control @error('name_id') is-invalid @enderror" id="floatingKategori" placeholder="kategori ">
                <label for="floatingKategori">Nama Kategori ID</label>
                  @error('name_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-floating mt-3">
                <input name="name_en" type="text" class="form-control @error('name_en') is-invalid @enderror" id="floatingKategori2" placeholder="Inggris ">
                <label for="floatingKategori2">Nama Kategori EN</label>
                  @error('name_en')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

            <div class="text-center mt-4">
              <button type="submit" class="btn button-tambah w-100  "> <i class="bi bi-database-fill-check"></i>Simpan</button>
              <button type="button" class="btn btn-secondary w-100  mt-2" onclick="window.history.back(-1);"

              > <i class="bi bi-arrow-left-circle"></i>Kembali</button>
            </div>
          </form><!-- End floating Labels Form -->

        </div>
      </div>
    </section>
  </div>
  <div class="col-md-7">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between ">
            <h5 class="card-title">Data Kategori</h5>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive">
              <thead>
                <tr>
                  <th>
                    Aksi
                  </th>
                  <th>
                    No
                  </th>
                  <th>Slug</th>
                  <th>Kategori ID</th>
                  <th>Kategori EN</th>
                </tr>
              </thead>
              <tbody>
                @foreach($kategori as $kategori)
                <tr>
                  <td>
                    <div class="d-flex justify-content-between">
                      <a href="{{ route('kategori.edit', $kategori->id) }}" class="btn btn-secondary btn-sm">
                          <i class="bi bi-pencil"></i>
                      </a>
                      <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST" style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger btn-sm"
                          onclick="return confirm('Apa anda yakin ingin menghapus data ini ?');">
                              <i class="bi bi-trash"></i>
                          </button>
                      </form>
                    </div>
                  </td>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$kategori->slug}}</td>
                  <td>{{$kategori->name_id}}</td>
                  <td>{{$kategori->name_en}}</td>
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
</div>
@endsection
@section('scripts')
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });
  </script>
@endsection
