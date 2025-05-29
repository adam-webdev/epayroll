@extends('layouts.layoutmaster')
@section('title', 'Artikel')
@section('content')
@include('sweetalert::alert')
<div class="row">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between p-4">
                    <h5 class="card-title">Data Artikel</h5>
                    <a href="{{ route('article.create') }}">
                      <button class="button-tambah" >Buat Artikel</button>
                    </a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table " id="datatable">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Banner</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($artikel as $key => $article)
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('article.edit', $article->id) }}" class="btn btn-secondary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('article.destroy', $article->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apa anda yakin ingin menghapus data ini ?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $article->judul }}</td>
                                <td>{{ $article->user_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($article->tanggal)->translatedFormat('d F Y') }}
                                <td>
                                    <img src="{{ asset('storage/' . $article->banner) }}" alt="{{ $article->judul }}" class="img-fluid" style="max-width: 100px">
                                </td>
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
