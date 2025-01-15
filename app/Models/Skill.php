<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Skill
 *
 * Represents a skill in the system. A skill can have a name, description, category,
 * and optionally require a certification.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the skill.
 * @property string $name The name of the skill.
 * @property string|null $description A description of the skill.
 * @property string|null $category The category to which the skill belongs.
 * @property string|null $required_certification Optional certification required for the skill.
 */
class Skill extends Model
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
        'category',
        'required_certification',
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
