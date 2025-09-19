<?php

declare(strict_types=1);

namespace Account\Models\Concerns;

use Account\Models\Scopes\SellerAuthenticatableScope;
use Shared\Eloquent\Concerns\HasCode;

trait SellerAuthenticatable
{
    use HasCode;

    /**
     * Retrieve the model for a bound value.
     *
     * @param  \Illuminate\Database\Eloquent\Model|\Illuminate\Contracts\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\Relation  $query
     * @param  mixed  $value
     * @param  string|null  $field
     *
     * @return \Illuminate\Contracts\Database\Eloquent\Builder
     */
    public function resolveRouteBindingQuery($query, $value, $field = null)
    {
        if (self::isValidCode($value)) {
            $value = $this->decodeCode($value);
        }

        return parent::resolveRouteBindingQuery($query, $value, $field);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function bootSellerAuthenticatable()
    {
        static::addGlobalScope(SellerAuthenticatableScope::class);

        static::creating(function (self $entity) {
            $entity->seller_id = auth('seller')->id() ?: $entity->seller_id;
        });
    }
}
