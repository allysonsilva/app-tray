<?php

declare(strict_types=1);

use App\Applications\Admin\Http\Controllers\HealthCheckController;
use App\Applications\Admin\Http\Controllers\ListSaleController;
use App\Applications\Admin\Http\Controllers\ListSellerController;
use App\Applications\Admin\Http\Controllers\ResendCommissionEmailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('hi', fn () => 'Hi Admin 👋');

Route::middleware(['throttle:api', 'auth:admin', 'abilities:admin'])
    ->group(function () {
        // /healthz?view&fresh
        // /healthz?exception&fresh
        // /healthz?json&fresh
        Route::get('healthz', HealthCheckController::class)->name('health-check');

        Route::get('sales', ListSaleController::class)->name('get.sales');
        Route::get('sellers', ListSellerController::class)->name('get.sellers');

        Route::post('sellers/{seller}/resend-commission-email', ResendCommissionEmailController::class)
            ->name('resend-commission-email.sellers');
    });
