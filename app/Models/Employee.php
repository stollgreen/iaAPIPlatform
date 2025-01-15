<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Employee
 *
 * Represents an employee in the system. An employee can belong to a department and has
 * associated attributes such as their personal information, job position, salary, and more.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the employee.
 * @property string $first_name The first name of the employee.
 * @property string $last_name The last name of the employee.
 * @property string $email The email address of the employee.
 * @property string|null $phone The phone number of the employee.
 * @property string|null $address_line_1 The first line of the employee's address.
 * @property string|null $address_line_2 The second line of the employee's address (optional).
 * @property string $post_code The postal code for the employee's address.
 * @property string $city The city where the employee resides.
 * @property int $country The ID of the country associated with the employee. {@see Country}
 * @property \Illuminate\Support\Carbon $hire_date The date the employee was hired.
 * @property \Illuminate\Support\Carbon $birth_date The employee's date of birth.
 * @property int $gender The ID representing the employee's gender. {@see Gender}
 * @property string|null $position The job position of the employee.
 * @property int $department_id The ID of the department the employee belongs to. {@see Department}
 * @property float $salary The salary of the employee.
 */
class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'post_code',
        'city',
        'country',
        'hire_date',
        'birth_date',
        'gender',
        'position',
        'department_id',
        'salary',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'country' => 'integer',
        'hire_date' => 'date',
        'birth_date' => 'date',
        'gender' => 'integer',
        'department_id' => 'integer',
    ];

    /**
     * The country associated with the employee.
     *
     * @return BelongsTo The relationship definition for the Country model.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * The gender associated with the employee.
     *
     * @return BelongsTo The relationship definition for the Gender model.
     */
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    /**
     * The department the employee belongs to.
     *
     * @return BelongsTo The relationship definition for the Department model.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
