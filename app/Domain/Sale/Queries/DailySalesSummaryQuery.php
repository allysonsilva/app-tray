<?php

declare(strict_types=1);

namespace Sale\Queries;

use Carbon\Carbon;
use Shared\Contracts\QueryInterface;
use Sale\DataObjects\DailySalesSummaryData;
use Sale\DataObjects\SellerDailySalesSummaryData;

readonly class DailySalesSummaryQuery implements QueryInterface
{
    public function __construct(
        private SellerDailySalesSummaryQuery $query,
    ) {
    }

    public function handle(Carbon $date): DailySalesSummaryData
    {
        $summary = $this->query->handle($date)->reduce(function (array $carry, SellerDailySalesSummaryData $data) {
            $carry['totalSales']++;
            $carry['totalAmount'] += $data->totalAmount;
            $carry['totalCommission'] += $data->totalCommission;

            return $carry;
        }, [
            'totalSales' => 0,
            'totalAmount' => 0,
            'totalCommission' => 0,
        ]);

        return DailySalesSummaryData::from(array_merge(compact('date'), $summary));
    }
}
