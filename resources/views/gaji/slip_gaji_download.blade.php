<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slip Gaji - {{ $slipGaji->gaji->karyawan->nama_plain ?? $slipGaji->gaji->karyawan->nama }}</title>
    <style>
        /* Definisi CSS dasar untuk PDF */
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Font yang mendukung karakter unicode, penting untuk Dompdf */
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            padding: 20px;
            box-sizing: border-box; /* Agar padding dihitung dalam lebar */
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #0056b3;
            margin: 0;
            font-size: 18px;
        }
        .header p {
            font-size: 11px;
            color: #555;
            margin-top: 5px;
        }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
            color: #34495e;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
        }
        .info-table, .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table td, .detail-table td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 35%; /* Atur lebar label */
            color: #2c3e50;
        }
        .detail-table td:first-child {
            width: 65%; /* Atur lebar label */
            color: #2c3e50;
        }
        .detail-table td:last-child {
            text-align: right;
            font-weight: bold;
            color: #34495e;
        }
        .info-item-indent {
            padding-left: 20px; /* Indentasi untuk rincian bonus/potongan */
        }
        .total-gaji {
            border-top: 2px solid #eee;
            margin-top: 15px;
            padding-top: 10px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #28a745;
        }
        .footer-note {
            font-size: 9px;
            color: #777;
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SLIP GAJI</h1>
            <p><strong>Yayasan Pendidikan Islam AN NADWAH</strong></p> <p>Bulan: {{ \Carbon\Carbon::createFromDate($slipGaji->gaji->tahun, $slipGaji->gaji->bulan, 1)->translatedFormat('F Y') }} | Nomor Slip: {{ $slipGaji->nomor_slip }}</p>
        </div>

        <div class="section-title">Informasi Karyawan</div>
        <table class="info-table">
            <tr>
                <td>Nama Karyawan:</td>
                <td>{{ $slipGaji->gaji->karyawan->nama ?? $slipGaji->gaji->karyawan->nama }}</td>
            </tr>
            <tr>
                <td>NIK:</td>
                <td>{{ $slipGaji->gaji->karyawan->nik ?? $slipGaji->gaji->karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Jabatan:</td>
                <td>{{ $slipGaji->gaji->karyawan->jabatan->nama_jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <td>Email:</td>
                <td>{{ $slipGaji->gaji->karyawan->email ?? $slipGaji->gaji->karyawan->email }}</td>
            </tr>
            <tr>
                <td>No. HP:</td>
                <td>{{ $slipGaji->gaji->karyawan->no_hp ?? $slipGaji->gaji->karyawan->no_hp }}</td>
            </tr>
            <tr>
                <td>Alamat:</td>
                <td>{{ $slipGaji->gaji->karyawan->alamat ?? $slipGaji->gaji->karyawan->alamat }}</td>
            </tr>
        </table>

        <div class="section-title">Rincian Gaji</div>
        <table class="detail-table">
            <tr>
                <td>Gaji Pokok:</td>
                <td>Rp {{ number_format($slipGaji->gaji->gaji_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tunjangan:</td>
                <td>Rp {{ number_format($slipGaji->gaji->tunjangan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Bonus:</td>
                <td>Rp {{ number_format($slipGaji->gaji->total_bonus, 0, ',', '.') }}</td>
            </tr>
            @if($slipGaji->gaji->gajiBonuses->isNotEmpty())
                <tr>
                    <td colspan="2" style="font-weight: normal; padding-top: 5px;">Rincian Bonus:</td>
                </tr>
                @foreach ($slipGaji->gaji->gajiBonuses as $bonusItem)
                    <tr>
                        <td class="info-item-indent">- {{ $bonusItem->bonus->nama_bonus ?? '[Bonus Tidak Ditemukan]' }}:</td>
                        <td>Rp {{ number_format($bonusItem->jumlah_bonus, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif
        </table>

        <div class="section-title">Potongan</div>
        <table class="detail-table">
            <tr>
                <td>Total Potongan:</td>
                <td>Rp {{ number_format($slipGaji->gaji->total_potongan, 0, ',', '.') }}</td>
            </tr>
            @if($slipGaji->gaji->gajiPotongans->isNotEmpty())
                <tr>
                    <td colspan="2" style="font-weight: normal; padding-top: 5px;">Rincian Potongan:</td>
                </tr>
                @foreach ($slipGaji->gaji->gajiPotongans as $potonganItem)
                    <tr>
                        <td class="info-item-indent">- {{ $potonganItem->potongan->nama_potongan ?? '[Potongan Tidak Ditemukan]' }}:</td>
                        <td>Rp {{ number_format($potonganItem->jumlah_potongan, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            @endif
        </table>

        <div class="total-gaji">
            Gaji Bersih: Rp {{ number_format($slipGaji->gaji->gaji_bersih, 0, ',', '.') }}
        </div>

        <div class="footer-note">
            Slip gaji ini berlaku sebagai bukti pembayaran dan dibuat secara otomatis oleh sistem pada tanggal {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}.
            <br>Mohon laporkan ke bagian HRD jika ada ketidaksesuaian.
        </div>
    </div>
</body>
</html>