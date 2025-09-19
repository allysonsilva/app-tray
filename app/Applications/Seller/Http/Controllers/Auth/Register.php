<?php

declare(strict_types=1);

namespace App\Applications\Seller\Http\Controllers\Auth;

use App\Applications\Seller\Http\Requests\Auth\RegisterRequest;
use App\Applications\Seller\Http\Resources\SellerResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Seller\Models\Seller;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

final class Register
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        /** @var Seller $seller */
        $seller = Seller::create($validated);

        event(new Registered($seller));

        return SellerResource::make($seller)
            ->response()
            ->setStatusCode(HttpResponse::HTTP_CREATED);
    }
}
