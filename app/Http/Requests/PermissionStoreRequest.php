<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing permissions.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Permission
 * @see \App\Http\Controllers\PermissionController
 */
#[OA\Schema(
    schema: "PermissionStoreRequest",
    title: "PermissionStoreRequest",
    description: "Validation rules for storing permissions",
    required: ["name", "description"],
    properties: [
        new OA\Property(property: "name", description: "The name of the permission", type: "string"),
        new OA\Property(property: "description", description: "The description of the permission", type: "string"),
    ]
)]
class PermissionStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
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
            'name.required' => 'The name of the permission is required.',
            'description.required' => 'The description of the permission is required.',
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
            'name' => 'permission name',
            'description' => 'permission description',
        ];
    }
}
