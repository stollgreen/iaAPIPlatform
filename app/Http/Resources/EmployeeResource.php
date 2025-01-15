<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $first_name
 * @property mixed $last_name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $address_line_1
 * @property mixed $address_line_2
 * @property mixed $post_code
 * @property mixed $city
 * @property mixed $country
 * @property mixed $hire_date
 * @property mixed $birth_date
 * @property mixed $gender
 * @property mixed $position
 * @property mixed $department_id
 * @property mixed $salary
 */
#[OA\Schema(
    schema: 'EmployeeResource',
    title: 'EmployeeResource',
    description: 'Represents an employee',
    required: ['id', 'first_name', 'last_name', 'email', 'department_id'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the employee', type: 'integer'),
        new OA\Property(property: 'first_name', description: 'The first name of the employee', type: 'string'),
        new OA\Property(property: 'last_name', description: 'The last name of the employee', type: 'string'),
        new OA\Property(property: 'email', description: 'The email address of the employee', type: 'string'),
        new OA\Property(property: 'phone', description: 'The phone number of the employee', type: 'string'),
        new OA\Property(property: 'address_line_1', description: 'The primary address line of the employee', type: 'string'),
        new OA\Property(property: 'address_line_2', description: 'The secondary address line of the employee', type: 'string'),
        new OA\Property(property: 'post_code', description: 'The postal code of the employee\'s address', type: 'string'),
        new OA\Property(property: 'city', description: 'The city of the employee\'s address', type: 'string'),
        new OA\Property(property: 'country', description: 'The country of the employee\'s address', type: 'string'),
        new OA\Property(property: 'hire_date', description: 'The hire date of the employee', type: 'string', format: 'date'),
        new OA\Property(property: 'birth_date', description: 'The birth date of the employee', type: 'string', format: 'date'),
        new OA\Property(property: 'gender', description: 'The gender of the employee', type: 'string'),
        new OA\Property(property: 'position', description: 'The position of the employee', type: 'string'),
        new OA\Property(property: 'department_id', description: 'The ID of the department the employee belongs to', type: 'integer'),
        new OA\Property(property: 'salary', description: 'The salary of the employee', type: 'number', format: 'float'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the employee record was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the employee record was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'post_code' => $this->post_code,
            'city' => $this->city,
            'country' => $this->country,
            'hire_date' => $this->hire_date,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'position' => $this->position,
            'department_id' => $this->department_id,
            'salary' => $this->salary,
        ];
    }
}
