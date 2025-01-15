<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Gender
 *
 * Represents a gender entity in the system. It stores the name of a gender.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the gender.
 * @property string $name The name of the gender.
 */
class Gender extends Model
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
