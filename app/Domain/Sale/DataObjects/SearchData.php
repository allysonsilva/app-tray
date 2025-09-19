<?php

declare(strict_types=1);

namespace Sale\DataObjects;

use Shared\Data\BaseDataResource;
use Illuminate\Contracts\Support\Arrayable;
use Shared\Enums\SortDirection;
use Shared\Rules\Comparable\ComparableData;

/**
 * @SuppressWarnings(PHPMD.ExcessiveParameterList)
 */
class SearchData extends BaseDataResource implements Arrayable
{
    public function __construct(
        public ?SortDirection $orderBy,
        public ?int $perPage,
        public ?ComparableData $amount,
        public ?ComparableData $commissionAmount,
        public ?ComparableData $saleAt,
    ) {
        $this->orderBy = $this->orderBy ?: SortDirection::DESC;
    }
}
