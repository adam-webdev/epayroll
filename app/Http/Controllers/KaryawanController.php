<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::with('jabatan', 'user')->get();
        $jabatans = Jabatan::select('id', 'nama_jabatan')->get();
        $users = User::select('id', 'name')->get();
        return view('karyawan.index', compact('karyawans', 'jabatans', 'users'));
    }

    public function decryptIndex(Request $request)
    {
        $jabatans = Jabatan::select('id', 'nama_jabatan')->get();
        $users = User::select('id', 'name')->get();

        $adminKey = $request->input('admin_key');
        $decryptionError = false;
        $karyawans = collect();

        if ($adminKey) {
            $karyawans = $this->getDecryptedKaryawans($adminKey);
            if ($karyawans === false) {
                $decryptionError = true;
                $karyawans = Karyawan::with('jabatan', 'user')->get();
                session()->flash('error', 'Kunci dekripsi tidak valid atau data rusak. Data ditampilkan dalam bentuk terenkripsi.');
                return redirect()->back();
            }
        } else {
            $karyawans = Karyawan::with('jabatan', 'user')->get();
        }

        return view('karyawan.decrypt', compact('karyawans', 'jabatans', 'users', 'adminKey', 'decryptionError'));
    }

    private function getDecryptedKaryawans(string $adminKey)
    {
        try {
            $decodedAdminKey = base64_decode($adminKey, true);
            if ($decodedAdminKey === false || strlen($decodedAdminKey) !== 32) {
                throw new \InvalidArgumentException('Kunci admin tidak valid atau panjang tidak sesuai.');
            }

            $adminEncrypter = new Encrypter($decodedAdminKey, config('app.cipher'));

            $karyawans = Karyawan::with('jabatan', 'user')->get();

            $karyawans->map(function ($karyawan) use ($adminEncrypter) {
                // Dekripsi nama
                try {
                    $karyawan->nama = $adminEncrypter->decryptString($karyawan->nama);
                } catch (DecryptException $e) {
                    $karyawan->nama = '[Dekripsi Gagal]';
                    Log::warning("Dekripsi nama karyawan ID {$karyawan->id} gagal: " . $e->getMessage());
                }

                // Dekripsi nik
                try {
                    $karyawan->nik = $adminEncrypter->decryptString($karyawan->nik);
                } catch (DecryptException $e) {
                    $karyawan->nik = '[Dekripsi Gagal]';
                    Log::warning("Dekripsi NIK karyawan ID {$karyawan->id} gagal: " . $e->getMessage());
                }

                // Dekripsi email (hanya jika ada nilainya)
                if ($karyawan->email) {
                    try {
                        $karyawan->email = $adminEncrypter->decryptString($karyawan->email);
                    } catch (DecryptException $e) {
                        $karyawan->email = '[Dekripsi Gagal]';
                        Log::warning("Dekripsi email karyawan ID {$karyawan->id} gagal: " . $e->getMessage());
                    }
                }

                // Dekripsi no_hp (hanya jika ada nilainya)
                if ($karyawan->no_hp) {
                    try {
                        $karyawan->no_hp = $adminEncrypter->decryptString($karyawan->no_hp);
                    } catch (DecryptException $e) {
                        $karyawan->no_hp = '[Dekripsi Gagal]';
                        Log::warning("Dekripsi no_hp karyawan ID {$karyawan->id} gagal: " . $e->getMessage());
                    }
                }

                // Dekripsi alamat (hanya jika ada nilainya)
                if ($karyawan->alamat) {
                    try {
                        $karyawan->alamat = $adminEncrypter->decryptString($karyawan->alamat);
                    } catch (DecryptException $e) {
                        $karyawan->alamat = '[Dekripsi Gagal]';
                        Log::warning("Dekripsi alamat karyawan ID {$karyawan->id} gagal: " . $e->getMessage());
                    }
                }

                return $karyawan;
            });

            return $karyawans;
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
            // Hapus unique untuk NIK jika Anda mengenkripsinya dan tidak melakukan validasi unik khusus
            'nik' => 'required',
            'email' => 'nullable|email', // Hapus unique untuk email juga
            'no_hp' => 'required', // Hapus unique untuk no_hp juga
            'jabatan_id' => 'required|exists:jabatans,id',
            'user_id' => 'nullable|exists:users,id',
            'foto' => 'nullable|image|max:2048',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama karyawan harus diisi',
            'nik.required' => 'NIK harus diisi',
            // 'nik.unique' => 'NIK sudah terdaftar', // Ini tidak akan bekerja dengan enkripsi
            'email.email' => 'Format email tidak valid',
            // 'email.unique' => 'Email sudah terdaftar', // Ini tidak akan bekerja dengan enkripsi
            'no_hp.required' => 'Nomor HP harus diisi',
            // 'no_hp.unique' => 'Nomor HP sudah terdaftar', // Ini tidak akan bekerja dengan enkripsi
            'jabatan_id.required' => 'Jabatan harus dipilih',
            'jabatan_id.exists' => 'Jabatan tidak ditemukan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => bcrypt('password'), // Ganti dengan password default atau logika lain
        ]);

        $user->assignRole('karyawan'); // Pastikan role 'karyawan' sudah ada


        $data = $request->all();
        $data['user_id'] = $user->id;
        // ---- ENKRIPSI DATA SEBELUM DISIMPAN ----
        try {
            $data['nik'] = Crypt::encryptString($request->nik);
            if ($request->filled('email')) {
                $data['email'] = Crypt::encryptString($request->email);
            } else {
                $data['email'] = null; // Pastikan null jika input kosong
            }
            if ($request->filled('no_hp')) {
                $data['no_hp'] = Crypt::encryptString($request->no_hp);
            } else {
                $data['no_hp'] = null; // Pastikan null jika input kosong
            }
            if ($request->filled('alamat')) {
                $data['alamat'] = Crypt::encryptString($request->alamat);
            } else {
                $data['alamat'] = null; // Pastikan null jika input kosong
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengenkripsi data: ' . $e->getMessage());
        }
        // ----------------------------------------

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_karyawan', 'public');
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show(Karyawan $karyawan)
    {
        $karyawan->load('jabatan', 'user');
        // Saat show, Anda mungkin ingin langsung mendekripsi untuk tampilan detail
        try {
            $karyawan->nik_plain = Crypt::decryptString($karyawan->nik);
            $karyawan->email_plain = $karyawan->email ? Crypt::decryptString($karyawan->email) : null;
            $karyawan->no_hp_plain = $karyawan->no_hp ? Crypt::decryptString($karyawan->no_hp) : null;
            $karyawan->alamat_plain = $karyawan->alamat ? Crypt::decryptString($karyawan->alamat) : null;
        } catch (DecryptException $e) {
            $karyawan->nik_plain = '[Error Dekripsi NIK]';
            $karyawan->email_plain = '[Error Dekripsi Email]';
            $karyawan->no_hp_plain = '[Error Dekripsi No. HP]';
            $karyawan->alamat_plain = '[Error Dekripsi Alamat]';
            \Log::error('Dekripsi data karyawan gagal di halaman show untuk ID: ' . $karyawan->id . '. Error: ' . $e->getMessage());
        }
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(Karyawan $karyawan)
    {
        $karyawan->load('jabatan', 'user');
        $jabatans = Jabatan::all();
        $users = User::all();

        // ---- DEKRIPSI DATA SAAT EDIT UNTUK DIISI KEMBALI DI FORM ----
        try {
            $karyawan->nik = Crypt::decryptString($karyawan->nik);
            $karyawan->email = $karyawan->email ? Crypt::decryptString($karyawan->email) : null;
            $karyawan->no_hp = $karyawan->no_hp ? Crypt::decryptString($karyawan->no_hp) : null;
            $karyawan->alamat = $karyawan->alamat ? Crypt::decryptString($karyawan->alamat) : null;
        } catch (DecryptException $e) {
            return redirect()->back()->with('error', 'Gagal mendekripsi data karyawan untuk edit. Data mungkin rusak.');
        }
        // -----------------------------------------------------------

        return view('karyawan.edit', compact('karyawan', 'jabatans', 'users'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nama' => 'required',
            // Hapus unique untuk NIK jika Anda mengenkripsinya dan tidak melakukan validasi unik khusus
            'nik' => 'required',
            'email' => 'nullable|email', // Hapus unique untuk email juga
            'no_hp' => 'required', // Hapus unique untuk no_hp juga
            'jabatan_id' => 'required|exists:jabatans,id',
            'user_id' => 'nullable|exists:users,id',
            'foto' => 'nullable|image|max:2048',
            'alamat' => 'nullable|string',
        ], [
            'nama.required' => 'Nama karyawan harus diisi',
            'nik.required' => 'NIK harus diisi',
            // 'nik.unique' => 'NIK sudah terdaftar', // Ini tidak akan bekerja dengan enkripsi
            'email.email' => 'Format email tidak valid',
            // 'email.unique' => 'Email sudah terdaftar', // Ini tidak akan bekerja dengan enkripsi
            'no_hp.required' => 'Nomor HP harus diisi',
            // 'no_hp.unique' => 'Nomor HP sudah terdaftar', // Ini tidak akan bekerja dengan enkripsi
            'jabatan_id.required' => 'Jabatan harus dipilih',
            'jabatan_id.exists' => 'Jabatan tidak ditemukan',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $data = $request->all();

        // ---- ENKRIPSI DATA SEBELUM DIUPDATE ----
        try {
            $data['nik'] = Crypt::encryptString($request->nik);
            if ($request->filled('email')) {
                $data['email'] = Crypt::encryptString($request->email);
            } else {
                $data['email'] = null;
            }
            if ($request->filled('no_hp')) {
                $data['no_hp'] = Crypt::encryptString($request->no_hp);
            } else {
                $data['no_hp'] = null;
            }
            if ($request->filled('alamat')) {
                $data['alamat'] = Crypt::encryptString($request->alamat);
            } else {
                $data['alamat'] = null;
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengenkripsi data: ' . $e->getMessage());
        }
        // ----------------------------------------

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

    // Ambil objek user yang sedang login
    public function riwayatGaji()
    {
        $loggedInUser = Auth::user();
        // Pastikan user sudah login
        if (!$loggedInUser) {
            // Tangani kasus user belum login, mungkin redirect ke halaman login
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat riwayat gaji.');
        }

        // Jika Anda ingin mencari karyawan berdasarkan user_id yang sedang login
        // Asumsi model Karyawan memiliki kolom user_id yang berelasi dengan tabel users
        $karyawan = Karyawan::with('user', 'jabatan') // Eager load relasi yang diperlukan
            ->where('user_id', $loggedInUser->id)
            ->first();

        try {
            // Dekripsi data karyawan jika diperlukan
            if ($karyawan) {
                $karyawan->nik = Crypt::decryptString($karyawan->nik);
                $karyawan->email = $karyawan->email ? Crypt::decryptString($karyawan->email) : null;
                $karyawan->no_hp = $karyawan->no_hp ? Crypt::decryptString($karyawan->no_hp) : null;
                $karyawan->alamat = $karyawan->alamat ? Crypt::decryptString($karyawan->alamat) : null;
            }
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Log::error('Dekripsi data karyawan gagal: ' . $e->getMessage());
            $karyawan->nik = '[Error Dekripsi NIK]';
            $karyawan->email = '[Error Dekripsi Email]';
            $karyawan->no_hp = '[Error Dekripsi No. HP]';
            $karyawan->alamat = '[Error Dekripsi Alamat]';
        }

        // Jika tidak ada karyawan yang terkait dengan user ini
        if (!$karyawan) {
            return redirect()->back()->with('error', 'Data karyawan Anda tidak ditemukan.');
        }

        // Contoh: Ambil semua gaji yang terkait dengan karyawan ini
        $riwayatGajiKaryawan = $karyawan->gajis()->with(['slipGaji', 'gajiPotongans.potongan', 'gajiBonuses.bonus'])->orderBy('tahun', 'desc')->orderBy('bulan', 'desc')->get();

        // Jika Anda perlu mendekripsi data gaji di sini untuk tampilan
        $riwayatGajiKaryawan->map(function ($gajiItem) {
            try {
                $gajiItem->gaji_pokok = Crypt::decryptString($gajiItem->gaji_pokok);
                $gajiItem->tunjangan = Crypt::decryptString($gajiItem->tunjangan);
                $gajiItem->total_potongan = Crypt::decryptString($gajiItem->total_potongan);
                $gajiItem->total_bonus = Crypt::decryptString($gajiItem->total_bonus);
                $gajiItem->gaji_bersih = Crypt::decryptString($gajiItem->gaji_bersih);
            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                // Log error dan set fallback
                \Log::error("Dekripsi gaji ID {$gajiItem->id} di riwayatGaji gagal: " . $e->getMessage());
                $gajiItem->gaji_pokok = '[Error]';
                $gajiItem->tunjangan = '[Error]';
                $gajiItem->total_potongan = '[Error]';
                $gajiItem->total_bonus = '[Error]';
                $gajiItem->gaji_bersih = '[Error]';
            }
            return $gajiItem;
        });

        // Sekarang, Anda bisa mengirimkan $karyawan (objek karyawan yang login)
        // dan $riwayatGajiKaryawan ke view
        return view('karyawan.riwayat_gaji', compact('karyawan', 'riwayatGajiKaryawan'));
    }
}