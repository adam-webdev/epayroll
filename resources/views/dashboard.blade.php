
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

    body {
            background-color: #f8f9fa; /* Light background for the page */
        }
        .dashboard-card {
            background-color: #fff;
            border-radius: 12px; /* Slightly more rounded corners */
            box-shadow: 0 6px 12px rgba(0,0,0,0.1); /* Stronger shadow */
            padding: 25px;
            text-align: center;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            min-height: 180px; /* Slightly taller cards */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Center content horizontally */
        }
        .dashboard-card:hover {
            transform: translateY(-8px); /* More pronounced lift on hover */
            box-shadow: 0 10px 20px rgba(0,0,0,0.15); /* Stronger shadow on hover */
        }
        .card-icon {
            font-size: 3.5rem; /* Larger icon size */
            margin-bottom: 15px;
            line-height: 1; /* Prevent extra space below icon */
        }
        .card-title {
            font-size: 1.2rem; /* Slightly larger title */
            font-weight: 600; /* Bolder title */
            margin-bottom: 8px;
            color: #495057; /* Darker grey for titles */
        }
        .card-value {
            font-size: 3rem; /* Larger value */
            font-weight: bold;
            line-height: 1; /* Prevent extra space */
        }

        /* Card Specific Styles (Backgrounds and Icon Colors) */
        .card-primary {
            background-color: #e0f2f7; /* Light blue background */
        }
        .card-primary .card-icon {
            color: #007bff; /* Primary blue icon */
        }
        .card-success {
            background-color: #e6ffed; /* Light green background */
        }
        .card-success .card-icon {
            color: #28a745; /* Success green icon */
        }
        .card-warning {
            background-color: #fff0e6; /* Light orange background */
        }
        .card-warning .card-icon {
            color: #ffc107; /* Warning orange icon */
        }
        .card-info {
            background-color: #e0f7fa; /* Light cyan background */
        }
        .card-info .card-icon {
            color: #17a2b8; /* Info cyan icon */
        }
        .card-danger {
            background-color: #ffe6e6; /* Light red background */
        }
        .card-danger .card-icon {
            color: #dc3545; /* Danger red icon */
        }
        .card-secondary {
            background-color: #eff2f5; /* Light grey background */
        }
        .card-secondary .card-icon {
            color: #6c757d; /* Secondary grey icon */
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

        <div class="container mt-5">
            <h2 class="mb-5 text-center text-secondary">Dashboard HR & Payroll</h2>

            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card card-primary">
                        <div class="card-icon"><i class='bx bxs-user-detail'></i></div>
                        <div class="card-title">Total Karyawan</div>
                        <div class="card-value">{{ $totalKaryawan }}</div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card card-success">
                        <div class="card-icon"><i class='bx bxs-briefcase'></i></div>
                        <div class="card-title">Total Jabatan</div>
                        <div class="card-value">{{ $totalJabatan }}</div>
                    </div>
                </div>

                {{-- <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card card-warning">
                        <div class="card-icon"><i class='bx bxs-calendar-event'></i></div>
                        <div class="card-title">Hari Libur Bulan Ini</div>
                        <div class="card-value">{{ $hariLiburBulanIni }}</div>
                    </div>
                </div> --}}

                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card card-info">
                        <div class="card-icon"><i class='bx bxs-calendar-check'></i></div>
                        <div class="card-title">Absensi Hari Ini</div>
                        <div class="card-value">{{ $absensiHariIni }}</div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card card-secondary">
                        <div class="card-icon"><i class='bx bxs-user-check'></i></div>
                        <div class="card-title">Hadir Hari Ini</div>
                        <div class="card-value">{{ $hadirHariIni }}</div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card card-danger">
                        <div class="card-icon"><i class='bx bxs-user-x'></i></div>
                        <div class="card-title">Sakit Hari Ini</div>
                        <div class="card-value">{{ $sakitHariIni }}</div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="dashboard-card card-primary">
                        <div class="card-icon"><i class='bx bxs-user-plus'></i></div>
                        <div class="card-title">Izin Hari Ini</div>
                        <div class="card-value">{{ $izinHariIni }}</div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
