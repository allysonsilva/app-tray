<?php

declare(strict_types=1);

use Laravel\Sanctum\Sanctum;
use Sale\Models\Sale;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $this->httpUri = '/api/v1/seller/sales';
});

describe('sales:store', function () {
    it('sales:store - should be authenticated', function () {
        postJson($this->httpUri)
            ->assertUnauthorized()
            ->assertJsonFragment(['message' => 'Unauthenticated.']);
    });

    it('sales:store - should response with error - 422', function () {
        Sanctum::actingAs($this->sellerAuth(), ['seller'], 'seller');

        postJson($this->httpUri)
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'amount',
                'sale_at',
            ]);
    });

    it('sales:store - successfully', function (array $payload) {
        Sanctum::actingAs($seller = $this->sellerAuth(), ['seller'], 'seller');

        $response = postJson($this->httpUri, $payload);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'code',
                    'amount',
                    'commission' => ['rate', 'amount'],
                    'sale_at',
                ]
            ]);

        assertDatabaseHas(Sale::class, [
            'code' => $response->json('data.code'),
            'seller_id' => $seller->getKey(),
            'amount' => $payload['amount'],
            'commission_rate' => config('app.seller.commission_percentage'),
            'commission_amount' => proportional_amount(
                $payload['amount'],
                config('app.seller.commission_percentage')
            ),
            'sale_at' => $payload['sale_at'],
        ]);

    })->with('sales:store');
});
