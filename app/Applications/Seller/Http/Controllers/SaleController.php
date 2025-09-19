<?php

declare(strict_types=1);

namespace App\Applications\Seller\Http\Controllers;

use App\Applications\Seller\Http\Requests\IndexSaleRequest;
use App\Applications\Seller\Http\Requests\StoreSalleRequest;
use App\Applications\Seller\Http\Resources\SaleResource;
use Illuminate\Http\JsonResponse;
use Sale\DataObjects\SaleStoreData;
use Sale\Models\Sale;
use Sale\Queries\ListSearchableSalesQuery;
use Shared\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class SaleController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexSaleRequest $request, ListSearchableSalesQuery $query)
    {
        return SaleResource::collection($query->paginate($request()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalleRequest $request): JsonResponse
    {
        $data = SaleStoreData::from($request->validated());

        // Para garantir a integridade em caso de falhas na conexão com o banco de dados
        // podemos tentar a operação de criação algumas vezes com um delay entre elas
        // isso é especialmente útil em ambientes com alta latência ou instabilidade
        // a função retry é uma abstração para facilitar essa lógica
        $newSale = retry(
            [10, 20],
            fn () => Sale::create($data->toArray())
        );

        return (new SaleResource($newSale))
            ->response()
            ->setStatusCode(HttpResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale): SaleResource
    {
        return new SaleResource($sale);
    }
}
