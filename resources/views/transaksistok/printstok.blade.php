@extends('layouts.templatepdf')

@section('content')
<hr>
<h3 style="text-align:center;">Laporan Transaksi Stok</h3>
<p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($from)->format('d M Y') }} - {{ \Carbon\Carbon::parse($to)->format('d M Y') }}</p>
<p><strong>Status :</strong> {{ $tipe === 'all' ? 'Stok Masuk & Keluar' : ucfirst($tipe) }}</p>

<table width="100%" style="border-collapse: collapse; margin-top: 20px; font-size: 11px;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th style="border: 0.1px solid #000; padding: 6px;">No</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Nama Bahan</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Status</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Stok Sebelumnya</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Jumlah</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Stok Sesudah</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Tanggal</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
            <tr >
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $i + 1 }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->rawMaterial->nama ?? '-' }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ ucfirst($row->tipe) }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->stok_sebelumnya }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->jumlah }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->stok_sesudah }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">
               {{ ($row->tanggal) }}
              </td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->catatan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
