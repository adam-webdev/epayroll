@extends('layouts.templatepdf')

@section('content')
<hr>
<h3 style="text-align:center;">Laporan Data Bahan Baku (Raw Material) {{$kategori != null ? "Kategori ". $kategori : "s"}}</h3>

<table width="100%" style="border-collapse: collapse; margin-top: 20px; font-size: 11px;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th style="border: 0.1px solid #000; padding: 6px;">No</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Kode</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Nama</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Merk</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Supplier</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Satuan</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Kategori</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Warna</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Panjang</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Lebar</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Ketebalan</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Minimal Stok</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Stok</th>
            <th style="border: 0.1px solid #000; padding: 6px;">Harga Beli</th>
        </tr>
    </thead>
    <tbody>

        @foreach($data as $i => $row)
            <tr>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $i + 1 }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->kode }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->nama }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->merk }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->supplier->nama ?? '-' }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->satuan }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->kategori }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->warna }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->panjang }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->lebar }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ $row->ketebalan }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ (int)$row->minimal_stok }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">{{ (int) $row->stok }}</td>
                <td style="border: 0.1px solid #000; padding: 6px;">Rp. {{ number_format($row->harga_beli, 0,0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
