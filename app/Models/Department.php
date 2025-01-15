<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Department
 *
 * Represents a department entity in the system. A department is used to group related employees
 * or units within the organization structure.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the department.
 * @property string $name The name of the department.
 */
class Department extends Model
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

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
