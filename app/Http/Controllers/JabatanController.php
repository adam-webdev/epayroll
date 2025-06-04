<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;

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
        $data = $request->all();
        try {

            if ($request->filled('gaji_pokok')) {
                $data['gaji_pokok'] = Crypt::encryptString($request->gaji_pokok);
            } else {
                $data['gaji_pokok'] = null; // Pastikan null jika input kosong
            }
            if ($request->filled('tunjangan_jabatan')) {
                $data['tunjangan_jabatan'] = Crypt::encryptString($request->tunjangan_jabatan);
            } else {
                $data['tunjangan_jabatan'] = null; // Pastikan null jika input kosong
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengenkripsi data: ' . $e->getMessage());
        }
        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status ?? 'Aktif',
            'gaji_pokok' => $data['gaji_pokok'],
            'tunjangan_jabatan' => $data['tunjangan_jabatan'] ?? 0,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }
    public function edit(Jabatan $jabatan)
    {
        // ---- DEKRIPSI DATA SAAT EDIT UNTUK DIISI KEMBALI DI FORM ----
        try {
            $jabatan->gaji_pokok = Crypt::decryptString($jabatan->gaji_pokok);
            $jabatan->tunjangan_jabatan = Crypt::decryptString($jabatan->tunjangan_jabatan);
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Gagal mendekripsi data karyawan untuk edit. Data mungkin rusak.');
        }
        // -----------------------------------------------------------

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
        $data = $request->all();
        try {

            if ($request->filled('gaji_pokok')) {
                $data['gaji_pokok'] = Crypt::encryptString($request->gaji_pokok);
            } else {
                $data['gaji_pokok'] = null; // Pastikan null jika input kosong
            }
            if ($request->filled('tunjangan_jabatan')) {
                $data['tunjangan_jabatan'] = Crypt::encryptString($request->tunjangan_jabatan);
            } else {
                $data['tunjangan_jabatan'] = null; // Pastikan null jika input kosong
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengenkripsi data: ' . $e->getMessage());
        }
        $jabatan->update([
            'nama_jabatan' => $request->nama_jabatan,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'gaji_pokok' => $data['gaji_pokok'],
            'tunjangan_jabatan' => $data['tunjangan_jabatan'] ?? 0,
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diupdate');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }

    public function decryptIndex(Request $request)
    {

        $adminKey = $request->input('admin_key');
        $decryptionError = false;
        $jabatans = collect();

        if ($adminKey) {
            $jabatans = $this->getDecryptedJabatans($adminKey);
            if ($jabatans === false) {
                $decryptionError = true;
                $jabatans = Jabatan::get();
                session()->flash('error', 'Kunci dekripsi tidak valid atau data rusak. Data ditampilkan dalam bentuk terenkripsi.');
                return redirect()->back();
            }
        } else {
            $jabatans = Jabatan::get();
        }

        return view('jabatan.decrypt', compact('jabatans', 'adminKey', 'decryptionError'));
    }

    private function getDecryptedJabatans(string $adminKey)
    {
        try {
            $decodedAdminKey = base64_decode($adminKey, true);
            if ($decodedAdminKey === false || strlen($decodedAdminKey) !== 32) {
                throw new \InvalidArgumentException('Kunci admin tidak valid atau panjang tidak sesuai.');
            }

            $adminEncrypter = new Encrypter($decodedAdminKey, config('app.cipher'));

            $jabatans = Jabatan::get();

            $jabatans->map(function ($jabatan) use ($adminEncrypter) {
                // Dekripsi nama
                try {
                    $jabatan->gaji_pokok = $adminEncrypter->decryptString($jabatan->gaji_pokok);
                } catch (DecryptException $e) {
                    $jabatan->gaji_pokok = '[Dekripsi Gagal]';
                    Log::warning("Dekripsi Gaji Pokok ID {$jabatan->id} gagal: " . $e->getMessage());
                }

                // Dekripsi nik
                try {
                    $jabatan->tunjangan_jabatan = $adminEncrypter->decryptString($jabatan->tunjangan_jabatan);
                } catch (DecryptException $e) {
                    $jabatan->tunjangan_jabatan = '[Dekripsi Gagal]';
                    Log::warning("Dekripsi Tunjangan Jabatan ID {$jabatan->id} gagal: " . $e->getMessage());
                }



                return $jabatan;
            });

            return $jabatans;
        } catch (DecryptException $e) {
            Log::error('Kesalahan dekripsi massal dengan kunci admin: ' . $e->getMessage());
            return false;
        } catch (\InvalidArgumentException $e) {
            Log::error('Format kunci admin tidak valid saat dekripsi massal: ' . $e->getMessage());
            return false;
        } catch (\Exception $e) {
            Log::error('Kesalahan tak terduga saat dekripsi massal: ' . $e->getMessage());
            return false;
        }
    }
}