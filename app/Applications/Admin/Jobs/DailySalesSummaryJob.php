<?php

declare(strict_types=1);

namespace App\Applications\Admin\Jobs;

use Account\Models\Admin;
use App\Applications\Admin\Notifications\DailySalesReportNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Sale\Queries\DailySalesSummaryQuery;

class DailySalesSummaryJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Carbon $date
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(DailySalesSummaryQuery $query): void
    {
        /** @var \Illuminate\Database\Eloquent\Collection<Admin> $adminsToNotification */
        $adminsToNotification = Admin::query()->notifiable()->get(); // @phpstan-ignore-line

        $summaryData = $query->handle($this->date);

        /** @var Admin $adminToNotification */
        foreach ($adminsToNotification as $adminToNotification) {
            $adminToNotification->notify(new DailySalesReportNotification($summaryData, $this->date));
        }
    }
}
