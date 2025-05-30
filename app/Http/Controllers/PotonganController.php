<?php

namespace App\Http\Controllers;

use App\Models\Potongan;
use Illuminate\Http\Request;

class PotonganController extends Controller
{
    public function index()
    {
        $potongans = Potongan::all();
        return view('potongan.index', compact('potongans'));
    }

    public function create()
    {
        return view('potongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_potongan' => 'required|unique:potongans,nama_potongan',
            'tipe' => 'required|in:persentase,nominal',
            'nilai' => 'required|numeric',
        ], [
            'nama_potongan.required' => 'Nama potongan harus diisi',
            'nama_potongan.unique' => 'Nama potongan sudah ada',
            'tipe.required' => 'Tipe potongan harus dipilih',
            'tipe.in' => 'Tipe potongan tidak valid',
            'nilai.required' => 'Nilai potongan harus diisi',
            'nilai.numeric' => 'Nilai potongan harus berupa angka',
        ]);

        Potongan::create([
            'nama_potongan' => $request->nama_potongan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status ?? 'Aktif',
            'tipe' => $request->tipe,
            'nilai' => $request->nilai,
            'otomatis' => $request->has('otomatis'),
        ]);

        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil ditambahkan');
    }

    public function edit(Potongan $potongan)
    {
        return view('potongan.edit', compact('potongan'));
    }

    public function update(Request $request, Potongan $potongan)
    {
        $request->validate([
            'nama_potongan' => 'required|unique:potongans,nama_potongan,' . $potongan->id,
            'tipe' => 'required|in:persentase,nominal',
            'nilai' => 'required|numeric',
            'otomatis' => 'nullable|boolean',
        ], [
            'nama_potongan.required' => 'Nama potongan harus diisi',
            'nama_potongan.unique' => 'Nama potongan sudah ada',
            'tipe.required' => 'Tipe potongan harus dipilih',
            'tipe.in' => 'Tipe potongan tidak valid',
            'nilai.required' => 'Nilai potongan harus diisi',
            'nilai.numeric' => 'Nilai potongan harus berupa angka',
            'otomatis.boolean' => 'Otomatis harus berupa true atau false',
        ]);

        $potongan->update([
            'nama_potongan' => $request->nama_potongan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'tipe' => $request->tipe,
            'nilai' => $request->nilai,
            'otomatis' => $request->otomatis,
        ]);

        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil diperbarui');
    }

    public function destroy(Potongan $potongan)
    {
        $potongan->delete();
        return redirect()->route('potongan.index')->with('success', 'Potongan berhasil dihapus');
    }
}