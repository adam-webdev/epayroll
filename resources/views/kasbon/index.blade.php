@extends('layouts.layoutmaster')
@section('title', 'Kasbon Karyawan')
@section('content')
@include('sweetalert::alert')
<div class="row">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title">Data Kasbon Karyawan</h5>
                    <a href="{{ route('kasbon.create') }}" class="btn btn-sm button-tambah" style="display: block;">
                      + Tambah  </button>
                    </a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table " id="datatable" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kasbons as $kasbon)
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('kasbon.edit', $kasbon->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('kasbon.destroy', $kasbon->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apa anda yakin ingin menghapus data ini ?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $kasbon->karyawan->nama }}</td>
                                <td>Rp. {{ number_format($kasbon->jumlah,0,0) }}</td>
                                <td>{{ \Carbon\Carbon::parse($kasbon->tanggal)->translatedFormat('d F Y') }}
                                <td>{{ $kasbon->keterangan }}</td>
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
</script>
@endsection
