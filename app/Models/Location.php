<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Location
 *
 * Represents a physical location in the system. A location is defined by its name,
 * address, city, country, postal code, and capacity.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the location.
 * @property string $name The name of the location.
 * @property string $address The address of the location.
 * @property string $city The city where the location is situated.
 * @property int $country The country ID associated with the location. {@see Country}
 * @property string $postal_code The postal code for the location.
 * @property int $capacity The maximum capacity of the location.
 */
class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'postal_code',
        'capacity',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'country' => 'integer',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The country associated with this location.
     *
     * @return BelongsTo The relationship definition for the Country model.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
