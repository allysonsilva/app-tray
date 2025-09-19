<?php

declare(strict_types=1);

namespace Shared\Rules\Comparable;

use Carbon\Carbon;
use Closure;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Shared\Enums\FilterOperator;

class ComparableRule implements ValidationRule
{
    private FilterOperator $operator = FilterOperator::EQUAL;

    private Carbon|int|float|string $value;

    /**
     * Run the validation rule.
     *
     * Valida se o valor começa com um operador (<, >, <=, >=, =, !=) e contém uma data Y-m-d válida.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // regex captura opcional operador + valor
        if (! preg_match('/^(<=|>=|=|<|>|!=)?(.+)$/', $value, $matches)) {
            $fail("O campo {$attribute} tem um formato inválido.");

            return;
        }

        $this->operator = FilterOperator::tryFrom($matches[1]) ?: FilterOperator::EQUAL;
        $this->value = trim($matches[2]);

        if (is_numeric($this->value)) {
            // Implicit Conversion (Mathematical Operations)
            $this->value += 0;

            return;
        }

        try {
            // validar a data no formato Y-m-d
            $this->value = Carbon::createFromFormat('Y-m-d', $this->value)->startOfDay();
        } catch (Exception) {
            $fail("O campo {$attribute} deve ser uma data válida no formato Y-m-d.");
        }
    }

    public function data(): ?ComparableData
    {
        if (empty($this->value)) {
            return null;
        }

        return new ComparableData($this->operator, $this->value);
    }
}
