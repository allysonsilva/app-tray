<?php

declare(strict_types=1);

namespace Account\Database\Factories;

use Account\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Account\Models\Admin>
 */
class AdminFactory extends Factory
{
    protected $model = Admin::class;

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
            'name' => 'João Admin',
            'email' => fake()->unique()->safeEmail(),
            'is_notifiable' => false,
            'password' => static::$password ??= app('hash')->make('password'),
        ];
    }

    public function withNotifiable(): self
    {
        return $this->state(fn (array $attributes) => [
            'is_notifiable' => true,
        ]);
    }
}
