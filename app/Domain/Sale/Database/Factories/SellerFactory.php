<?php

declare(strict_types=1);

namespace Sale\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Sale\Models\Sale;
use Sale\Models\Seller;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Sale\Models\Seller>
 */
class SellerFactory extends Factory
{
    protected $model = Seller::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'João da Silva Seller',
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= app('hash')->make('password'),
            'commission_percentage' => fake()->randomFloat(3, 1.000, 10.000),
        ];
    }

    public function fakeName(): self
    {
        return $this->state(fn (array $attributes) => [
            'name' => fake()->name(),
        ]);
    }

    public function defaultCommission(): self
    {
        return $this->state(fn (array $attributes) => [
            'commission_percentage' => config('app.seller.commission_percentage'),
        ]);
    }

    public function withSales(int $subDays = 10, int $count = 10): static
    {
        return $this->afterCreating(function (Seller $seller) use ($subDays, $count) {
            foreach (range(1, $subDays) as $subDay) {
                Sale::factory()
                    ->count($count)
                    ->for($seller)
                    ->create([
                        'amount' => 100_00,
                        'commission_rate' => $seller->commission_percentage,
                        'commission_amount' => proportional_amount(100_00, $seller->commission_percentage),
                        'sale_at' => now()->subDays($subDay),
                    ]);
            }
        });
    }
}
