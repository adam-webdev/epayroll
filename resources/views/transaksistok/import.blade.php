@extends("layouts.layoutmaster")


@section("content")

  <div class="card p-4">
      <h2>Import Data
      </h2>
    <div class="body">
      <div class="col-md-12 col-lg-12">
        <form action="{{ route('sapi.import') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="path">Upload File Excel/CSV format(.xlsx,  .csv)</label>
            <div class="drag-area mt-2" id="dragArea">Drag & drop PDF file here or click to upload </div>
            <input type="file" name="file_import" id="fileInput" style="display: none;" class="form-control @error('file_import') is-invalid @enderror" required>
            <div id="filePreview" class="file-preview"></div>
          </div>
             @error('file_import')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror


          <div class="form-group mt-4">
            <button type="submit" class="btn button-tambah w-100">Simpan Data</button>
          </div>

        </form>
      </div>
    </div>
  </div>

<style>
.drag-area {
  border: 2px dashed #012970;
  border-radius: 5px;
  background: #f8f9fa;
  padding: 30px;
  text-align: center;
  font-size: 18px;
  color: #012970;
  cursor: pointer;
  margin-bottom: 10px;
}



.drag-area:hover,
.drag-area-thumbnail:hover {
  background: #e9ecef;
}

.drag-area.dragover {
  background: #d3d3d3;
}

.file-preview {
  font-size: 16px;
  margin-top: 10px;
  color: #555;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const dragArea = document.getElementById('dragArea');

  const fileInput = document.getElementById('fileInput');
  const filePreview = document.getElementById('filePreview');

  // Klik pada area drag untuk memicu input file
  dragArea.addEventListener('click', () => {
    fileInput.click();
  });

  // Tampilkan nama file yang di-upload
  fileInput.addEventListener('change', () => {
    const file = fileInput.files[0];
    if (file) {
      filePreview.textContent = `Selected file: ${file.name}`;
    } else {
      filePreview.textContent = '';
    }
  });

  // Drag and Drop
  dragArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    dragArea.classList.add('dragover');
  });

  dragArea.addEventListener('dragleave', () => {
    dragArea.classList.remove('dragover');
  });

  dragArea.addEventListener('drop', (event) => {
    event.preventDefault();
    dragArea.classList.remove('dragover');

    const file = event.dataTransfer.files[0];
    if (file) {
      fileInput.files = event.dataTransfer.files; // Assign file to input
      filePreview.textContent = `Selected file: ${file.name}`;
    }
  });


  // Klik pada area drag untuk memicu input file


});
</script>

@endsection