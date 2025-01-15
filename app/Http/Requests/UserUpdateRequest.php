<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating users.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\User
 * @see \App\Http\Controllers\UserController
 */
#[OA\Schema(
    schema: "UserUpdateRequest",
    title: "UserUpdateRequest",
    description: "validation rules for updating users",
    required: ["name", "email"],
    properties: [
        new OA\Property(property: "name", description: "The full name of the user", type: "string"),
        new OA\Property(property: "email", description: "The email address of the user", type: "string", format: "email"),
    ]
)]
class UserUpdateRequest extends FormRequest
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
            'email' => ['required', 'email'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'user name',
            'email' => 'email address',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute is required.',
            'name.string' => 'The :attribute must be a valid string.',
            'email.required' => 'The :attribute is required.',
            'email.email' => 'The :attribute must be a valid email address.',
        ];
    }
}
