<?php

declare(strict_types=1);

namespace Shared\Providers;

use Illuminate\Support\AggregateServiceProvider;
use Shared\Providers\Concerns\ComponentPath;
use Shared\Providers\Concerns\ConfigureScheduler;
use Shared\Providers\Concerns\LoadCommands;

abstract class DomainServiceProvider extends AggregateServiceProvider
{
    use ComponentPath;
    use LoadCommands;
    use ConfigureScheduler;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->loadCommands();
        $this->bootScheduler();

        if (file_exists($migrationsPath = $this->componentPath('Database' . DIRECTORY_SEPARATOR . 'Migrations'))) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }
}
