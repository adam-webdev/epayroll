<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {

        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('Aktif');
            $table->string('tunjangan_jabatan')->default('0')->nullable();
            $table->string('gaji_pokok')->default('0');
            $table->timestamps();
        });

        schema::create('potongans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_potongan')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('Aktif');
            $table->enum('tipe', ['persentase', 'nominal'])->default('nominal');
            $table->string('nilai')->default('0'); // misal: 1 untuk 1% atau 50000
            $table->boolean('otomatis')->default(false); // Tambahan
            $table->timestamps();
        });


        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('no_hp')->unique();
            $table->date('tanggal_masuk')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('jenis_kelamin')->default('Laki-laki');
            $table->foreignId('jabatan_id')->constrained('jabatans')->onDelete('cascade');
            $table->string('status_karyawan')->default('Aktif');
            $table->string('status_kawin')->default('Belum Kawin');
            $table->string('foto')->nullable();
            $table->text('alamat')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Assuming you have a user_id to link to the User model
            $table->timestamps();
        });

        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('status_kehadiran')->default('Hadir');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained()->onDelete('cascade');
            $table->string('bulan'); // Contoh: 'Mei'
            $table->year('tahun');   // Contoh: 2025
            $table->string('gaji_pokok')->default('0');
            $table->string('tunjangan')->default('0')->nullable();
            $table->string('total_potongan')->default('0')->nullable();
            $table->string('gaji_bersih')->default('0');
            $table->string('status')->default('Draft'); // Draft / Final / Dibayar
            $table->date('tanggal_input')->nullable();
            $table->timestamps();
        });

        Schema::create('slip_gajis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gaji_id')->constrained('gajis')->onDelete('cascade');
            $table->string('nomor_slip')->unique();
            $table->string('status')->default('Belum Dikirim'); // atau Dikirim, Dilihat, etc.
            $table->timestamps();
        });

        Schema::create('gaji_potongans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gaji_id')->constrained()->onDelete('cascade');
            $table->foreignId('potongan_id')->constrained()->onDelete('cascade');
            $table->string('jumlah_potongan')->default('0');
            $table->timestamps();
        });
    }
    //


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};