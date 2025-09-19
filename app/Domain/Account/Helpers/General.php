<?php

declare(strict_types=1);

use Account\Models\Seller;

if (! function_exists('seller')) {
    function seller(): Seller
    {
        return auth('seller')->user();
    }
}

if (! function_exists('to_money')) {
    /**
     * @SuppressWarnings(PHPMD)
     */
    function to_money(float|int $amount): string
    {
        $amountInCents = floatval(bcdiv((string) $amount, '100', 2));

        $currency = new NumberFormatter('pt-BR', NumberFormatter::CURRENCY);
        $currency->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, 2);
        $currency->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);

        // Replace decoded Non-breakable space (nbsp)
        // @see https://stackoverflow.com/questions/40724543/how-to-replace-decoded-non-breakable-space-nbsp
        return preg_replace('/\xc2\xa0/', ' ', $currency->format($amountInCents));
    }
}
