<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\Controllers;

use App\Applications\Admin\Http\QueryFilters\ByIdentifier;
use App\Applications\Admin\Http\QueryFilters\BySeller;
use App\Applications\Admin\Http\QueryFilters\CursorPaginate;
use App\Applications\Admin\Http\Resources\SellerResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Pipeline;
use Seller\Models\Seller;

final class ListSellerController
{
    public function __invoke(): AnonymousResourceCollection
    {
        $sellers = Pipeline::send(Seller::query())
            ->through([
                ByIdentifier::class,
                BySeller::class,
                CursorPaginate::class,
            ])
            ->thenReturn();

        return SellerResource::collection($sellers);
    }
}
