<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\Resources;

use Sale\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Sale
 */
class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'amount' => to_money($this->amount),
            'commission' => [
                'rate' => sprintf('%.2f%%', $this->commission_rate),
                'amount' => to_money($this->commission_amount),
            ],
            'sale_at' => $this->sale_at->toDateString(),
        ];
    }
}
