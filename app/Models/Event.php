<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Event
 *
 * Represents an event in the system. An event is associated with a specific location,
 * organized by an organizer, and has a defined status and budget.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the event.
 * @property string $name The name of the event.
 * @property \Illuminate\Support\Carbon $date The date of the event.
 * @property int $location_id The ID of the location where the event will take place.
 * @property string|null $organizer The organizer of the event.
 * @property float|null $budget The budget allocated for the event.
 * @property int $status The status ID of the event. {@see EventState}
 */
class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'date',
        'location_id',
        'organizer',
        'budget',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'date' => 'datetime',
        'location_id' => 'integer',
        'status' => 'integer',
    ];

    /**
     * The location where the event will take place.
     *
     * @return BelongsTo The relationship definition for the Location model.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * The status of the event.
     *
     * @return BelongsTo The relationship definition for the EventState model.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(EventState::class);
    }
}
