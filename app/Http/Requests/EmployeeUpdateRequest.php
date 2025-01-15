<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for updating employees.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Employee
 * @see \App\Http\Controllers\EmployeeController
 */
#[OA\Schema(
    schema: "EmployeeUpdateRequest",
    title: "EmployeeUpdateRequest",
    description: "Validation rules for updating employees.",
    required: ["first_name", "last_name", "email"],
    properties: [
        new OA\Property(property: "first_name", description: "The first name of the employee", type: "string"),
        new OA\Property(property: "last_name", description: "The last name of the employee", type: "string"),
        new OA\Property(property: "email", description: "The email address of the employee", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "The phone number of the employee", type: "string", nullable: true),
        new OA\Property(property: "address_line_1", description: "The first address line", type: "string", nullable: true),
        new OA\Property(property: "address_line_2", description: "The second address line", type: "string", nullable: true),
        new OA\Property(property: "post_code", description: "The postal code", type: "string", nullable: true),
        new OA\Property(property: "city", description: "The city", type: "string", nullable: true),
        new OA\Property(property: "country", description: "The country", type: "string", nullable: true),
        new OA\Property(property: "hire_date", description: "The hire date", type: "string", format: "date", nullable: true),
        new OA\Property(property: "birth_date", description: "The birth date", type: "string", format: "date", nullable: true),
        new OA\Property(property: "gender", description: "The gender of the employee", type: "string", nullable: true),
        new OA\Property(property: "position", description: "The position of the employee", type: "string", nullable: true),
        new OA\Property(property: "department_id", description: "The ID of the department", type: "integer", nullable: true),
    ]
)]
class EmployeeUpdateRequest extends FormRequest
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
            'country' => ['nullable'],
            'hire_date' => ['nullable', 'date'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable'],
            'position' => ['nullable', 'string'],
            'department_id' => ['nullable', 'integer', 'exists:departments,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
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

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'first_name.required' => 'The :attribute is required.',
            'last_name.required' => 'The :attribute is required.',
            'email.required' => 'The :attribute is required.',
            'email.email' => 'The :attribute must be a valid email address.',
            'email.unique' => 'The :attribute must be unique.',
            'department_id.exists' => 'The selected :attribute does not exist.',
        ];
    }
}
