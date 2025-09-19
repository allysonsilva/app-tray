<?php

declare(strict_types=1);

namespace Shared\Providers\Concerns;

use Illuminate\Console\Scheduling\Schedule;

trait ConfigureScheduler
{
    protected function bootScheduler(): void
    {
        $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
            $this->configureScheduler($schedule);
        });
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    protected function configureScheduler(Schedule $schedule): void
    {
        // Pode ser sobrescrito nos domínios
    }
}
