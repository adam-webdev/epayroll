<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|unique:jabatans,nama_jabatan',
            'gaji_pokok' => 'required|numeric',
            'tunjangan_jabatan' => 'nullable|numeric',
        ], [
            'nama_jabatan.required' => 'Nama jabatan harus diisi',
            'nama_jabatan.unique' => 'Nama jabatan sudah ada',
            'gaji_pokok.required' => 'Gaji pokok harus diisi',
            'gaji_pokok.numeric' => 'Gaji pokok harus berupa angka',
            'tunjangan_jabatan.numeric' => 'Tunjangan jabatan harus berupa angka',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status ?? 'Aktif',
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan_jabatan' => $request->tunjangan_jabatan ?? 0,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    public function show(Jabatan $jabatan)
    {
        return view('jabatan.show', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'nama_jabatan' => 'required|unique:jabatans,nama_jabatan,' . $jabatan->id,
            'gaji_pokok' => 'required|numeric',
            'tunjangan_jabatan' => 'nullable|numeric',
        ], [
            'nama_jabatan.required' => 'Nama jabatan harus diisi',
            'nama_jabatan.unique' => 'Nama jabatan sudah ada',
            'gaji_pokok.required' => 'Gaji pokok harus diisi',
            'gaji_pokok.numeric' => 'Gaji pokok harus berupa angka',
            'tunjangan_jabatan.numeric' => 'Tunjangan jabatan harus berupa angka',
        ]);

        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan_jabatan' => $request->tunjangan_jabatan ?? 0,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diupdate');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}