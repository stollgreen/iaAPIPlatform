<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class EventState
 *
 * Represents the state of an event in the system. An event state determines the current
 * status or stage of the event, such as 'Pending', 'Ongoing', or 'Completed'.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the event state.
 * @property string $name The name of the event state.
 */
class EventState extends Model
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
     * The events associated with this state.
     *
     * @return HasMany The relationship definition for the Event model.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'status');
    }
}
