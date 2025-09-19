<?php

declare(strict_types=1);

namespace Sale\Database\Factories;

use Sale\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;
use Sale\Models\Seller;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Sale\Models\Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $amount = 100_00;
        $commissionRate = fake()->randomFloat(3, 1.000, 10.000);
        $commissionAmount = proportional_amount($amount, $commissionRate);

        return [
            'seller_id' => Seller::factory(),
            'amount' => $amount,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'sale_at' => now()->subWeek(),
        ];
    }
}
