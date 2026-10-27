<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::defaultView('pagination::tailwind');

        // Production selalu diakses lewat https (Cloudflare)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
