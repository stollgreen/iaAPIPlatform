<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating contact person information.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\ContactPerson
 * @see \App\Http\Controllers\ContactPersonController
 */
#[OA\Schema(
    schema: "ContactPersonUpdateRequest",
    title: "ContactPersonUpdateRequest",
    description: "The request schema for updating contact person information",
    required: ["name", "email", "phone", "location_id", "role"],
    properties: [
        new OA\Property(property: "name", description: "The name of the contact person", type: "string"),
        new OA\Property(property: "email", description: "The email of the contact person", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "The phone number of the contact person", type: "string"),
        new OA\Property(property: "location_id", description: "The location ID of the contact person", type: "integer"),
        new OA\Property(property: "role", description: "The role of the contact person", type: "string"),
    ]
)]
class ContactPersonUpdateRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:contact_persons,email'],
            'phone' => ['required', 'string'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'role' => ['required', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'contact person name',
            'email' => 'contact person email',
            'phone' => 'contact person phone',
            'location_id' => 'location ID',
            'role' => 'contact person role',
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
            'email.unique' => 'The :attribute has already been taken.',
            'phone.required' => 'The :attribute is required.',
            'phone.string' => 'The :attribute must be a valid string.',
            'location_id.required' => 'The :attribute is required.',
            'location_id.integer' => 'The :attribute must be an integer.',
            'location_id.exists' => 'The selected :attribute is invalid.',
            'role.required' => 'The :attribute is required.',
            'role.string' => 'The :attribute must be a valid string.',
        ];
    }
}
