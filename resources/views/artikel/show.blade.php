@extends('layouts.layoutmaster')
@section('title', 'Detail Produk')
@section('content')

@section('css')
  <style>
    .detail-card {
      background: #ffffff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 20px;
    }
    @media screen and (max-width: 768px) {
      .detail-card {
        padding: 10px;
      }
      .card-body-bmb {
        padding:0;
      }
      .card-body-bmb table tr td {
        padding:0;
        font-size:12px;
      }
    }
    .detail-title {
      font-size: 18px;
      font-weight: bold;
      color: #333;
      margin-bottom: 10px;
      border-bottom: 2px solid var(--mainColor);
      padding-bottom: 5px;
    }

    .detail-item {
      display: flex;
      padding: 8px 0;
      font-size: 16px;
      color: #555;
    }

    .detail-label {
      font-weight: bold;
      color: #333;
    }
    .produk-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: 15px;
      justify-content: center;
    }

    .produk-item {
      position: relative;
      overflow: hidden;
      border-radius: 8px;
      cursor: pointer;
      transition: transform 0.3s ease-in-out;
    }

    .produk-item:hover {
      transform: scale(1.05);
    }

    .produk-item img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
    }

    /* Overlay Styling */
    .modal {
      display: none; /* Sekarang modal tetap tersembunyi saat halaman di-load */
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.8);
      justify-content: center;
      align-items: center;
    }

    .modal img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 8px;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 20px;
      font-size: 30px;
      color: white;
      cursor: pointer;
    }
  </style>
@endsection

@include('sweetalert::alert')


<div class="row">
  <section class="section">
    <div class="card detail-card">
      <div class="card-body-bmb">
        <div class="tombol mb-4">
          <a href="{{route('produk.index')}}" class="button-tambah px-4 py-2 rounded"> <i class="bi bi-arrow-left mr-3" ></i>Kembali</a>
        </div>
        <h5 class="detail-title">Detail Produk</h5>
        <!-- <div class="row">
          <div class="col-md-3 ">
            <div class="d-flex flex-column">
              <div class="detail-item">
                <span class="detail-label">Nama Produk (ID)</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Nama Produk (EN)</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Merk</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Negara</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Kategori</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Deskripsi (ID)</span>
              </div>
              <div class="detail-item">
                <span class="detail-label">Deskripsi (EN)</span>
              </div>
            </div>
          </div>
          <div class="col-md-9 ">
            <div class="d-flex flex-column">
              <div class="detail-item">
                <span>{{$produk->nama_produk_id}}</span>
              </div>
              <div class="detail-item">
                <span>{{$produk->nama_produk_en}}</span>
              </div>
              <div class="detail-item">
                <span>{{$produk->merk}}</span>
              </div>
              <div class="detail-item">
                <span>{{$produk->negara}}</span>
              </div>
              <div class="detail-item">
                <span>{{$produk->kategori->name_id}}</span>
              </div>
              <div class="detail-item">
                <span>{{$produk->nama_deskripsi_id}}</span>
              </div>
              <div class="detail-item">
                <span>{{$produk->nama_deskripsi_en}}</span>
              </div>
            </div>
          </div>
        </div> -->

        <table class="table table-responsive">
          <tbody>
              <tr>
                  <td width="20%"><strong>Nama Produk (ID)</strong></td>
                  <td>:</td>
                  <td>{{ $produk->nama_produk_id }}</td>
              </tr>
              <tr>
                  <td width="20%"><strong>Nama Produk (EN)</strong></td>
                  <td>:</td>
                  <td>{{ $produk->nama_produk_en }}</td>
              </tr>
              <tr>
                  <td width="20%"><strong>Kategori</strong></td>
                  <td>:</td>
                  <td>{{ $produk->kategori->name_id }}</td>
              </tr>
              <tr>
                  <td width="20%"><strong>Deskripsi (ID)</strong></td>
                  <td>:</td>
                  <td>{{ $produk->nama_deskripsi_id}}</td>
              </tr>
              <tr>
                  <td width="20%"><strong>Deskripsi (EN)</strong></td>
                  <td>:</td>
                  <td>{{$produk->nama_deskripsi_en }}</td>
              </tr>
          </tbody>
      </table>

      </div>
    </div>
  </section>
</div>

<div class="row">
  <section class="section">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Foto Produk</h5>
        <div class="produk-container">
          <!-- Foto Utama -->
          <div class="produk-item" onclick="openModal('/storage/{{$produk->foto_produk}}')">
            <img src="/storage/{{$produk->foto_produk}}" alt="Foto Utama">
          </div>

          <!-- Foto Lainnya -->
          @foreach($produk_images_foto as $foto)
            <div class="produk-item" onclick="openModal('/storage/{{$foto->foto_lainnya}}')">
              <img src="/storage/{{$foto->foto_lainnya}}" alt="Foto Lainnya">
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
</div>

<!-- Modal untuk menampilkan gambar besar -->
<div id="imageModal" class="modal" onclick="closeModal()">
  <span class="close" onclick="closeModal()">&times;</span>
  <img id="modalImage" src="">
</div>

@endsection

@section('scripts')
<script>
  function openModal(imageSrc) {
    document.getElementById("modalImage").src = imageSrc;
    document.getElementById("imageModal").style.display = "flex";
  }

  function closeModal() {
    document.getElementById("imageModal").style.display = "none";
  }

  // Pastikan overlay tetap tersembunyi saat halaman dimuat
  window.onload = function() {
    document.getElementById("imageModal").style.display = "none";
  }
</script>
@endsection
