<?php

declare(strict_types=1);

namespace Tests\Support;

use Account\Models\Admin;
use Tests\TestCase;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Sale\Models\Seller;

// php artisan db:seed --class="\\Tests\\Support\\PopulateDBSeeder" --env=testing
class PopulateDBSeeder extends Seeder
{
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Seller::factory()
            ->defaultCommission()
            ->withSales()
            ->create(['email' => TestCase::EMAIL_SELLER_0]);

        // Outros sellers para uso dos resultados de filtro na listagem
        Seller::factory()->count(5)->withSales(5, 5)->fakeName()->create();

        Admin::factory()->create(['email' => TestCase::EMAIL_ADMIN_0]);
    }
}
