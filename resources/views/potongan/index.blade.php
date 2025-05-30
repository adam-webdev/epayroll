@extends('layouts.layoutmaster')
@section('title', 'Jabatan')
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
        <h5 class="card-title">Input Data Potongan</h5>
        <form class="g-3" method="post" id="form-potongan" action="{{ route('potongan.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="nama_potongan" type="text" class="form-control @error('nama_potongan') is-invalid @enderror" id="nama_potongan" placeholder="Nama Potongan">
                        <label for="nama_potongan">Nama Potongan (*)</label>
                        @error('nama_potongan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="tipe" class="form-select @error('tipe') is-invalid @enderror" id="tipe">
                            <option value="nominal" selected>Nominal (Rp)</option>
                            <option value="persentase">Persentase (%)</option>
                        </select>
                        <label for="tipe">Tipe Potongan (*)</label>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <input name="nilai" type="number" class="form-control @error('nilai') is-invalid @enderror" id="nilai" placeholder="Nilai Potongan">
                        <label for="nilai">Nilai Potongan (*)</label>
                        @error('nilai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-floating">
                        <select name="status" class="form-select @error('status') is-invalid @enderror" id="status">
                            <option value="Aktif" selected>Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
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
                          <option value="1" selected>Ya</option>
                          <option value="0">Tidak</option>
                      </select>
                      <label for="otomatis"> Otomatis Diterapkan ?</label>
                      @error('otomatis')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                  </div>
              </div>



                <div class="col-md-12 mt-2">
                    <div class="form-floating">
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" placeholder="Deskripsi Potongan" style="height: 100px"></textarea>
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
                        <button type="submit" class="btn button-tambah w-100"><i class='bx bxs-save'></i> Simpan Potongan</button>
                    </div>
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
        <div class="d-flex justify-content-between">
          <h5 class="card-title">Data Potongan</h5>
        </div>

        <div style="overflow-x: auto;">
          <table id="datatable" class="table table-responsive table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                <th>Aksi</th>
                <th>No</th>
                <th>Nama Potongan</th>
                <th>Tipe</th>
                <th>Nilai</th>
                <th>Otomatis</th>
                <th>Status</th>
                <th>Deskripsi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($potongans as $potongan)
                <tr>
                  <td class="text-center" width="18%">
                    <a title="Detail" href="{{ route('potongan.show', $potongan->id) }}" class="btn btn-sm btn-detail-soft">
                      <i class='bx bx-show'></i>
                    </a>
                    <a title="Edit" href="{{ route('potongan.edit', $potongan->id) }}" class="btn btn-sm btn-edit-soft">
                      <i class='bx bxs-edit'></i>
                    </a>
                    <form action="{{ route('potongan.destroy', $potongan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus potongan ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" title="Hapus" class="btn btn-sm btn-delete-soft">
                        <i class='bx bxs-trash'></i>
                      </button>
                    </form>
                  </td>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $potongan->nama_potongan }}</td>
                  <td>{{ ucfirst($potongan->tipe) }}</td>
                  <td>
                    @if ($potongan->tipe == 'persentase')
                      {{ $potongan->nilai }}%
                    @else
                      Rp. {{ number_format($potongan->nilai, 0, ',', '.')  }}
                    @endif
                  </td>
                  <td>{{ $potongan->otomatis === 1 ? 'Ya' : 'Tidak' }}</td>
                  <td>{{ $potongan->status }}</td>
                  <td>{{ $potongan->deskripsi }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
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

