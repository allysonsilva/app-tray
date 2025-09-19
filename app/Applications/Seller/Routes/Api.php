<?php

declare(strict_types=1);

use App\Applications\Seller\Http\Controllers\SaleController;
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

require __DIR__ . DIRECTORY_SEPARATOR . 'Auth.php';

Route::get('hi', fn () => 'Hi Seller 👋');

Route::middleware(['throttle:api', 'auth:seller', 'abilities:seller'])
    ->group(function () {
        Route::name('me.')->group(function () {
            Route::get('me/profile', fn () => auth()->user())->name('profile');
        });

        Route::apiResource('sales', SaleController::class)
            ->except(['update', 'destroy']);
    });
