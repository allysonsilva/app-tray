<?php

declare(strict_types=1);

namespace App\Applications\Seller\Providers;

use Illuminate\Support\Facades\Route;
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
        $this->routes(function () {
            Route::middleware(['api', 'throttle:global'])
                ->name('api.v1.seller.')
                ->prefix('api/v1/seller')
                ->group(__DIR__ . '/../Routes/Api.php');
        });
    }
}
