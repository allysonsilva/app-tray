<?php

declare(strict_types=1);

namespace Shared\Enums;

use Shared\Enums\Traits\HasEnumValues;

enum SortDirection: string
{
    use HasEnumValues;

    case ASC = 'asc';
    case DESC = 'desc';
}
