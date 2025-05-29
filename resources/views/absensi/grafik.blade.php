@extends('layouts.layoutmaster')
@section('title', 'Grafik Kehadiran Karyawan')
@section('css')

  <style>
    h4{
        font-size: 18px;
        margin-bottom: 20px;
    }
      @media (max-width: 576px) {
        select option{
            font-size: 12px !important;
        }
        .card-header {
            font-size: 13px;
            padding: 8px 12px;
        }
        h2 {
            font-size: 18px;
        }
        .btn {
            font-size: 12px;
            padding: 6px 12px;
        }
        .chart-container{
            width: 100%;
            height: 300px;
        }

        .chart{
            width: 100%;
            height: 300px;
        }

    }
    @media (max-width: 540px) {
    .chart-container{
        width: 500px;
        height: 300px;
    }
    .card{
        padding: 0;
        margin: 0;
        }
    }
  </style>

@endsection
@section('content')
<div class="container">
  <div class="card p-4">
    <form method="GET" class="mb-3">
      <div class="row">
        <div class="col-sm-12 col-md-5">
           <select name="karyawan_id" id="karyawan" class="form-control form-select me-2 mt-2" required>
            @foreach (\App\Models\Karyawan::all() as $k)
                <option value="{{ $k->id }}" {{ request('karyawan_id') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
        </div>
        <div class="col-sm-12 col-md-5">
          <select name="tahun" class="form-control me-2 mt-2" required>
              @for ($y = 2020; $y <= now()->year; $y++)
                  <option value="{{ $y }}" {{ request('tahun') == $y ? 'selected' : '' }}>
                      {{ $y }}
                  </option>
              @endfor
          </select>
        </div>
        <div class="col-sm-12 col-md-2">
          <button type="submit" class="btn button-tambah mt-2">Tampilkan</button>
        </div>
      </div>
    </form>
  </div>

  <div class="card p-4">
    <h4>Grafik Kehadiran: {{ $karyawan->nama }} - Tahun {{ $tahun }}</h4>
    <div class="chart-container" style="position: relative; height: 500px; width: 100%;">
        <canvas id="kehadiranChart"></canvas>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
    $('#karyawan').select2({
      placeholder: 'Pilih Karyawan',
      width: '100%'
    });

    const ctx = document.getElementById('kehadiranChart').getContext('2d');
    const kehadiranChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
            datasets: [
                {
                    label: 'Hadir',
                    data: {{ json_encode($data['hadir']) }},
                    borderColor: 'green',
                    backgroundColor: 'rgba(0,128,0,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                },
                {
                    label: 'Izin',
                    data: {{ json_encode($data['izin']) }},
                    borderColor: 'orange',
                    backgroundColor: 'rgba(255,165,0,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                },
                {
                    label: 'Sakit',
                    data: {{ json_encode($data['sakit']) }},
                    borderColor: 'skyblue',
                    backgroundColor: 'rgba(135,206,235,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                },
                {
                    label: 'Alpha',
                    data: {{ json_encode($data['alpha']) }},
                    borderColor: 'red',
                    backgroundColor: 'rgba(255,0,0,0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 20,
                    bottom: 20,
                    left: 10,
                    right: 10
                }
            },
            plugins: {
                legend: {
                    labels: {
                        font: {
                            size: 14
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Rekap Kehadiran Per Tahun',
                    font: {
                        size: 18
                    }
                },
                tooltip: {
                    bodyFont: {
                        size: 14
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>
@endsection

