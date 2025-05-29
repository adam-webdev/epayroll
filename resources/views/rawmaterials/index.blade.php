@extends('layouts.layoutmaster')
@section('title', 'Raw Material')
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

        <div class="d-flex justify-content-between ">
          <h5 class="card-title">Input Data Material</h5>
          <div class="mt-2">
            <a href="{{route('rawmaterial.import-excel')}}" class="btn btn-sm btn-success mt-2">
              <i class="bi bi-file-earmark-excel"></i>
              Import Excel</a>
          </div>
        </div>

          <!-- Floating Labels Form -->
          <form action="{{ route('rawmaterial.store') }}" method="POST" id="form-raw-material">
          @csrf
          <div class="row">
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" placeholder="Kode Unik">
                <label for="kode">Kode </label>
                @error('kode')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Nama Material">
                <label for="nama">Nama (*)</label>
                @error('nama')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <select name="supplier_id" id="supplier_id" class="form-select form-control supplier-select @error('supplier_id') is-invalid @enderror" data-placeholder="Pilih atau tambah supplier">
                  <option></option>
                  @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->nama }}</option>
                  @endforeach
                </select>
                <label for="supplier_id">Supplier</label>
                @error('supplier_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

          </div>

          <div class="row mt-3">
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan" placeholder="Satuan">
                <label for="satuan">Satuan (Btg/m/cm/mm) (*)</label>
                @error('satuan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="number" step="0.01" class="form-control @error('minimal_stok') is-invalid @enderror" name="minimal_stok" id="minimal_stok" placeholder="Minimal Stok" value="1">
                <label for="minimal_stok">Minimal Stok (*)</label>
                @error('minimal_stok')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="number" step="0.01" class="form-control @error('stok') is-invalid @enderror" name="stok" id="stok" placeholder="Stok" value="0">
                <label for="stok">Stok Saat Ini</label>
                @error('stok')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <!-- Checkbox untuk dimensi -->
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-4 mt-2s">
              <div class="form-floating">
                <select name="kategori" id="kategori" class="form-select form-control @error('kategori') is-invalid @enderror" data-placeholder="Pilih kategori">
                  <option value="">--Pilih Kategori--</option>
                  <option value="Alumunium">Alumunium</option>
                  <option value="Upvc">Upvc</option>
                  <option value="Aksesoris Alumunium">Aksesoris Alumunium</option>
                  <option value="Aksesoris Upvc">Aksesoris Upvc</option>
                </select>
                <label for="kategori">Kategori</label>
                @error('kategori')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text" class="form-control @error('ketebalan') is-invalid @enderror" name="ketebalan" id="ketebalan" placeholder="Ketebalan">
                <label for="ketebalan">Ketebalan (m/cm/mm)</label>
                 @error('ketebalan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md">
              <div class="form-check mt-2">
                  <input class="form-check-input" type="checkbox" id="use_dimension" style="cursor: pointer;">
                  <label class="form-check-label" for="use_dimension"></label>Pakai Dimensi</label>
              </div>
            </div>
          </div>
          <div class="row mt-3 dimension-fields d-none">
            <!-- Input untuk panjang, lebar, ketebalan -->
            <div class="col-md-4">
              <div class="form-floating mb-2">
                <input type="text" class="form-control" name="panjang" id="panjang" placeholder="Panjang">
                <label for="panjang">Panjang (m/cm/mm)</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating mb-2">
                <input type="text" class="form-control" name="lebar" id="lebar" placeholder="Lebar">
                <label for="lebar">Lebar (m/cm/mm)</label>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="number" step="0.01" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" id="harga_beli" placeholder="Harga Beli">
                <label for="harga_beli">Harga Beli / Satuan</label>
                @error('harga_beli')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text"  class="form-control @error('warna') is-invalid @enderror" name="warna" id="warna" placeholder="warna">
                <label for="warna">Warna</label>
                @error('warna')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <div class="form-floating">
                <input type="text"  class="form-control @error('merk') is-invalid @enderror" name="merk" id="merk" placeholder="merk">
                <label for="merk">Merk</label>
                @error('merk')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-md-4">
             <button type="submit" class="btn button-tambah w-100  "><i class='bx bxs-save'></i>
              Simpan Data</button>
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
            <h5 class="card-title">Data Raw Material</h5>
            <div class="mt-2">
                <a class="btn btn-sm btn-success" href="{{route('rawmaterial.viewexport')}}"><i class='bx bxs-file-pdf'></i>Export Data</a>
            </div>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Minimal Stok</th>
                <th>Stok</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($materials as $material)
                <tr class="{{ $material->stok < $material->minimal_stok ? 'table-danger' : '' }}">
                  <td class="text-center" width="18%">
                    <a title="Detail" href="{{ route('rawmaterial.show', $material->id) }}"
                      class="btn btn-sm btn-detail-soft">
                      <i class='bx bx-show'></i>
                    </a>
                    <a title="Edit" href="{{ route('rawmaterial.edit', $material->id) }}"
                      class="btn btn-sm btn-edit-soft">
                      <i class='bx bxs-edit'></i>
                    </a>
                    <form action="{{ route('rawmaterial.destroy', $material->id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapusnya?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                        <i class='bx bxs-trash'></i>
                      </button>
                    </form>
                  </td>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $material->kode }}</td>
                  <td>{{ $material->nama }}</td>
                  <td>{{$material->kategori }}</td>
                  <td>{{(int) $material->minimal_stok }}</td>
                  <td>{{ (int) $material->stok }}</td>
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
@endsection
@section('scripts')
  <script>
    $(document).ready(function() {
      $('#datatable').DataTable();
    });
    $('#supplier_id').select2({
      tags: true,
      placeholder: 'Pilih atau tambah supplier',
      width: '100%',
    });
    document.addEventListener('DOMContentLoaded', function () {
      const checkbox = document.getElementById('use_dimension');
      const dimensionFields = document.querySelector('.dimension-fields');

      checkbox.addEventListener('change', function () {
        if (this.checked) {
          dimensionFields.classList.remove('d-none');
        } else {
          dimensionFields.classList.add('d-none');
        }
      });
    });

</script>

@endsection

