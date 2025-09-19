<?php

declare(strict_types=1);

use Account\Models\Seller;

if (! function_exists('seller')) {
    function seller(): Seller
    {
        return auth('seller')->user();
    }
}
