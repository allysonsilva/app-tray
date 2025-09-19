<?php

declare(strict_types=1);

namespace App\Applications\Seller\Http\Controllers\Auth;

use Account\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class Logout
{
    /**
     * Destroy an authenticated session.
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var Seller $seller */
        $seller = $request->user();

        $seller->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
