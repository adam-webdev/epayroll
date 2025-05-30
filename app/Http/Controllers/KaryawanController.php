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
        $users = User::select('id', 'name')->get();
        return view('karyawan.index', compact('karyawans', 'jabatans', 'users'));
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

        ], [
            'nama.required' => 'Nama karyawan harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'Nomor HP harus diisi',
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'jabatan_id.required' => 'Jabatan harus dipilih',
            'jabatan_id.exists' => 'Jabatan tidak ditemukan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_karyawan', 'public');
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('jabatan', 'user');
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('jabatan', 'user');
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
        ], [
            'nama.required' => 'Nama karyawan harus diisi',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'Nomor HP harus diisi',
            'no_hp.unique' => 'Nomor HP sudah terdaftar',
            'jabatan_id.required' => 'Jabatan harus dipilih',
            'jabatan_id.exists' => 'Jabatan tidak ditemukan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
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