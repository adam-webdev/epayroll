@extends('layouts.layoutmaster')
@section('title', 'Jabatan')
@section('content')
@section('css')
<style>
/* ... (CSS yang sudah ada dari file Anda) ... */

/* Tambahan CSS untuk wrapping teks */
.encrypted-or-plain-cell {
    white-space: normal;
    word-wrap: break-word;
    word-break: break-all; /* Lebih agresif untuk string Base64 */
    max-width: 200px; /* Sesuaikan lebar maksimum */
}



</style>
@endsection
@include('sweetalert::alert')

  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between ">
            <h5 class="card-title">Data Jabatan</h5>
          </div>

            {{-- Bagian Input Kunci Admin --}}
            <div class="mb-4 p-3 border rounded" style="background-color: #e3f2fd;">
                <h5><i class='bx bx-key'></i> Kunci Dekripsi Admin</h5>
                <p class="text-muted small">Masukkan <strong>KEY</strong> Anda untuk mendekripsi data sensitif, Gaji Pokok dan Tunjangan Jabatan </p>
                <form action="{{ route('jabatan.index') }}" method="GET" id="decryption-form">
                    <div class="input-group">
                        <input type="password" id="adminDecryptionKey" name="admin_key" class="form-control" placeholder="Masukkan KEY Anda di sini" value="{{ $adminKey ?? '' }}">
                        <button class="btn btn-success" type="submit" id="applyKeyButton"><i class='bx bx-check'></i> Terapkan Kunci</button>
                        @if($adminKey)
                            <a href="{{ route('jabatan.index') }}" class="btn btn-secondary ms-2" id="resetDecryptionButton"><i class='bx bx-x'></i> Reset Dekripsi</a>
                        @endif
                    </div>
                    @if($decryptionError)
                        <div class="mt-2 small text-danger-status" id="keyStatus">Kunci dekripsi tidak valid atau data rusak.</div>
                    @else
                        @if($adminKey)
                            <div class="mt-2 small text-success-status" id="keyStatus">Data ditampilkan dalam bentuk terdekripsi.</div>
                        @else
                            <div class="mt-2 small text-muted" id="keyStatus">Masukkan kunci untuk melihat data terdekripsi.</div>
                        @endif
                    @endif
                </form>
            </div>

          <div style="overflow-x: auto;">
            <table id="datatable" class="table table-responsive  table-striped" style="font-size: 12px;">
              <thead>
                  <tr>
                      <th>Aksi</th>
                      <th>No</th>
                      <th>Nama Jabatan</th>
                      <th>Gaji Pokok</th>
                      <th>Tunjangan Jabatan</th> {{-- Kolom baru --}}
                      <th>Deskripsi</th> {{-- Kolom baru --}}
                      <th>Status</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($jabatans as $jabatan)
                      <tr id="jabatan-row-{{ $jabatan->id }}">
                          <td class="text-center" width="18%">
                              <a title="Detail" href="{{ route('jabatan.show', $jabatan->id) }}" class="btn btn-sm btn-info">
                                  <i class='bx bx-show'></i>
                              </a>
                              <a title="Edit" href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-sm btn-warning">
                                  <i class='bx bxs-edit'></i>
                              </a>
                              <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" title="Hapus" class="btn btn-sm btn-danger">
                                      <i class='bx bxs-trash'></i>
                                  </button>
                              </form>
                          </td>
                          <td>{{ $loop->iteration }}</td>
                          <td class="encrypted-or-plain-cell">{{ $jabatan->nama_jabatan }}</td>
                          <td class="encrypted-or-plain-cell">{{ $jabatan->gaji_pokok }}</td>
                          <td class="encrypted-or-plain-cell">{{ $jabatan->tunjangan_jabatan }}</td>
                          <td class="encrypted-or-plain-cell">{{ $jabatan->deskripsi }}</td>
                          <td class="encrypted-or-plain-cell">{{ $jabatan->status }}</td>
                      </tr>
                  @endforeach
                  @if ($jabatans->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data jabatan.</td>
                    </tr>
                  @endif
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
      if ($.fn.DataTable) {
          $('#datatable').DataTable({
              // Konfigurasi DataTables lainnya
              "aoColumnDefs": [
                // Kolom Nama, NIK, Email, No HP, Alamat
                { "bSortable": false, "aTargets": [ 2, 3, 4, 5, 6 ] }
              ]
          });
      } else {
          console.warn('DataTables not initialized. Make sure its script is included.');
      }
    });


  </script>
@endsection