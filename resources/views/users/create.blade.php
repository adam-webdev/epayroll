@extends('layouts.layoutmaster')

@section('content')
<div class="container">
    <h1>Tambah User Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                    <label for="name">Nama Lengkap (*)</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email') }}" required>
                    <label for="email">Email (*)</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-4 mt-2">
                <div class="form-floating">
                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Kata Sandi" required>
                    <label for="password">Kata Sandi (*)</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary w-100">Simpan User</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
            </div>
        </div>
    </form>
</div>
@endsection
