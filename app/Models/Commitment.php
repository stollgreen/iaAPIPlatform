<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Commitment
 *
 * Represents a commitment or assignment in the system. A commitment links a promoter
 * to an event with details such as timings, role, and status.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the commitment.
 * @property int $promoter_id The ID of the promoter assigned to this commitment.
 * @property int $event_id The ID of the event related to this commitment.
 * @property string|null $role The role of the promoter in the event.
 * @property Carbon $start_time The start time of the commitment.
 * @property Carbon $end_time The end time of the commitment.
 * @property int $status The status ID of the commitment. {@see CommitmentState}
 */
class Commitment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'promoter_id',
        'event_id',
        'role',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'promoter_id' => 'integer',
        'event_id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'status' => 'integer',
    ];

    /**
     * The promoter assigned to this commitment.
     *
     * @return BelongsTo The relationship definition for the Promoter model.
     */
    public function promoter(): BelongsTo
    {
        return $this->belongsTo(Promoter::class, 'promoter_id', 'id');
    }

    /**
     * The event associated with this commitment.
     *
     * @return BelongsTo The relationship definition for the Event model.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    /**
     * The status of this commitment.
     *
     * @return BelongsTo The relationship definition for the CommitmentState model.
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(CommitmentState::class, 'status', 'id');
    }
}