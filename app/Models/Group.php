<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Group
 *
 * Represents a group within the system. A group can have a name and a description
 * to provide additional details about its purpose or role.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the group.
 * @property string $name The name of the group.
 * @property string|null $description A description of the group.
 */
class Group extends Model
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
