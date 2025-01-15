<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class PromoterGroup
 *
 * Represents a group of promoters in the system. Promoter groups are characterized
 * by their specific skills, a description, and the maximum number of members.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the promoter group.
 * @property string $name The name of the promoter group.
 * @property string|null $skills The skills associated with the promoter group.
 * @property string|null $description A description of the promoter group.
 * @property int $max_members The maximum number of members allowed in the group.
 */
class PromoterGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'skills',
        'description',
        'max_members',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'skills' => 'array',
        'max_members' => 'integer',
    ];

    public function promoters()
    {
        return $this->hasMany(Promoter::class, 'promoter_group_id', 'id');
    }
}
