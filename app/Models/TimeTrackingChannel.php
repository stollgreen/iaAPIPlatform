<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class TimeTrackingChannel
 *
 * Represents a time tracking channel in the system. A channel has attributes
 * such as name, description, and active status.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the time tracking channel.
 * @property string $name The name of the time tracking channel.
 * @property string|null $description A description of the time tracking channel.
 * @property bool $active Indicates whether the channel is active.
 */
class TimeTrackingChannel extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'active' => 'boolean',
    ];
}
