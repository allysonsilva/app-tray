<?php

declare(strict_types=1);

namespace App\Applications\Seller\Providers;

use Illuminate\Support\AggregateServiceProvider;

class SellerApplicationServiceProvider extends AggregateServiceProvider
{
    /**
     * @var array<class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected $providers = [
        RouteServiceProvider::class,
    ];
}
