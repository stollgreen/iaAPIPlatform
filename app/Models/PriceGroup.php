<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PriceGroup
 *
 * Represents a price group in the system. A price group defines pricing details
 * such as name, description, discount, and associated currency.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the price group.
 * @property string $name The name of the price group.
 * @property string|null $description A description of the price group.
 * @property float $discount The discount percentage for this price group.
 * @property string $currency The currency used by this price group.
 */
class PriceGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'description',
        'discount',
        'currency',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'discount' => 'float',
    ];
}
