<?php

declare(strict_types=1);

namespace Sale\DataObjects;

use Carbon\Carbon;
use Sale\Models\Seller;
use Shared\Data\BaseDataResource;

/**
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class SellerDailySalesSummaryData extends BaseDataResource
{
    public function __construct(
        public Seller $seller,
        public Carbon $date,
        public int $totalSales,
        public int $totalAmount,
        public int $totalCommission,
    ) {
    }
}
