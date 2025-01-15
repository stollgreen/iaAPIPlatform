<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class InventoryCondition
 *
 * Represents the condition of an inventory item in the system.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the inventory condition.
 * @property string $name The name of the inventory condition.
 */
class InventoryCondition extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
