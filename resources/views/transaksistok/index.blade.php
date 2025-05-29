@extends('layouts.layoutmaster')
@section('title', 'Transaksi Stok')
@section('content')
@section('css')
<style>
  .custom-dropdown {
    position: relative;
    width: 100%;
    font-family: sans-serif;
  }

  .dropdown-selected {
    padding: 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    background: #fff;
    border-radius: 6px;
  }

  .dropdown-list {
    position: absolute;
    list-style: none;
    padding: 0;
    margin: 5px 0 0 0;
    width: 100%;
    border: 1px solid #ccc;
    background: #fff;
    display: none;
    border-radius: 6px;
    z-index: 5;
  }

  .dropdown-list li {
    padding: 10px;
    cursor: pointer;
    border-bottom: 1px solid #eee;
  }

  .dropdown-list li:last-child {
    border-bottom: none;
  }

  .dropdown-list li:hover {
    background: #f1f1f1;
  }

  /* Warna dan icon */
  .item-masuk {
    color: green;
  }

  .item-keluar {
    color: red;
  }

  .transaction-type {
      padding: 5px 10px;
      border-radius: 5px;
      color: white;
      font-weight: bold;
  }

  .transaction-type.masuk {
      background-color: #d8ebdc; /* Hijau terang */
      color: #155724; /* Hijau gelap */
  }

  .transaction-type.keluar {
      background-color: #fff0f1; /* Merah terang */
      color: #721c24; /* Merah gelap */
  }

  .transaction-type i {
      margin-right: 5px; /* Jarak antara ikon dan teks */
  }
  select,option{
    font-family: sans-serif;
    font-size:10px!important;
  }

</style>

@endsection
@include('sweetalert::alert')
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Input Transaksi Stok</h5>
          <!-- Floating Labels Form -->
          <form action="{{ route('transaksistok.store') }}" method="POST" id="form-raw-material">
          @csrf
          <div class="row">
            <div class="col-md-6 mt-2">
              <div class="form-floating">
                <div class="form-floating">
                <select name="raw_material_id" id="raw_material_id" class="form-select form-control material-select @error('raw_material_id') is-invalid @enderror" data-placeholder="Pilih Material">
                  <option value="">-- Pilih Material --</option>
                  @foreach($raw_materials as $material)
                    <option value="{{ $material->id }}">{{$material->kode}} - {{ $material->nama }} - stok  {{(int)$material->stok}} - {{$material->kategori}}</option>
                  @endforeach
                </select>
                <label for="raw_material_id">Material (*)</label>
                @error('raw_material_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="custom-dropdown">
                <div class="dropdown-selected">-- Pilih Status (*) --</div>
                <ul class="dropdown-list">
                  <li data-value="masuk" class="item-masuk">⬆ Masuk</li>
                  <li data-value="keluar" class="item-keluar">⬇ Keluar</li>
                </ul>
                <input type="hidden" name="tipe" id="tipe">
              </div>
              <!-- <div class="form-floating">
                <select name="tipe" id="tipe" class="form-select form-control  @error('tipe') is-invalid @enderror" data-placeholder="Pilih tipe">
                  <option value="" >-- Pilih Tipe --</option>
                    <optgroup label="Masuk" style="color:green;">
                      <option value="masuk">Masuk</option>
                    </optgroup>

                    <optgroup label="Keluar" style="color:red;">
                      <option value="keluar">Keluar</option>
                    </optgroup>
                </select>
                <label for="tipe">Tipe </label>
                @error('tipe')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div> -->
            </div>

          </div>
          <div class="row mt-3">
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" placeholder="Jumlah">
                <label for="jumlah">Jumlah (*)</label>
                @error('jumlah')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-4 mt-2">
              <div class="form-floating">
                <input type="datetime-local"  class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" placeholder="Tanggal" >
                <label for="tanggal">Tanggal (*)</label>
                @error('tanggal')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-md-8 mt-2">
              <div class="form-floating">
                <textarea class="form-control @error('catatan') is-invalid @enderror" name="catatan" id="catatan" style="height: 100px;" placeholder="Catatan"></textarea>
                <label for="catatan">Catatan</label>
                @error('catatan')
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
            <h5 class="card-title">Data Transaksi Stok</h5>
            <div class="mt-2">
                <a class="btn btn-sm btn-success" href="{{route('stok.viewexport')}}"><i class='bx bxs-file-pdf'></i>Export Data</a>
            </div>
          </div>
          <!-- Table with stripped rows -->
          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>No</th>
                <th>Material</th>
                <th>Status</th>
                <th>Stok Sebelum</th>
                <th>Jumlah</th>
                <th>Stok Sesudah</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($transaksistok as $ts)
                <tr>
                  <td class="text-center" width="18%">
                    <a title="Detail" href="{{ route('transaksistok.show', $ts->id) }}"
                      class="btn btn-sm btn-detail-soft">
                      <i class='bx bx-show'></i>
                    </a>
                    <!-- <a title="Edit" href="{{ route('transaksistok.edit', $ts->id) }}"
                      class="btn btn-sm btn-edit-soft">
                      <i class='bx bxs-edit'></i>
                    </a> -->
                    <form action="{{ route('transaksistok.destroy', $ts->id) }}"
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
                  <td>{{ $ts->nama_material ?? "-" }}</td>
                  <td >
                    <span class="badge transaction-type {{ $ts->tipe == 'masuk' ? 'masuk' : 'keluar' }}">{{ $ts->tipe }}
                      <i class="bx {{ $ts->tipe == 'masuk' ? 'bx-up-arrow' : 'bx-down-arrow' }}"></i>

                    </span>
                  </td>
                  <td>{{ $ts->stok_sebelumnya }}</td>
                  <td>{{ $ts->jumlah }}</td>
                  <td>{{ $ts->stok_sesudah }}</td>
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
    $('#raw_material_id').select2({
      placeholder: 'Pilih Material',
      width: '100%',
    });

    const dropdown = document.querySelector('.custom-dropdown');
    const selected = dropdown.querySelector('.dropdown-selected');
    const list = dropdown.querySelector('.dropdown-list');
    const hiddenInput = dropdown.querySelector('input[type="hidden"]');

    selected.addEventListener('click', () => {
      list.style.display = list.style.display === 'block' ? 'none' : 'block';
    });

    document.querySelectorAll('.dropdown-list li').forEach(item => {
      item.addEventListener('click', () => {
        selected.innerHTML = item.innerHTML;
        hiddenInput.value = item.dataset.value;
        list.style.display = 'none';
      });
    });

    // klik luar dropdown nutup
    document.addEventListener('click', function(e) {
      if (!dropdown.contains(e.target)) {
        list.style.display = 'none';
      }
    });

  </script>

@endsection

