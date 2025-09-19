<?php

declare(strict_types=1);

namespace App\Applications\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'integer', 'regex:/^\d+$/'],
            'sale_at' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
