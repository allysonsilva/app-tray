<?php

declare(strict_types=1);

namespace App\Support\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', fn (Request $request) => $request->user()
                ? Limit::perSecond(10)->by($request->user()->getKey())
                : Limit::perSecond(5)->by($request->ip()));
    }
}
