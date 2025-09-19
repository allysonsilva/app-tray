<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResendCommissionSalleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'date_format:Y-m-d'],
        ];
    }
}
