<?php

declare(strict_types=1);

namespace App\Applications\Admin\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware(['api', 'throttle:global'])
                ->name('api.v1.admin.')
                ->prefix('api/v1/admin')
                ->group(__DIR__ . '/../Routes/Api.php');
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('global', fn (Request $request) => $request->user()
                ? Limit::perMinute(180)->by($request->user()->id)
                : Limit::perMinute(120)->by($request->ip()));

        RateLimiter::for('auth', fn (Request $request) => $request->user()
                ? Limit::perMinute(60)->by($request->user()->id)
                : Limit::perMinute(20)->by($request->ip()));
    }
}
