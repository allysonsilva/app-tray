<?php

declare(strict_types=1);

namespace Sale\Models;

use Account\Models\Concerns\SellerAuthenticatable;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Sale\Database\Factories\SaleFactory;
use Shared\Eloquent\BaseModel;

/**
 * @property int $id
 * @property string $code
 * @property int $seller_id
 * @property int $amount
 * @property float $commission_rate
 * @property int $commission_amount
 * @property int $total_sales
 * @property int $total_amount
 * @property int $total_commission
 * @property \Illuminate\Support\Carbon $sale_at
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read Seller $seller
 */
#[UseFactory(SaleFactory::class)]
class Sale extends BaseModel
{
    use SellerAuthenticatable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'seller_id',
        'amount',
        'commission_rate',
        'commission_amount',
        'sale_at',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    protected function codePrefix(): string
    {
        return 'SL';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'seller_id' => 'integer',
            'amount' => 'integer',
            'commission_rate' => 'decimal:3',
            'commission_amount' => 'integer',
            'sale_at' => 'date:Y-m-d',
        ];
    }
}
