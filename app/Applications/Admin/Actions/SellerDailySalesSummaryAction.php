<?php

declare(strict_types=1);

namespace App\Applications\Admin\Actions;

use App\Applications\Admin\Notifications\SellerDailySalesReportNotification;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Sale\DataObjects\SellerDailySalesSummaryData;
use Sale\Models\SalesSummary;
use Sale\Queries\SellerDailySalesSummaryQuery;
use Shared\Contracts\ActionInterface;
use Throwable;

readonly class SellerDailySalesSummaryAction implements ActionInterface
{
    public function __construct(
        private SellerDailySalesSummaryQuery $query,
    ) {
    }

    public function handle(Carbon $date, ?int $sellerId = null): void
    {
        $data = $this->query->handle($date, $sellerId);

        /** @var SellerDailySalesSummaryData $summaryData */
        foreach (Arr::wrap($data) as $summaryData) {
            // Dessa forma os eventos do eloquent são lançados
            // Inserindo via bulks não são!
            try {
                SalesSummary::query()->updateOrCreate(
                    ['created_at' => $date->toDateString()],
                    [
                        'seller_id' => $summaryData->seller->getKey(),
                        'total_sales_count' => $summaryData->totalSales,
                        'total_sales_amount' => $summaryData->totalAmount,
                        'total_commission_amount' => $summaryData->totalCommission,
                    ]
                );
            } catch (Throwable $th) {
                report($th);
            }

            $summaryData->seller->notify(new SellerDailySalesReportNotification($summaryData, $date));
        }
    }
}
