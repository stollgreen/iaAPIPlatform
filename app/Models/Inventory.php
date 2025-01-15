<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Inventory
 *
 * Represents an inventory item in the system. An inventory item has specific details
 * such as name, type, quantity, availability, condition, and pricing information.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the inventory item.
 * @property string $name The name of the inventory item.
 * @property string $type The type or category of the inventory item.
 * @property int $quantity The quantity of the inventory item.
 * @property bool $available Whether the inventory item is currently available.
 * @property int $condition The condition ID of the inventory item. {@see InventoryCondition}
 * @property float|null $price The price of the inventory item.
 * @property float|null $rental_price The rental price of the inventory item.
 */
class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'type',
        'quantity',
        'available',
        'condition',
        'price',
        'rental_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'available' => 'boolean',
        'condition' => 'integer',
    ];

    /**
     * The condition of the inventory item.
     *
     * @return BelongsTo The relationship definition for the InventoryCondition model.
     */
    public function condition(): BelongsTo
    {
        return $this->belongsTo(InventoryCondition::class);
    }
}
