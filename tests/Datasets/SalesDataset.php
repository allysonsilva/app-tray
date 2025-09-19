<?php

declare(strict_types=1);

namespace Tests\Datasets;

dataset('sales:store', dataset: [
    [
        [
            'amount' => 100_00,
            'sale_at' => now()->subDay()->toDateString(),
        ],
    ],
]);
