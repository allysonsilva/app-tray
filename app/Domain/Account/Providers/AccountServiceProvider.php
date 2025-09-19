<?php

declare(strict_types=1);

namespace Account\Providers;

use Account\Models\Admin;
use Account\Models\Seller;
use Illuminate\Support\Facades\Auth;
use Shared\Providers\DomainServiceProvider;

class AccountServiceProvider extends DomainServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        $this->registerAuthProviders();
        $this->registerGuards();
    }

    public function boot(): void
    {
        parent::boot();

        Auth::resolved(function ($auth) {
            /**
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
             */
            $auth->extend('admin', fn ($app, $name, array $config) => $auth->guard('sanctum', [
                'provider' => 'admins',
            ]));

            /**
             * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
             */
            $auth->extend('seller', fn ($app, $name, array $config) => $auth->guard('sanctum', [
                'provider' => 'sellers',
            ]));
        });
    }

    protected function registerAuthProviders(): void
    {
        // Auth::provider('sellers', function ($app, array $config) {
        //     return new EloquentUserProvider($app['hash'], Seller::class);
        // });

        // Provider para sellers
        config([
            'auth.providers.sellers' => [
                'driver' => 'eloquent',
                'model' => Seller::class,
            ],
        ]);

        // Provider para admins
        config([
            'auth.providers.admins' => [
                'driver' => 'eloquent',
                'model' => Admin::class,
            ],
        ]);
    }

    protected function registerGuards(): void
    {
        // Auth::extend('seller', function ($app, $name, array $config) {
        //     return Auth::guard('sanctum', [
        //         'provider' => 'sellers',
        //     ]);
        // });

        config([
            'auth.guards.seller' => [
                'driver' => 'sanctum',
                'provider' => 'sellers',
            ],
            'auth.guards.admin' => [
                'driver' => 'sanctum',
                'provider' => 'admins',
            ],
        ]);
    }
}
