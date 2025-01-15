<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the validation and authorization for storing a department.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Department
 * @see \App\Http\Controllers\DepartmentController
 */
#[OA\Schema(
    schema: "DepartmentStoreRequest",
    title: "DepartmentStoreRequest",
    description: "The request schema for storing a department",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "The name of the department", type: "string", maxLength: 255),
    ]
)]
class DepartmentStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:departments,name'],
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
            'name.unique' => 'The department name has already been taken.',
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
            'name' => 'department name',
        ];
    }
}
