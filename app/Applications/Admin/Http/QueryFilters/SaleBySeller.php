<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class SaleBySeller
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

        $builder->join('sellers', 'sellers.id', 'sales.seller_id')
            ->tap(function (Builder $query) use ($seller) {
                if (filter_var($seller, FILTER_VALIDATE_INT)) {
                    $query->where('sellers.id', $seller);
                } elseif (filter_var($seller, FILTER_VALIDATE_EMAIL)) {
                    $query->where('sellers.email', $seller);
                } else {
                    $query->whereLike('sellers.name', "%{$seller}%");
                }
            });

        return $next($builder);
    }
}
