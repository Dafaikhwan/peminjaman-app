<?php

namespace App\Providers;
use App\Observers\LogObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Models\Alat;
use App\Models\Ruangan;
use App\Models\Peminjaman;
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
    Alat::observe(LogObserver::class);
    Ruangan::observe(LogObserver::class);
    Peminjaman::observe(LogObserver::class);
}

}
