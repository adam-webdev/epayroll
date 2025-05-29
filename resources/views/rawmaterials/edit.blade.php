@extends('layouts.layoutmaster')
@section('title', 'Edit Raw Material')
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
          <h5 class="card-title">Update Data Material</h5>
          <!-- Floating Labels Form -->
          <form action="{{ route('rawmaterial.update',$rawmaterial->id) }}" method="POST" id="form-raw-material">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" id="kode" placeholder="Kode Unik" value="{{old('kode',$rawmaterial->kode) }}">
                <label for="kode">Kode </label>
                @error('kode')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text" value="{{old('nama',$rawmaterial->nama) }}" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" placeholder="Nama Material">
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
                    <option value="{{ $supplier->id }}"
                      {{ $supplier->id == old('supplier_id', $rawmaterial->supplier_id) ? 'selected' : '' }}
                      >{{ $supplier->nama }}</option>
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
                <input type="text" class="form-control @error('satuan') is-invalid @enderror" name="satuan" id="satuan" placeholder="Satuan" value="{{old('satuan',$rawmaterial->satuan) }}">
                <label for="satuan">Satuan (Btg/m/cm/mm) (*)</label>
                @error('satuan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="number"  class="form-control @error('minimal_stok') is-invalid @enderror" name="minimal_stok" id="minimal_stok" placeholder="Minimal Stok" value="{{old('minimal_stok',(int)$rawmaterial->minimal_stok) }}">
                <label for="minimal_stok">Minimal Stok (*)</label>
                @error('minimal_stok')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="number"  class="form-control @error('stok') is-invalid @enderror" name="stok" id="stok" placeholder="Stok" value="{{old('stok',(int)$rawmaterial->stok) }}">
                <label for="stok">Stok Saat Ini</label>
                @error('stok')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <!-- Checkbox untuk dimensi -->

            </div>
          </div>
          <div class="row mt-3">
             <div class="col-md-4">
              <div class="form-floating">
                <select name="kategori" id="kategori" class="form-select form-control @error('kategori') is-invalid @enderror" data-placeholder="Pilih kategori">
                  <option value="">--Pilih Kategori--</option>
                  <option value="Alumunium"
                  {{ $rawmaterial->kategori == 'Alumunium' ? 'selected' : '' }}
                  >Alumunium</option>
                  <option value="Upvc" {{ $rawmaterial->kategori == 'Upvc' ? 'selected' : '' }}>Upvc</option>
                  <option value="Aksesoris Alumunium" {{ $rawmaterial->kategori == 'Aksesoris Alumunium' ? 'selected' : '' }}>Aksesoris Alumunium</option>
                  <option value="Aksesoris Upvc" {{ $rawmaterial->kategori == 'Aksesoris Upvc' ? 'selected' : '' }}>Aksesoris Upvc</option>
                </select>
                <label for="kategori">Kategori</label>
                @error('kategori')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
             <div class="col-md-4">
              <div class="form-floating">
                <input type="text" class="form-control @error('ketebalan') is-invalid @enderror" name="ketebalan" id="ketebalan" placeholder="Ketebalan" value="{{old('ketebalan',$rawmaterial->ketebalan) }}">
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
                  <label class="form-check-label" for="use_dimension"  ></label>Pakai Dimensi</label>
              </div>
            </div>
          </div>
          <div class="row mt-3 dimension-fields d-none">
            <!-- Input untuk panjang, lebar, ketebalan -->
            <div class="col-md-4">
              <div class="form-floating mb-2">
                <input type="text" class="form-control" name="panjang" id="panjang" value="{{old('panjang', $rawmaterial->panjang)}}" placeholder="Panjang">
                <label for="panjang">Panjang (m/cm/mm)</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating mb-2">
                <input type="text" value="{{old('lebar', $rawmaterial->lebar)}}" class="form-control" name="lebar" id="lebar" placeholder="Lebar">
                <label for="lebar">Lebar (m/cm/mm)</label>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-4 mt-2">

              <div class="form-floating">
                <input type="number"value="{{old('harga_beli', (int)$rawmaterial->harga_beli)}}" class="form-control @error('harga_beli') is-invalid @enderror" name="harga_beli" id="harga_beli" placeholder="Harga Beli">
                <label for="harga_beli">Harga Beli / Satuan</label>
                @error('harga_beli')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text"  class="form-control @error('warna') is-invalid @enderror" value="{{old('warna', $rawmaterial->warna)}}" name="warna" id="warna" placeholder="warna">
                <label for="warna">Warna</label>
                @error('warna')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="text"  class="form-control @error('merk') is-invalid @enderror" value="{{old('merk', $rawmaterial->merk)}}" name="merk" id="merk" placeholder="merk">
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

