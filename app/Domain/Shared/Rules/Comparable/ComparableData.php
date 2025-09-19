<?php

declare(strict_types=1);

namespace Shared\Rules\Comparable;

use Carbon\Carbon;
use Shared\Data\BaseDataResource;
use Shared\Enums\FilterOperator;

class ComparableData extends BaseDataResource
{
    public function __construct(
        public ?FilterOperator $operator,
        public readonly Carbon|int|float $value,
    ) {
        $this->operator = $this->operator ?: FilterOperator::EQUAL;
    }

    public function operator(): string
    {
        return $this->operator->value;
    }

    public function value(): Carbon|int|float
    {
        return $this->value;
    }
}
