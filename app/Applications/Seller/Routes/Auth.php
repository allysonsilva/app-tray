<?php

declare(strict_types=1);

use App\Applications\Seller\Http\Controllers\Auth\Login;
use App\Applications\Seller\Http\Controllers\Auth\Logout;
use App\Applications\Seller\Http\Controllers\Auth\Register;
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

Route::middleware('guest:seller')->name('guest.')->group(function () {
    Route::post('login', Login::class)->name('login');
    Route::post('register', Register::class)->name('register');
});

Route::middleware('auth:seller')->group(function () {
    Route::delete('logout', Logout::class)->name('logout');
});
