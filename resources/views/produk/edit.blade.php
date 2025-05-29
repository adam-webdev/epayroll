@extends('layouts.layoutmaster')
@section('title', 'Update Produk')
@section('content')
@section('css')
<style>
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
@include('sweetalert::alert')
  <div class="row">
    <section class="section">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Update Data</h5>
          <!-- Floating Labels Form -->
          <form class=" g-3" method="post" id="form-produk" action="{{route('produk.update',[$produk->id])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="nama_produk_id" type="text" class="form-control @error('nama_produk_id') is-invalid @enderror" value="{{$produk->nama_produk_id}}" id="nama_produk_id" >
                  <label for="nama_produk_id">Nama Produk ID(*)</label>
                    @error('nama_produk_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <input name="nama_produk_en" type="text" class="form-control @error('nama_produk_en') is-invalid @enderror" value="{{$produk->nama_produk_en}}" id="nama_produk_en" >
                  <label for="nama_produk_en">Nama Produk EN(*)</label>
                    @error('nama_produk_en')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-4 mt-2">
                <div class="form-floating">
                  <select name="kategori_id" type="text" class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $kategori)
                      <option value="{{$kategori->id}}" {{$produk->kategori_id == $kategori->id ? 'selected': ''}}>{{$kategori->name_id}}</option>
                    @endforeach
                  </select>
                  <label for="kategori_id">Kategori(*)</label>
                    @error('kategori_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mt-2">
                <div class="form-floating">
                  <input name="link_tokped" type="url" class="form-control @error('link_tokped') is-invalid @enderror" value="{{$produk->link_tokped}}" id="link_tokped" >
                  <label for="link_tokped">Link Tokopedia</label>
                    @error('link_tokped')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6 mt-2">
                <div class="form-floating">
                  <input name="link_shopee" type="text" class="form-control @error('link_shopee') is-invalid @enderror" value="{{$produk->link_shopee}}" id="link_shopee" >
                  <label for="link_shopee">Link Shopee</label>
                    @error('link_shopee')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

            </div>
            <div class="row mt-3">
              <div class="col-md-6 mt-2">
                  <label for="nama_deskripsi_id">Deskripsi ID(*)</label>
                  <textarea name="nama_deskripsi_id" type="text" class="form-control @error('nama_deskripsi_id') is-invalid @enderror" rows="5" id="deskripsi_id" placeholder="deskripsi">{{$produk->nama_deskripsi_id}}</textarea>

                  @error('nama_deskripsi_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
              <div class="col-md-6 mt-2">
                   <label for="nama_deskripsi_en">Deskripsi EN(*)</label>
                  <textarea name="nama_deskripsi_en" type="text" class="form-control @error('nama_deskripsi_en') is-invalid @enderror" rows="5" cols="5" id="deskripsi_en" placeholder="nama_deskripsi_en">
                    {{$produk->nama_deskripsi_en}}
                  </textarea>

                  @error('nama_deskripsi_en')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>
            </div>

          <div class="row mt-3">
            <div class="col-md-12 ">
              <label for="foto_produk">Foto Produk Utama(*)</label>
              <div id="foto-dropzone" class="dropzone">Drag & Drop  Foto Utama Produk Disini atau Klik</div>
              <input type="file" id="foto_produk" name="foto_produk" class="form-control d-none @error('foto_produk') is-invalid @enderror">
                  @error('foto_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              <div id="foto-preview" class="preview-container">
                <div class="image-wrapper " id="old-foto">
                  <img src="/storage/{{$produk->foto_produk}}" class="preview-image">
                  <button class="remove-btn" onclick="removeImage('foto-preview')">&times;</button>
                </div>
              </div>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-12">
              <label for="produk_images">Produk Images maksimal 10 foto</label>
               <div id="foto-dropzone-produk" class="dropzone">Drag & Drop Foto Produk lainnya Disini atau Klik</div>
              <input type="file" id="produk_images" name="foto_lainnya[]" multiple class="form-control d-none @error('foto_lainnya') is-invalid @enderror">
              @error('foto_lainnya')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              <div id="produk-preview" class="preview-container">
              <div class="image-wrapper" id="old-foto-lainnya">
                  @foreach($produk_images_foto as $image)
                    <img src="/storage/{{$image->foto_lainnya}}" class="preview-image">
                    <button class="remove-btn" onclick="removeSelectedFile('{{$image->foto_lainnya}}', this)">&times;</button>
                  @endforeach
                  </div>
              </div>
            </div>
          </div>
            <div class="row">
              <div class="col-md-4">
                <div class="d-flex text-center mt-4">
                  <button type="button" class="btn btn-secondary w-100 me-3" onclick="window.history.back(-1);"> <i class="bi bi-arrow-left-circle"></i>Kembali</button>
                  <button type="submit" class="btn button-tambah w-100  "> <i class="bi bi-database-fill-check"></i>Simpan</button>
                </div>
              </div>
            </div>
          </form><!-- End floating Labels Form -->
        </div>
      </div>
    </section>
  </div>

@endsection
@section('scripts')
 <script>
  $(document).ready(function() {
    $('#datatable').DataTable();
    $('#deskripsi_id').summernote({
      height: 300,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link']],
        ['view', ['codeview']]
      ]
    });
    $('#deskripsi_en').summernote({
      height: 300,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['insert', ['link']],
        ['view', ['codeview']]
      ]
    });
  });

  // Fungsi untuk menangani upload foto utama
  document.getElementById("foto-dropzone").addEventListener("click", function() {
    document.getElementById("foto_produk").click();
  });

  document.getElementById("foto_produk").addEventListener("change", function(event) {
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

 // Deklarasikan variabel global untuk menyimpan file yang dipilih
    let selectedFiles = new DataTransfer();

    document.getElementById("foto-dropzone-produk").addEventListener("click", function() {
      document.getElementById("produk_images").click();
    });

    document.getElementById("produk_images").addEventListener("change", function(event) {
      document.getElementById("old-foto-lainnya").remove();
      let files = Array.from(event.target.files); // Ambil file sebagai array
      let previewContainer = document.getElementById("produk-preview");

      files.forEach((file) => {
        // Tambahkan file ke DataTransfer jika belum ada
        if (![...selectedFiles.files].some(f => f.name === file.name)) {
          selectedFiles.items.add(file);

          let reader = new FileReader();
          reader.onload = function(e) {
            let imageWrapper = document.createElement("div");
            imageWrapper.classList.add("image-wrapper");
            imageWrapper.innerHTML = `
              <img src="${e.target.result}" class="preview-image">
              <button class="remove-btn" onclick="removeSelectedFile('${file.name}', this)">&times;</button>
            `;
            previewContainer.appendChild(imageWrapper);
          };
          reader.readAsDataURL(file);
        }
      });

      // Set input file dengan file yang tersimpan di DataTransfer
      document.getElementById("produk_images").files = selectedFiles.files;

      // Jangan reset input (jangan panggil event.target.value = "") agar file tetap tersimpan
    });

    // Fungsi untuk menghapus file yang dipilih (baik dari preview maupun DataTransfer)
    function removeSelectedFile(fileName, btn) {
      let dt = new DataTransfer();
      // Loop melalui file yang tersimpan dan tambahkan file yang tidak cocok ke DataTransfer baru
      [...selectedFiles.files].forEach(file => {
        if (file.name !== fileName) {
          dt.items.add(file);
        }
      });
      // Perbarui selectedFiles dan input file
      selectedFiles = dt;
      document.getElementById("produk_images").files = selectedFiles.files;
      // Hapus preview gambar
      btn.parentElement.remove();
    }

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
