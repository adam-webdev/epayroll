@extends('layouts.layoutmaster')
@section('title', 'Karyawan')
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
            <h5 class="card-title">Data Karyawan</h5>
          </div>

            {{-- Bagian Input Kunci Admin --}}
            <div class="mb-4 p-3 border rounded" style="background-color: #e3f2fd;">
                <h5><i class='bx bx-key'></i> Kunci Dekripsi Admin</h5>
                <p class="text-muted small">Masukkan <strong>KEY</strong> Anda untuk mendekripsi data sensitif (Nama, NIK, Email, No. HP, Alamat).</p>
                <form action="{{ route('karyawan.index') }}" method="GET" id="decryption-form">
                    <div class="input-group">
                        <input type="password" id="adminDecryptionKey" name="admin_key" class="form-control" placeholder="Masukkan APP_KEY Anda di sini" value="{{ $adminKey ?? '' }}">
                        <button class="btn btn-success" type="submit" id="applyKeyButton"><i class='bx bx-check'></i> Terapkan Kunci</button>
                        @if($adminKey)
                            <a href="{{ route('karyawan.index') }}" class="btn btn-secondary ms-2" id="resetDecryptionButton"><i class='bx bx-x'></i> Reset Dekripsi</a>
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
                      <th>Nama</th>
                      <th>NIK</th>
                      <th>Email</th> {{-- Kolom baru --}}
                      <th>No HP</th> {{-- Kolom baru --}}
                      <th>Alamat</th>
                      <th>Join Date</th>
                      <th>Jabatan</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($karyawans as $karyawan)
                      <tr id="karyawan-row-{{ $karyawan->id }}">
                          <td class="text-center" width="18%">
                              <a title="Detail" href="{{ route('karyawan.show', $karyawan->id) }}" class="btn btn-sm btn-info">
                                  <i class='bx bx-show'></i>
                              </a>
                              <a title="Edit" href="{{ route('karyawan.edit', $karyawan->id) }}" class="btn btn-sm btn-warning">
                                  <i class='bx bxs-edit'></i>
                              </a>
                              <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda Yakin?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" title="Hapus" class="btn btn-sm btn-danger">
                                      <i class='bx bxs-trash'></i>
                                  </button>
                              </form>
                          </td>
                          <td>{{ $loop->iteration }}</td>
                          <td class="encrypted-or-plain-cell">{{ $karyawan->nama }}</td>
                          <td class="encrypted-or-plain-cell">{{ $karyawan->nik }}</td>
                          <td class="encrypted-or-plain-cell">{{ $karyawan->email }}</td>
                          <td class="encrypted-or-plain-cell">{{ $karyawan->no_hp }}</td>
                          <td class="encrypted-or-plain-cell">{{ $karyawan->alamat }}</td>
                          <td>
                            {{ $karyawan->tanggal_masuk ? \Carbon\Carbon::parse($karyawan->tanggal_masuk)->translatedFormat('l, d F Y') : '-' }}
                          </td>
                          <td>{{ $karyawan->jabatan->nama_jabatan ?? '-' }}</td>
                      </tr>
                  @endforeach
                  @if ($karyawans->isEmpty())
                    <tr>
                        <td colspan="10" class="text-center">Belum ada data karyawan.</td>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

    // --- FUNGSI UNTUK FOTO UTAMA (tetap dari kode Anda) ---
    document.getElementById("foto-dropzone").addEventListener("click", function() {
        document.getElementById("foto").click();
    });

    document.getElementById("foto").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("foto-preview").innerHTML = `
                    <div class="image-wrapper">
                        <img src="${e.target.result}" class="preview-image">
                        <button class="remove-btn" onclick="removeImage('foto-preview')">&times;</button>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    function removeImage(element) {
        if (typeof element === 'string') {
            document.getElementById(element).innerHTML = "";
        } else {
            element.parentElement.remove();
        }
    }
  </script>
@endsection