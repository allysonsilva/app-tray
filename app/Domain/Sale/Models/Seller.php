<?php

declare(strict_types=1);

namespace Sale\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Sale\Database\Factories\SellerFactory;
use Shared\Eloquent\BaseModel;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property float $commission_percentage
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<Sale> $salles
 */
#[UseFactory(SellerFactory::class)]
class Seller extends BaseModel
{
    use Notifiable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'commission_percentage',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
    ];

    public function salles(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
