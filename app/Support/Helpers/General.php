<?php

declare(strict_types=1);

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

if (! function_exists('proportional_amount')) {
    /**
     * @SuppressWarnings(PHPMD)
     */
    function proportional_amount(float|int|string $amount, float $rate): int
    {
        return intval(round(
            floatval(bcmul((string) $amount, bcdiv((string) $rate, '100', 3), 3))
        ));
    }
}
