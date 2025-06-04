<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index()
    {
        $bonus = Bonus::all();
        return view('bonus.index', compact('bonus'));
    }

    public function create()
    {
        return view('bonus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bonus' => 'required|unique:bonuses,nama_bonus',
            'tipe' => 'required|in:persentase,nominal',
            'nilai' => 'required|numeric',
        ], [
            'nama_bonus.required' => 'Nama bonus harus diisi',
            'nama_bonus.unique' => 'Nama bonus sudah ada',
            'tipe.required' => 'Tipe bonus harus dipilih',
            'tipe.in' => 'Tipe bonus tidak valid',
            'nilai.required' => 'Nilai bonus harus diisi',
            'nilai.numeric' => 'Nilai bonus harus berupa angka',
        ]);

        Bonus::create([
            'nama_bonus' => $request->nama_bonus,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status ?? 'Aktif',
            'tipe' => $request->tipe,
            'nilai' => $request->nilai,
            'otomatis' => $request->has('otomatis'),
        ]);

        return redirect()->route('bonus.index')->with('success', 'bonus berhasil ditambahkan');
    }

    public function edit(bonus $bonus)
    {
        return view('bonus.edit', compact('bonus'));
    }

    public function update(Request $request, bonus $bonus)
    {
        $request->validate([
            'nama_bonus' => 'required|unique:bonuses,nama_bonus,' . $bonus->id,
            'tipe' => 'required|in:persentase,nominal',
            'nilai' => 'required|numeric',
            'otomatis' => 'nullable|boolean',
        ], [
            'nama_bonus.required' => 'Nama bonus harus diisi',
            'nama_bonus.unique' => 'Nama bonus sudah ada',
            'tipe.required' => 'Tipe bonus harus dipilih',
            'tipe.in' => 'Tipe bonus tidak valid',
            'nilai.required' => 'Nilai bonus harus diisi',
            'nilai.numeric' => 'Nilai bonus harus berupa angka',
            'otomatis.boolean' => 'Otomatis harus berupa true atau false',
        ]);

        $bonus->update([
            'nama_bonus' => $request->nama_bonus,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'tipe' => $request->tipe,
            'nilai' => $request->nilai,
            'otomatis' => $request->otomatis,
        ]);

        return redirect()->route('bonus.index')->with('success', 'bonus berhasil diperbarui');
    }

    public function destroy(bonus $bonus)
    {
        $bonus->delete();
        return redirect()->route('bonus.index')->with('success', 'bonus berhasil dihapus');
    }
}