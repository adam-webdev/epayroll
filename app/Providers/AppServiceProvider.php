<?php

namespace App\Providers;

use App\Models\TransaksiStok;
use App\Observers\TransaksiStokObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Lang;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Carbon\Carbon::setLocale('id');
        // Mendaftarkan observer untuk model TransaksiStok
        // TransaksiStok::observe(TransaksiStokObserver::class);
        Lang::addNamespace('custom', base_path('lang'));
    }
}