

@extends('layouts.layoutmaster')

@section('content')


    <!-- Floating Labels Form -->
    <form class="row g-3" method="post" action="{{ route('users.update', $user->id) }}">
      @csrf
      @method('PUT') <!-- Menambahkan method PUT untuk form update -->
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Data Pengguna</h5>
            <div class="form-floating">
              <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="nama" placeholder="Nama " value="{{$user->name}}">
              <label for="nama">Nama Lengkap </label>
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="form-floating mt-3">
              <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{$user->email}}">
              <label for="email">Email </label>
              @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <small class="mt-4">Kosongkan jika tidak mau ganti password</small>
            <div class="form-floating mt-2">
              <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="password">
              <label for="password">Password </label>
              @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="text-center mt-3">
              <button type="submit" class="btn button-tambah w-100">Update</button>
              <a href="{{ route('users.index') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
            </div>
          </div>
        </div>
      </div>
    </form><!-- End floating Labels Form -->


@endsection



