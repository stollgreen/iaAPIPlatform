<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Occupation
 *
 * Represents an occupation in the system. An occupation defines a specific role
 * or job along with required skills, hourly rate, and related event.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the occupation.
 * @property string $name The name of the occupation.
 * @property string|null $description A description of the occupation.
 * @property string|null $required_skills The skills required for the occupation.
 * @property float $hourly_rate The hourly rate for the occupation.
 * @property int $event The ID of the associated event.
 */
class Occupation extends Model
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
        'required_skills',
        'hourly_rate',
        'event',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'hourly_rate' => 'float',
        'event' => 'integer',
    ];

    /**
     * The event associated with this occupation.
     *
     * @return BelongsTo The relationship definition for the Event model.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
