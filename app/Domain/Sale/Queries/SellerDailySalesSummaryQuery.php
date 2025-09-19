<?php

declare(strict_types=1);

namespace Sale\Queries;

use Carbon\Carbon;
use Sale\Models\Sale;
use Shared\Contracts\QueryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\LazyCollection;
use Sale\DataObjects\SellerDailySalesSummaryData;

readonly class SellerDailySalesSummaryQuery implements QueryInterface
{
    public function __construct(
        private Sale $sale,
    ) {
    }

    public function handle(Carbon $date, ?int $sellerId = null): SellerDailySalesSummaryData|LazyCollection
    {
        /** @var Builder<Sale> $query */
        $query = $this->sale->where('sale_at', $date->toDateString())
            ->selectRaw('
                        seller_id,
                        COUNT(*) as total_sales,
                        SUM(amount) as total_amount,
                        SUM(commission_amount) as total_commission
                    ')
            ->with('seller')
            ->groupBy('seller_id');

        if (! empty($sellerId)) {
            /** @var Sale $saleData */
            $saleData = $query->where('seller_id', $sellerId)->first();

            return $this->summaryData($saleData, $date);
        }

        return $query->cursor()->map(
            fn (Sale $sale) => $this->summaryData($sale, $date)
        );
    }

    private function summaryData(Sale $sale, Carbon $date): SellerDailySalesSummaryData
    {
        return SellerDailySalesSummaryData::from([
            'seller' => $sale->seller,
            'date' => $date,
            'totalSales' => $sale->total_sales,
            'totalAmount' => $sale->total_amount,
            'totalCommission' => $sale->total_commission,
        ]);
    }
}
