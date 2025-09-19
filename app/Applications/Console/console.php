<?php

declare(strict_types=1);

use App\Applications\Admin\Actions\SellerDailySalesSummaryAction;
use App\Applications\Admin\Jobs\DailySalesSummaryJob;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;
use Spatie\Health\Commands\DispatchQueueCheckJobsCommand;
use Spatie\Health\Commands\ScheduleCheckHeartbeatCommand;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Models\HealthCheckResultHistoryItem;

// 7 dias de retenção para o Telescope
Schedule::command('telescope:prune --hours=168')->daily();

Schedule::command('sanctum:prune-expired --hours=24')->daily();

Schedule::command(DispatchQueueCheckJobsCommand::class)->everyMinute()->withoutOverlapping(10);

Schedule::command(ScheduleCheckHeartbeatCommand::class)->everyMinute()->withoutOverlapping(10);

Schedule::command(RunHealthChecksCommand::class)->everyMinute();

Schedule::command('model:prune', ['--model' => [HealthCheckResultHistoryItem::class]])->daily();

// Vai executar as 02:00 da manhã, mas recuperar
// todas as vendas do dia anterior - yesterday
Schedule::job(new DailySalesSummaryJob(Carbon::yesterday()))
    ->onOneServer()
    ->dailyAt('02:00');

Schedule::call(function () {
    app(SellerDailySalesSummaryAction::class)->handle(today());
})->name('seller-daily-sales-summary')->onOneServer()->dailyAt('23:00');
