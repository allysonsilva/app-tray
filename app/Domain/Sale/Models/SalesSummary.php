<?php

declare(strict_types=1);

namespace Sale\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Shared\Eloquent\BaseModel;
use Shared\Eloquent\Concerns\HasCode;

/**
 * @property int $id
 * @property string $code
 * @property int $seller_id
 * @property int $total_sales_count
 * @property int $total_sales_amount
 * @property int $total_commission_amount
 * @property \Illuminate\Support\Carbon $created_at
 *
 * @property-read Seller $seller
 */
class SalesSummary extends BaseModel
{
    use HasCode;

    public const UPDATED_AT = null;

    /**
     * The table associated with the model.
     *
     * @var string|null
     */
    protected $table = 'sales_summary';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'seller_id',
        'total_sales_count',
        'total_sales_amount',
        'total_commission_amount',
        'created_at',
    ];

    public function seller(): BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    protected function codePrefix(): string
    {
        return 'SLS';
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
            'total_sales_count' => 'integer',
            'total_sales_amount' => 'integer',
            'total_commission_amount' => 'integer',
            'created_at' => 'date:Y-m-d',
        ];
    }
}
