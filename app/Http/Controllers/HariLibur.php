<?php

namespace App\Http\Controllers;

use App\Models\HariLibur as ModelsHariLibur;
use Illuminate\Http\Request;

class HariLibur extends Controller
{
    public function index()
    {
        $hariLibur = ModelsHariLibur::orderBy('id', 'desc')->get();
        return view('harilibur.index', compact('hariLibur'));
    }
    public function create()
    {
        // Logic to show the form for creating a new holiday
        return view('harilibur.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal',
            'nama' => 'required|string|max:255',
            'is_nasional' => 'boolean',
            'tahun' => 'required|integer|min:2000|max:2100',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'tanggal.unique' => 'Tanggal sudah ada.',
            'nama.required' => 'Nama hari libur wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'is_nasional.boolean' => 'Is Nasional harus berupa boolean.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 2000.',
            'tahun.max' => 'Tahun maksimal 2100.',
        ]);
        ModelsHariLibur::create([
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'is_nasional' => $request->is_nasional ?? true,
            'tahun' => $request->tahun,
        ]);
        return redirect()->route('harilibur.index')->with('success', 'Hari libur berhasil ditambahkan');
    }

    public function edit(ModelsHariLibur $harilibur)
    {
        return view('harilibur.edit', compact('harilibur'));
    }
    public function update(Request $request, ModelsHariLibur $harilibur)
    {
        $request->validate([
            'tanggal' => 'required|date|unique:hari_liburs,tanggal,' . $harilibur->id,
            'nama' => 'required|string|max:255',
            'is_nasional' => 'boolean',
            'tahun' => 'required|integer|min:2000|max:2100',
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'tanggal.unique' => 'Tanggal sudah ada.',
            'nama.required' => 'Nama hari libur wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'is_nasional.boolean' => 'Is Nasional harus berupa boolean.',
            'tahun.required' => 'Tahun wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun minimal 2000.',
            'tahun.max' => 'Tahun maksimal 2100.',
        ]);
        $harilibur->update([
            'tanggal' => $request->tanggal,
            'nama' => $request->nama,
            'is_nasional' => $request->is_nasional ?? true,
            'tahun' => $request->tahun,
        ]);
        return redirect()->route('harilibur.index')->with('success', 'Hari libur berhasil diperbarui');
    }
    public function destroy(ModelsHariLibur $harilibur)
    {
        $harilibur->delete();
        return redirect()->route('harilibur.index')->with('success', 'Hari libur berhasil dihapus');
    }
    public function show(ModelsHariLibur $harilibur)
    {
        return view('harilibur.show', compact('hariLibur'));
    }
    public function getHariLiburByTahun($tahun)
    {
        $hariLibur = ModelsHariLibur::where('tahun', $tahun)->get();
        return response()->json($hariLibur);
    }
    public function getHariLiburByTanggal($tanggal)
    {
        $hariLibur = ModelsHariLibur::where('tanggal', $tanggal)->first();
        if ($hariLibur) {
            return response()->json($hariLibur);
        }
        return response()->json(['message' => 'Hari libur tidak ditemukan'], 404);
    }
    public function getHariLiburNasional()
    {
        $hariLibur = ModelsHariLibur::where('is_nasional', true)->get();
        return response()->json($hariLibur);
    }
    public function getHariLiburNonNasional()
    {
        $hariLibur = ModelsHariLibur::where('is_nasional', false)->get();
        return response()->json($hariLibur);
    }
}