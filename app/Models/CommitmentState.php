<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class CommitmentState
 *
 * Represents the state or status of a commitment in the system. This model
 * defines various states that can be assigned to a commitment, such as pending,
 * confirmed, or cancelled.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the commitment state.
 * @property string $name The name of the commitment state.
 */
class CommitmentState extends Model
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
