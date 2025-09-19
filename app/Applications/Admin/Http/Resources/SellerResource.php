<?php

declare(strict_types=1);

namespace App\Applications\Admin\Http\Resources;

use Seller\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Seller
 */
class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'commission_percentage' => sprintf('%.2f%%', $this->commission_percentage),
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
