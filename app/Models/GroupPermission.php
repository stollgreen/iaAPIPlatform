<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class GroupPermission
 *
 * Represents a permission assigned to a group within the system. Group permissions define
 * specific access levels or values associated with a group.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the group permission.
 * @property int $groupid The ID of the group this permission belongs to.
 * @property string $value The value of the permission.
 */
class GroupPermission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'groupid',
        'value',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'groupid' => 'integer',
    ];

    /**
     * The group this permission belongs to.
     *
     * @return BelongsTo The relationship definition for the Group model.
     */
    public function groupid(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
