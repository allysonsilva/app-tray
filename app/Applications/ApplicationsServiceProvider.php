<?php

declare(strict_types=1);

namespace App\Applications;

use Illuminate\Support\AggregateServiceProvider;
use App\Applications\Admin\Providers\AdminApplicationServiceProvider;
use App\Applications\Seller\Providers\SellerApplicationServiceProvider;

final class ApplicationsServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array<class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected $providers = [
        AdminApplicationServiceProvider::class,
        SellerApplicationServiceProvider::class,
    ];
}
