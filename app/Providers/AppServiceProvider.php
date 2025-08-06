<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

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
        if (
            config('app.env') === 'production' ||
            str_contains(request()->getHost(), 'ngrok-free.app') // <- deteksi ngrok
        ) {
            URL::forceScheme('https');
        }

        // Set locale Laravel
        App::setLocale('id');

        // Set locale untuk Carbon
        Carbon::setLocale('id');
    }
}
