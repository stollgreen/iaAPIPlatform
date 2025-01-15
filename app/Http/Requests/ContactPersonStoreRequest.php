<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the validation and authorization for storing a contact person.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * {@see \App\Models\ContactPerson}
 * {@see \App\Http\Controllers\ContactPersonController}
 */
#[OA\Schema(
    schema: "ContactPersonStoreRequest",
    title: "ContactPersonStoreRequest",
    description: "Request body for storing a contact person",
    required: ["name", "email", "phone", "location_id", "role"],
    properties: [
        new OA\Property(property: "name", description: "Name of the contact person", type: "string"),
        new OA\Property(property: "email", description: "Email of the contact person", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "Phone number of the contact person", type: "string"),
        new OA\Property(property: "location_id", description: "ID of the location", type: "integer"),
        new OA\Property(property: "role", description: "Role of the contact person", type: "string"),
    ]
)]
class ContactPersonStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'The email has already been taken.',
            'location_id.exists' => 'The selected location does not exist.',
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
            'name' => 'contact person name',
            'email' => 'email',
            'phone' => 'phone number',
            'location_id' => 'location',
            'role' => 'role',
        ];
    }
}
