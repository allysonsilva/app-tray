<?php

declare(strict_types=1);

namespace App\Applications\Seller\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Sale\DataObjects\SearchData;
use Shared\Enums\SortDirection;
use Shared\Rules\Comparable\ComparableRule;

class IndexSaleRequest extends FormRequest
{
    public ?ComparableRule $amount;
    public ?ComparableRule $commissionAmount;
    public ?ComparableRule $saleAt;

    public function __invoke(): SearchData
    {
        $data = array_filter(array_merge($this->validated(), [
            'amount' => $this->amount?->data(),
            'commission_amount' => $this->commissionAmount?->data(),
            'sale_at' => $this->saleAt?->data(),
        ]));

        return SearchData::from($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'order_by' => ['sometimes', 'required', new Enum(SortDirection::class)],
            'per_page' => ['sometimes', 'integer', 'min:1'],
            'amount' => ['sometimes', 'required', $this->amount = new ComparableRule()],
            'commission_amount' => ['sometimes', 'required', $this->commissionAmount = new ComparableRule()],
            'sale_at' => ['sometimes', 'required', 'date', 'date_format:Y-m-d', $this->saleAt = new ComparableRule()],
        ];
    }
}
