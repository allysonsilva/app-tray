<?php

declare(strict_types=1);

namespace App\Applications\Admin\Providers;

use Illuminate\Support\AggregateServiceProvider;

class AdminApplicationServiceProvider extends AggregateServiceProvider
{
    /**
     * @var array<class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected $providers = [
        RouteServiceProvider::class,
    ];
}
