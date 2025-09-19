<?php

declare(strict_types=1);

namespace Tests;

use Account\Models\Seller;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ThrottleRequestsWithRedis;
use Illuminate\Auth\Middleware\Authorize as AuthorizeMiddleware;
use Tests\Support\CustomMacros;

abstract class TestCase extends BaseTestCase
{
    use WithFaker;
    use CustomMacros;

    public const EMAIL_SELLER_0 = 'seller0@example.org';
    public const EMAIL_ADMIN_0 = 'admin0@example.org';

    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
        $uses = parent::setUpTraits();

        if (isset($uses[CustomMacros::class])) {
            $this->testResponseMacros();
            $this->collectionMacros();
            $this->scheduleMacros();
            $this->eventMacros();
        }

        return $uses;
    }

    protected function sellerAuth(): Seller
    {
        return Seller::where('email', static::EMAIL_SELLER_0)->firstOrFail();
    }

    protected function withoutMiddlewareDependencies(): static
    {
        $this->withoutMiddleware([
            AuthorizeMiddleware::class,
            ThrottleRequests::class,
            ThrottleRequestsWithRedis::class
        ]);

        return $this;
    }
}
