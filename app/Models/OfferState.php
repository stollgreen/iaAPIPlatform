<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class OfferState
 *
 * Represents the state of an offer in the system. It includes information about
 * the name of the state and any related offers.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the offer state.
 * @property string $name The name of the offer state.
 */
class OfferState extends Model
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

    /**
     * The offers associated with this state.
     *
     * @return HasMany The relationship definition for the Offer model.
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'status', 'id');
    }
}
