<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title','Dashboard')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Favicon -->
  <link rel="icon" href="{{ asset('assets_home/favicon_io/favicon.ico') }}" type="image/x-icon">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets_home/favicon_io/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets_home/favicon_io/favicon-32x32.png') }}">

  <!-- Apple Touch Icon -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets_home/favicon_io/apple-touch-icon.png') }}">

  <!-- Android Chrome Icons -->
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets_home/favicon_io/android-chrome-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('assets_home/favicon_io/android-chrome-512x512.png') }}">

  <!-- Manifest (optional, for PWA support) -->
  <link rel="manifest" href="{{ asset('assets_home/favicon_io/site.webmanifest') }}">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">


  <!-- datatable -->
   <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">


  <!-- Vendor CSS Files -->


  <link href="{{ asset('assets/vendor/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/summernote/summernote-bs5.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
  @yield('css')

  <style>

    .btn-detail-soft {
      background-color: rgba(65, 255, 125, 0.2); /* soft yellow */
      color: #1a9f00e4;
      margin-top:2px;
      border-radius: 20px;
      padding: 6px 10px;
      transition: all 0.3s ease;
      border: 1px solid #afafaf; /* darker yellow */

    }

    .btn-detail-soft:hover {
      border: 1px solid #00e0a0; /* darker yellow */
    }
    .btn-edit-soft {
      margin-top:2px;
      background-color: rgba(255, 193, 7, 0.2); /* soft yellow */
      color: #ffc107;
      border-radius: 20px;
      padding: 6px 10px;
      transition: all 0.3s ease;
      border: 1px solid #afafaf; /* darker yellow */

    }

    .btn-edit-soft:hover {
      border: 1px solid #e0a800; /* darker yellow */
    }

    .btn-delete-soft {
      margin-top:2px;

      border: 1px solid #afafaf; /* darker yellow */
      background-color: rgba(255, 107, 129, 0.2); /* soft pink */
      color: #ff6b81;
      border-radius: 20px;
      padding: 6px 10px;
      transition: all 0.3s ease;
    }

    .btn-delete-soft:hover {
      border: 1px solid #e64963; /* darker pink */
    }

/* Fix tinggi input Select2 dalam form-floating */
  .select2-container--default .select2-selection--single {
    height: 58px !important;
    padding: 1rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    display: flex;
    align-items: center;
  }

  .select2-selection__rendered {
    font-size: 1rem;
    line-height: 1.5;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 100%;
    top: 0.75rem;
    right: 0.75rem;
    position: absolute;
  }

  /* Biarkan floating label tetap terlihat */
  .form-floating > .select2-container {
    height: auto !important;
  }

  .form-floating > label {
    top: -0.5rem;
    left: 0.75rem;
    font-size: 0.85rem;
    opacity: 1;
  }


  </style>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <div class="mr-4 d-flex align-items-center gap-2" style="width: 260px;">
        <img width="150px" style="object-fit: contain;"  src="{{asset('assets/img/logo/logo1.png')}}" alt="Logo splatinum" class="mr-4">
      </div>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar ">
        <span >Sistem  Informasi Penggajian Karyawan</span>

      <!-- <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form> -->
    </div>
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">


        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{asset('assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{auth()->user()->name}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{auth()->user()->name}}</h6>
              <span>Role {{auth()->user()->getRoleNames()->first()}} Sistem</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li> -->
            <li>
              <hr class="dropdown-divider">
            </li>

            <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li> -->
            <!-- <li>
              <hr class="dropdown-divider">
            </li> -->


            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                  <i class="bi bi-box-arrow-right"></i>
                  <span>Sign Out</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Master Data</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('users.index')}}">
             <!-- <i class="bi bi-person" style="font-size: 14px;"></i> -->
             <i class='bx bxs-user-circle' style="font-size: 14px;"></i>
             <span>Pengguna</span>
            </a>
          </li>

          <li>
            <a href="{{route('karyawan.index')}}">
             <i class="bi bi-person" style="font-size: 14px;"></i>
             <span>Karyawan</span>
            </a>
          </li>
          <li>
            <a href="{{route('jabatan.index')}}">
              <i class="bx bxs-user-account" style="font-size: 14px;"></i><span>Jabatan</span>
            </a>
          </li>
          <li>
            <a href="{{route('potongan.index')}}">
              <i class="bx bx-notepad" style="font-size: 14px;"></i><span>Potongan</span>
            </a>
          </li>
          <li>
            <a href="{{route('harilibur.index')}}">
              <i class="bx  bx-calendar-check" style="font-size: 14px;"></i><span>Hari Libur</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav1" data-bs-toggle="collapse" href="#">
          <i class='bx bx-money-withdraw'></i>
         <span>Transaksi</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav1" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('absensi.index')}}">
             <i class='bx bxs-notepad' style="font-size: 14px;"></i>
             <span>Absensi</span>
            </a>
          </li>
          <li>
            <a href="{{route('gaji.index')}}">
             <i class='bx bxs-donate-heart' style="font-size: 14px;"></i>
             <span>Gaji</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="bx bxs-user-account" style="font-size: 14px;"></i><span>Stok Material</span>
            </a>
          </li>

        </ul>
      </li>



      <!-- End Tables Nav -->



      <!-- <li class="nav-heading">Pages</li> -->







    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      @php
        $segments = Request::segments();
      @endphp
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item">
                  <a href="{{ url('/') }}">Home</a>
              </li>
              @foreach($segments as $index => $segment)
                  @php
                      $url = url(implode('/', array_slice($segments, 0, $index + 1)));
                      $isLast = $loop->last;
                      $name = ucwords(str_replace('-', ' ', $segment));
                  @endphp
                  @if ($isLast)
                      <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
                  @else
                      <li class="breadcrumb-item">
                          <a href="{{ $url }}">{{ $name }}</a>
                      </li>
                  @endif
              @endforeach
          </ol>
      </nav>

    </div><!-- End Page Title -->

    <div class="section">
      @yield('content')
    </div>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <!-- <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>MySistem</span></strong>. All Rights Reserved
    </div>

  </footer> -->
  <!-- End Footer -->


  <!-- End Toast -->
<!-- Toast Notification -->
@if (session('success') || session('error') || session('info'))
<div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div class="toast align-items-center text-bg-success border-0 show {{ session('error') ? 'text-bg-danger' : (session('info') ? 'text-bg-info' : 'text-bg-success') }}" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                {{ session('success') ?? session('error') ?? session('info') }}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>
@endif
<!-- End Toast -->

  <!-- End Toast -->



  <a href="#" class="back-to-top d-flex align-items-center justify-content-center button-tambah"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('assets/vendor/quill/quill.js')}}"></script>
  <script src="{{asset('assets/vendor/summernote/summernote-bs5.min.js')}}"></script>
  <!-- <script src="{{asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script> -->
  <script src="{{asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
  <!-- Template Main JS File -->

  <script src="{{asset('assets/js/main.js')}}"></script>


  <script>
    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = toastElList.map(function (toastEl) {
            return new bootstrap.Toast(toastEl);
        });

        toastList.forEach(toast => toast.show());
    });
</script>
  @yield('scripts')


</body>

</html>