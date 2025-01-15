<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GroupUser
 *
 * Represents the relationship between a user and a group in the system.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the group-user relationship.
 * @property int $groupid The ID of the group.
 * @property int $userid The ID of the user associated with the group.
 */
class GroupUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'groupid',
        'userid',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'groupid' => 'integer',
        'userid' => 'integer',
    ];

    /**
     * The group associated with this relationship.
     *
     * @return BelongsTo The relationship definition for the Group model.
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'groupid');
    }

    /**
     * The user associated with this relationship.
     *
     * @return BelongsTo The relationship definition for the User model.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userid');
    }
}
