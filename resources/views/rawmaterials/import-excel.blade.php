@extends('layouts.layoutmaster')
@section('title','Import Excel Raw Material')
@section('css')
@endsection
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h4 class="h4 mb-0 text-gray-700">Import Excel Raw Material</h4>
</div>
<div class="card p-3">
    <form action="{{ route('rawmaterial.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <div class="col-md-6">
      <label for="file">Format (.xlsx, .xls, .csv)</label>
      <input id="file" type="file" name="file" class="form-control mt-2" required>
      <button type="submit" name="export"  class="btn btn-success w-50 mt-4">
        <i class="bi bi-file-earmark-excel"></i> Import
      </button>
    </div>
  </div>
</form>

</div>


@endsection
