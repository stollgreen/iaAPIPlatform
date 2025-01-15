<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing users.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\User
 * @see \App\Http\Controllers\UserController::store
 */
#[OA\Schema(
    schema: "UserStoreRequest",
    title: "UserStoreRequest",
    description: "Validation rules for storing users",
    required: ["name", "email", "password"],
    properties: [
        new OA\Property(property: "name", description: "The name of the user", type: "string"),
        new OA\Property(property: "email", description: "The email address of the user", type: "string", format: "email"),
        new OA\Property(property: "password", description: "The password for the user (minimum of 8 characters)", type: "string", minLength: 8),
    ]
)]
class UserStoreRequest extends FormRequest
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
            'password' => ['required', 'string', 'min:8'],
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
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters long.',
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
            'name' => 'user name',
            'email' => 'email address',
            'password' => 'password',
        ];
    }
}
