<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Represents the time tracking functionality within the application.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier of the time tracking record.
 * @property int $employee_id The associated employee's ID.
 * @property int $commitment_id The commitment ID associated with this time tracking.
 * @property int $time_tracking_channel_id The time tracking channel ID.
 * @property int $time_tracking_state_id The state ID of the time tracking.
 * @property \DateTime|null $start_time The start time of the tracking.
 * @property \DateTime|null $end_time The end time of the tracking.
 */
class TimeTracking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'commitment_id',
        'time_tracking_channel_id',
        'time_tracking_state_id',
        'start_time',
        'end_time',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'employee_id' => 'integer',
        'commitment_id' => 'integer',
        'time_tracking_channel_id' => 'integer',
        'time_tracking_state_id' => 'integer',
    ];

    /**
     * Get the employee associated with this time tracking.
     *
     * @return BelongsTo
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the commitment associated with this time tracking.
     *
     * @return BelongsTo
     */
    public function commitment(): BelongsTo
    {
        return $this->belongsTo(Commitment::class);
    }

    /**
     * Get the time tracking channel.
     *
     * @return BelongsTo
     */
    public function timeTrackingChannel(): BelongsTo
    {
        return $this->belongsTo(TimeTrackingChannel::class);
    }

    /**
     * Get the time tracking state.
     *w
     * @return BelongsTo
     */
    public function timeTrackingState(): BelongsTo
    {
        return $this->belongsTo(TimeTrackingState::class);
    }
}
