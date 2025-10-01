<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        config(['app.timezone' => 'Asia/Jakarta']);
        date_default_timezone_set(config('app.timezone'));
        Carbon::setLocale('id');

        $host = request()->getHost();
        $schemeHost = request()->getSchemeAndHttpHost();

        if (str_contains($host, 'ngrok-free.app')) {
            // ✅ Kalau pakai ngrok
            config(['app.url' => $schemeHost]);
            URL::forceRootUrl($schemeHost);
            URL::forceScheme('https');
        } elseif (config('app.env') === 'production') {
            // ✅ Kalau production
            URL::forceScheme('https');
        }

        App::setLocale('id');
    }
}
