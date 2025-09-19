<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class BySeller
{
    /**
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function handle(Builder $builder, Closure $next)
    {
        // Pode ser o nome, id ou email do seller
        $seller = trim((string) request()->input('seller'));

        if (empty($seller)) {
            return $next($builder);
        }

        if (filter_var($seller, FILTER_VALIDATE_INT)) {
            $builder->whereKey($seller);
        } elseif (filter_var($seller, FILTER_VALIDATE_EMAIL)) {
            $builder->where($builder->qualifyColumn('email'), $seller);
        } else {
            $builder->whereLike($builder->qualifyColumn('name'), "%{$seller}%");
        }

        return $next($builder);
    }
}
