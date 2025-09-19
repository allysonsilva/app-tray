<?php

declare(strict_types=1);

namespace Sale\Queries;

use Closure;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Pagination\CursorPaginator;
use Sale\DataObjects\SearchData;
use Sale\Models\Sale;
use Shared\Contracts\QueryInterface;
use Shared\Eloquent\BaseEloquentBuilder;

final class ListSearchableSalesQuery implements QueryInterface
{
    private SearchData $data;

    public function __construct(protected Sale $entity)
    {
    }

    public function paginate(SearchData $data): CursorPaginator
    {
        return $this->builder($data)->cursorPaginate(perPage: $data->perPage)->withQueryString();
    }

    /**
     * @return EloquentBuilder<Sale>
     */
    public function builder(SearchData $data): EloquentBuilder
    {
        $this->data = $data;

        /** @var \Illuminate\Database\Eloquent\Builder<Sale> $builder */
        $builder = $this->entity->query();

        Pipeline::send($builder)
            ->through([
                [$this, 'pipeFilterAmount'],
                [$this, 'pipeFilterCommissionAmount'],
                [$this, 'pipeFilterSaleAt'],
            ])
            ->thenReturn();

        return $builder->orderBy('id', $data->orderBy->value);
    }

    public function pipeFilterAmount(BaseEloquentBuilder $builder, Closure $next): BaseEloquentBuilder
    {
        if (! empty($this->data->amount)) {
            $builder->where(
                'amount',
                $this->data->amount->operator(),
                $this->data->amount->value()
            );
        }

        return $next($builder);
    }

    public function pipeFilterCommissionAmount(BaseEloquentBuilder $builder, Closure $next): BaseEloquentBuilder
    {
        if (! empty($this->data->commissionAmount)) {
            $builder->where(
                'commission_amount',
                $this->data->commissionAmount->operator(),
                $this->data->commissionAmount->value()
            );
        }

        return $next($builder);
    }

    public function pipeFilterSaleAt(BaseEloquentBuilder $builder, Closure $next): BaseEloquentBuilder
    {
        if (! empty($this->data->saleAt)) {
            $builder->where(
                'sale_at',
                $this->data->saleAt->operator(),
                $this->data->saleAt->value()
            );
        }

        return $next($builder);
    }
}
