<?php

declare(strict_types=1);

namespace Account\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class SellerAuthenticatableScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth('seller')->check()) {
            $builder->where($builder->qualifyColumn('seller_id'), auth('seller')->id());
        }
    }
}
