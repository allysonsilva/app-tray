<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class CursorPaginate
{
    public function handle(Builder $builder, Closure $next)
    {
        $perPage = trim((string) request()->input('per_page'));

        $builder->latest($builder->qualifyColumn('id'));

        return $next($builder)->cursorPaginate($perPage ?: null)->withQueryString();
    }
}
