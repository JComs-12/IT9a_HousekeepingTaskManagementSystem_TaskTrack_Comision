<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register the staff layout as a Blade component
        Blade::component('layouts.staff', 'staff-layout');

        // Force HTTPS on production (e.g. Render)
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}