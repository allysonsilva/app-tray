<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

final class ByIdentifier
{
    public function handle(Builder $builder, Closure $next)
    {
        $identifier = trim((string) request()->input('identifier'));

        if (empty($identifier)) {
            return $next($builder);
        }

        // 'SL-1B4H13B',   // válido
        // 'S-1234567',    // inválido (só números no sufixo)
        // 'AB-ABCDEFG',   // inválido (só letras no sufixo)
        // 'SELL-1B4H13B', // inválido (prefixo > 3 letras)
        // 'SL-1B4H1',     // inválido (menos de 7 caracteres)
        $pattern = '/^[A-Z]{1,3}-(?=.*[A-Z])(?=.*[0-9])[A-Z0-9]{7,}$/';

        if (preg_match($pattern, $identifier)) {
            $builder->whereCode($identifier);
        } elseif (filter_var($identifier, FILTER_VALIDATE_INT)) {
            $builder->whereKey($identifier);
        }

        return $next($builder);
    }
}
