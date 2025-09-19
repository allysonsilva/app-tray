<?php

declare(strict_types=1);

use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\getJson;

beforeEach(function () {
    $this->httpUri = '/api/v1/seller/sales';
});

describe('sales:list', function () {
    it('sales:list - should be authenticated', function () {
        getJson($this->httpUri)
            ->assertUnauthorized()
            ->assertJsonFragment(['message' => 'Unauthenticated.']);
    });

    it('sales:list - successfully', function () {
        Sanctum::actingAs($this->sellerAuth(), ['seller'], 'seller');

        $response = getJson(url()->query($this->httpUri, ['per_page' => 10]));

        $response->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'code',
                        'amount',
                        'commission' => ['rate', 'amount'],
                        'sale_at',
                    ],
                ],
            ]);
    });
});
