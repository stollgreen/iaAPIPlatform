<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing employees.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Employee
 * @see \App\Http\Controllers\EmployeeController::store
 */
#[OA\Schema(
    schema: "EmployeeStoreRequest",
    title: "EmployeeStoreRequest",
    description: "Validation rules for storing employees.",
    required: ["first_name", "last_name", "email"],
    properties: [
        new OA\Property(property: "first_name", description: "The first name of the employee", type: "string"),
        new OA\Property(property: "last_name", description: "The last name of the employee", type: "string"),
        new OA\Property(property: "email", description: "The email address of the employee", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "The phone number of the employee", type: "string", nullable: true),
        new OA\Property(property: "address_line_1", description: "The first line of the address", type: "string", nullable: true),
        new OA\Property(property: "address_line_2", description: "The second line of the address", type: "string", nullable: true),
        new OA\Property(property: "post_code", description: "The postal code of the employee", type: "string", nullable: true),
        new OA\Property(property: "city", description: "The city where the employee resides", type: "string", nullable: true),
        new OA\Property(property: "country", description: "The country of residence", type: "string", nullable: true),
        new OA\Property(property: "hire_date", description: "The hire date for the employee", type: "string", format: "date", nullable: true),
        new OA\Property(property: "birth_date", description: "The birth date of the employee", type: "string", format: "date", nullable: true),
        new OA\Property(property: "gender", description: "The gender of the employee", type: "string", nullable: true),
        new OA\Property(property: "position", description: "The position of the employee", type: "string", nullable: true),
        new OA\Property(property: "department_id", description: "The department ID for the employee", type: "integer", nullable: true),
    ]
)]
class EmployeeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'phone' => ['nullable', 'string'],
            'address_line_1' => ['nullable', 'string'],
            'address_line_2' => ['nullable', 'string'],
            'post_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'hire_date' => ['nullable', 'date'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string'],
            'position' => ['nullable', 'string'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'The first name is required.',
            'last_name.required' => 'The last name is required.',
            'email.required' => 'The email address is required.',
            'email.unique' => 'The email address is already in use by another employee.',
            'department_id.exists' => 'The selected department does not exist.',
            'department_id.integer' => 'The department ID must be an integer.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'first name',
            'last_name' => 'last name',
            'email' => 'email address',
            'phone' => 'phone number',
            'address_line_1' => 'address line 1',
            'address_line_2' => 'address line 2',
            'post_code' => 'postal code',
            'city' => 'city',
            'country' => 'country',
            'hire_date' => 'hire date',
            'birth_date' => 'birth date',
            'gender' => 'gender',
            'position' => 'position',
            'department_id' => 'department ID',
        ];
    }
}
