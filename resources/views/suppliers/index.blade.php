@extends('layouts.layoutmaster')
@section('title', 'Supplier')
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
          <h5 class="card-title">Input Data Supplier</h5>
          <!-- Floating Labels Form -->
          <form class=" g-3" method="post" id="form-produk" action="{{route('supplier.store')}}">
            @csrf
            <div class="row">
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="nama" type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Nama">
                  <label for="nama">Nama Supplier (*)</label>
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="email" id="email">
                  <label for="email">Email </label>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="no_hp" type="number" class="form-control @error('no_hp') is-invalid @enderror" placeholder="No HP" id="no_hp">
                  <label for="no_hp">No Hp </label>
                    @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

            </div>

            <div class="row ">

              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="nama_bank" type="text" class="form-control @error('nama_bank') is-invalid @enderror" placeholder="nama_bank" id="nama_bank">
                  <label for="nama_bank">Nama Bank </label>
                    @error('nama_bank')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="no_rekening" type="number" class="form-control @error('no_rekening') is-invalid @enderror" id="no_rekening" placeholder="No Rekening">
                  <label for="no_rekening">No Rekening </label>
                    @error('no_rekening')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="kota" type="text" class="form-control @error('kota') is-invalid @enderror" placeholder="Kota" id="kota">
                  <label for="kota">kota </label>
                    @error('kota')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="negara" type="text" class="form-control @error('negara') is-invalid @enderror" placeholder="Negara" id="negara">
                  <label for="negara">Negara </label>
                    @error('negara')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-8 mt-2">
                <div class="form-floating">
                  <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat..." style="height: 100px"></textarea>
                  <label for="alamat">Alamat</label>
                  @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="d-flex text-center mt-4">
                  <!-- <button type="button" class="btn btn-secondary w-100 me-3" onclick="window.history.back(-1);"><i class='bx bx-arrow-back'></i>Kembali</button> -->
                  <button type="submit" class="btn button-tambah w-100  "><i class='bx bxs-save'></i>
                     Simpan Data</button>
                </div>
              </div>
            </div>
          </form><!-- End floating Labels Form -->
        </div>
      </div>
    </section>
  </div>
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between ">
            <h5 class="card-title">Data Supplier</h5>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive table-striped table-bordered" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>
                    Aksi
                  </th>
                  <th>
                    No
                  </th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>No Hp</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($suppliers as $supplier)
                <tr>
                  <td class="text-center" width="18%">
                    <a title="Detail" href="{{ route('supplier.show', $supplier->id) }}"
                        class="btn btn-sm btn-detail-soft">
                        <i class='bx bx-show'></i>
                    </a>
                    <a title="Edit" href="{{ route('supplier.edit', $supplier->id) }}"
                      class="btn btn-sm btn-edit-soft">
                      <i class='bx bxs-edit'></i>
                    </a>

                    <form action="{{ route('supplier.destroy', $supplier->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Apakah Anda Yakin?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                        <i class='bx bxs-trash'></i>
                      </button>
                    </form>
                  </td>


                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $supplier->nama }}</td>
                  <td>{{ $supplier->email }}</td>
                  <td>{{ $supplier->no_hp }}</td>

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
  </script>
@endsection

