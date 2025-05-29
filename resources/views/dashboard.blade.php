
 @extends('layouts.layoutmaster')
@section('css')
 <style>
    .table-sm th, .table-sm td {
        font-size: 12px;
        vertical-align: middle;
    }
    .table-title {
        font-size: 14px;
        font-weight: bold;
    }
    i{
        font-size: 30px;
    }
    @media screen and (max-width: 768px) {
      .card-text{
          font-size: 12px;
      }
      .card-nilai{
          font-size: 14px;
      }

    }

</style>
@endsection

@section('content')
@include('sweetalert::alert')

    <section class="section dashboard">
      <div class=" gap-4">
              <!-- CARD TOTAL NILAI ASET -->
        <div class="row">
            <h4>Selamat Datang {{auth()->user()->name}}</h4>
        </div>
      </div>
    </section>

@endsection
