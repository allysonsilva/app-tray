<?php

declare(strict_types=1);

namespace Shared\Eloquent;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Scope as GlobalScope;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
class BaseModel extends EloquentModel implements AuditableContract
{
    use Auditable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'id',
    ];

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param array<int, TModel> $models
     *
     * @return \Shared\Eloquent\BaseCollection<int, TModel>
     */
    public function newCollection(array $models = []): BaseCollection
    {
        return new BaseCollection($models);
    }

    /**
     * Aplica um Query Scopes no objeto.
     *
     * @param \Illuminate\Database\Eloquent\Scope $criterion
     *
     * @return void
     */
    public function addCriteria(GlobalScope $criterion): void
    {
        static::addGlobalScope($criterion);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     */
    public function newEloquentBuilder($query): BaseEloquentBuilder
    {
        return new BaseEloquentBuilder($query);
    }
}
