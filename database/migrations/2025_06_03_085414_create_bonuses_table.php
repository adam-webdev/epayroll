<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('bonuses', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bonus')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('Aktif');
            $table->enum('tipe', ['persentase', 'nominal'])->default('nominal');
            $table->string('nilai')->default('0'); // misal: 1 untuk 1% atau 50000
            $table->boolean('otomatis')->default(false); // Tambahan
            $table->timestamps();
        });
        Schema::create('gaji_bonus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gaji_id')->constrained()->onDelete('cascade');
            $table->foreignId('bonus_id')->constrained()->onDelete('cascade');
            $table->string('jumlah_bonus')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonuses');
        Schema::dropIfExists('gaji_bonus');
    }
};