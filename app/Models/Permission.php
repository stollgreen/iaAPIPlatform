<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Permission
 *
 * Represents a permission in the system. A permission defines a specific capability
 * or authorization that can be assigned to a user or a group.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the permission.
 * @property string $name The name of the permission.
 * @property string|null $description A description of the permission.
 */
class Permission extends Model
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
