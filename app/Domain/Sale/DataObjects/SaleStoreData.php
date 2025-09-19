<?php

declare(strict_types=1);

namespace Sale\DataObjects;

use Carbon\Carbon;
use Shared\Data\BaseDataResource;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Transformers\DateTimeInterfaceTransformer;

final class SaleStoreData extends BaseDataResource
{
    #[Computed]
    public float $commissionRate;

    #[Computed]
    public int $commissionAmount;

    public function __construct(
        public int $amount,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        #[WithTransformer(DateTimeInterfaceTransformer::class, format: 'Y-m-d')]
        public Carbon $saleAt
    ) {
        $this->commissionRate = (float) seller()->commission_percentage;

        $this->commissionAmount = intval(round(
            floatval(bcmul((string) $this->amount, bcdiv((string) $this->commissionRate, '100', 3), 3))
        ));
    }
}
