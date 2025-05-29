<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::select('id', 'nama_jabatan')->get();
        $karyawans = Karyawan::with('jabatan', 'user')->get();
        return view('karyawan.index', compact('karyawans', 'jabatans'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        $users = User::all();
        return view('karyawan.create', compact('jabatans', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:karyawans,nik',
            'email' => 'nullable|email|unique:karyawans,email',
            'no_hp' => 'required|unique:karyawans,no_hp',
            'jabatan_id' => 'required|exists:jabatans,id',
            'user_id' => 'nullable|exists:users,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_karyawan', 'public');
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit(Karyawan $karyawan)
    {
        $jabatans = Jabatan::all();
        $users = User::all();
        return view('karyawan.edit', compact('karyawan', 'jabatans', 'users'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required',
            'nik' => 'required|unique:karyawans,nik,' . $karyawan->id,
            'email' => 'nullable|email|unique:karyawans,email,' . $karyawan->id,
            'no_hp' => 'required|unique:karyawans,no_hp,' . $karyawan->id,
            'jabatan_id' => 'required|exists:jabatans,id',
            'user_id' => 'nullable|exists:users,id',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($karyawan->foto && file_exists(public_path('storage/' . $karyawan->foto))) {
                unlink(public_path('storage/' . $karyawan->foto));
            }
            $data['foto'] = $request->file('foto')->store('foto_karyawan', 'public');
        }

        $karyawan->update($data);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(Karyawan $karyawan)
    {
        if ($karyawan->foto && file_exists(public_path('storage/' . $karyawan->foto))) {
            unlink(public_path('storage/' . $karyawan->foto));
        }

        $karyawan->delete();

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus');
    }
}