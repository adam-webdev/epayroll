<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\HariLibur;

class SyncHariLibur extends Command
{
    protected $signature = 'sync:harilibur {tahun}';
    protected $description = 'Sync data hari libur nasional dari API dan simpan ke database';

    public function handle()
    {
        $tahun = $this->argument('tahun');
        $url = "https://api-harilibur.vercel.app/api?year={$tahun}";

        $this->info("Mengambil data libur tahun {$tahun}...");
        $response = Http::get($url);

        if (!$response->ok()) {
            $this->error("Gagal mengambil data dari API");
            return 1;
        }

        $liburs = collect($response->json())
            ->filter(fn($libur) => $libur['is_national_holiday']) // hanya nasional
            ->map(function ($item) use ($tahun) {
                return [
                    'tanggal' => $item['holiday_date'],
                    'nama' => $item['holiday_name'],
                    'is_nasional' => $item['is_national_holiday'],
                    'tahun' => $tahun,
                ];
            });

        foreach ($liburs as $data) {
            HariLibur::updateOrCreate(
                ['tanggal' => $data['tanggal']],
                $data
            );
        }

        $this->info("Berhasil menyimpan " . $liburs->count() . " data libur tahun {$tahun}.");
        return 0;
    }
}