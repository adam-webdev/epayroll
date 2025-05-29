@extends('layouts.layoutmaster')
@section('title', 'Edit Artikel')
@section('css')
<style>
  .modal {
    z-index: 1050 !important;
  }
  .modal-backdrop {
      z-index: 1040 !important;
  }

  .dropzone {
    border: 2px dashed var(--mainColor);
    padding: 20px;
    text-align: center;
    cursor: pointer;
    background-color: #f8f9fa;
    border-radius: 10px;
  }
  .preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 10px;
  }
  .preview-image {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 5px;
    position: relative;
  }
  .remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: var(--mainColor);
    color: white;
    border: none;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 14px;
    cursor: pointer;
  }
  .image-wrapper {
    position: relative;
    display: inline-block;
  }
  .add-image-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px;
    height: 100px;
    border: 2px dashed #ccc;
    border-radius: 5px;
    font-size: 24px;
    cursor: pointer;
    background-color: #f8f9fa;
  }
</style>
@endsection
@section('content')
<div class="row">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Artikel</h5>
                <form method="post" action="{{ route('article.update', [$article->id]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <div class="form-floating">
                                <input name="judul" type="text" class="form-control  @error('judul') is-invalid @enderror" id="judul" value="{{ $article->judul }}">
                                <label for="judul">Judul Artikel</label>
                                @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="form-floating">
                              <input type="date" name="tanggal" class="form-control  @error('tanggal') is-invalid @enderror" value="{{ $article->tanggal }}">
                                <label for="tanggal">Tanggal</label>
                                @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-12 ">
                        <label for="banner">Foto Banner</label>
                        <div id="foto-dropzone" class="dropzone">Drag & Drop  Foto Utama Produk Disini atau Klik</div>
                        <input type="file" id="banner" name="banner" class="form-control d-none @error('banner') is-invalid @enderror">
                            @error('banner')
                              <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        <div id="foto-preview" class="preview-container">
                          <div class="image-wrapper " id="old-foto">
                            <img src="/storage/{{$article->banner}}" class="preview-image">
                            <button class="remove-btn" onclick="removeImage('foto-preview')">&times;</button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label for="content">Konten Artikel</label>
                            <textarea name="content" class="form-control  @error('content') is-invalid @enderror" id="summernote">{{ $article->content }}</textarea>
                               @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex text-center mt-4">
                        <button type="button" class="btn btn-secondary w-100 me-3" onclick="window.history.back();"><i class="bi bi-arrow-left-circle"></i> Kembali</button>
                        <button type="submit" class="btn btn-success w-100"><i class="bi bi-database-fill-check"></i> Update</button>
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

        $('#summernote').summernote({
          height: 300,
          placeholder: 'Isi Kontent...'

        });
    });



  // Fungsi untuk menangani upload foto utama
  document.getElementById("foto-dropzone").addEventListener("click", function() {
    document.getElementById("banner").click();
  });

  document.getElementById("banner").addEventListener("change", function(event) {
    document.getElementById("old-foto").remove();
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

  // Fungsi untuk menghapus gambar
  function removeImage(element) {
    if (typeof element === 'string') {
      // Jika element adalah string (foto utama), hapus semua gambar di container
      document.getElementById(element).innerHTML = "";
    } else {
      // Jika element adalah tombol x, hapus gambar yang sesuai
      element.parentElement.remove();
    }
  }
</script>
@endsection
