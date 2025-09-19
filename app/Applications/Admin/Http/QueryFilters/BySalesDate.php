<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class BySalesDate
{
    public function handle(Builder $builder, Closure $next)
    {
        $startDate = trim((string) request()->input('sale_start_at'));
        $endDate = trim((string) request()->input('sale_end_at'));

        $builder->where(function (Builder $query) use ($startDate, $endDate) {
            if (! empty($startDate)) {
                $query->where($query->qualifyColumn('sale_at'), '>=', $startDate);
            }

            if (! empty($endDate)) {
                $query->where($query->qualifyColumn('sale_at'), '<=', $endDate);
            }
        });

        return $next($builder);
    }
}
