<?php

declare(strict_types=1);

namespace Sale\DataObjects;

use Carbon\Carbon;
use Shared\Data\BaseDataResource;

class DailySalesSummaryData extends BaseDataResource
{
    public function __construct(
        public Carbon $date,
        public int $totalSales,
        public int $totalAmount,
        public int $totalCommission,
    ) {
    }
}
