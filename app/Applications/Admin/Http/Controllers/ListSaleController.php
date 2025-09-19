<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\Controllers;

use App\Applications\Admin\Http\QueryFilters\ByIdentifier;
use App\Applications\Admin\Http\QueryFilters\BySalesDate;
use App\Applications\Admin\Http\QueryFilters\CursorPaginate;
use App\Applications\Admin\Http\QueryFilters\SaleBySeller;
use App\Applications\Admin\Http\Resources\SaleResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Pipeline;
use Sale\Models\Sale;

final class ListSaleController
{
    public function __invoke(): AnonymousResourceCollection
    {
        $sales = Pipeline::send(Sale::query())
            ->through([
                ByIdentifier::class,
                SaleBySeller::class,
                BySalesDate::class,
                CursorPaginate::class,
            ])
            ->thenReturn();

        return SaleResource::collection($sales);
    }
}
