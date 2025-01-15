<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for updating a customer's details.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Customer
 * @see \App\Http\Controllers\CustomerController
 */
#[OA\Schema(
    schema: "CustomerUpdateRequest",
    title: "CustomerUpdateRequest",
    description: "Validation rules for updating a customer.",
    required: ["name", "company_name", "email", "phone", "vat_number"],
    properties: [
        new OA\Property(property: "name", description: "The name of the customer", type: "string"),
        new OA\Property(property: "company_name", description: "The company name", type: "string"),
        new OA\Property(property: "email", description: "The email address of the customer", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "The phone number of the customer", type: "string"),
        new OA\Property(property: "address_line_1", description: "The first line of the address (optional)", type: "string", nullable: true),
        new OA\Property(property: "address_line_2", description: "The second line of the address (optional)", type: "string", nullable: true),
        new OA\Property(property: "post_code", description: "The postal code (optional)", type: "string", nullable: true),
        new OA\Property(property: "city", description: "The city of the customer (optional)", type: "string", nullable: true),
        new OA\Property(property: "country", description: "The country of the customer (optional)", type: "string", nullable: true),
        new OA\Property(property: "vat_number", description: "The VAT number of the customer", type: "string"),
    ]
)]
class CustomerUpdateRequest extends FormRequest
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
            'company_name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'phone' => ['required', 'string'],
            'address_line_1' => ['nullable', 'string'],
            'address_line_2' => ['nullable', 'string'],
            'post_code' => ['nullable', 'string'],
            'city' => ['nullable', 'string'],
            'country' => ['nullable', 'string'],
            'vat_number' => ['required', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'customer name',
            'company_name' => 'company name',
            'email' => 'email address',
            'phone' => 'phone number',
            'address_line_1' => 'address line 1',
            'address_line_2' => 'address line 2',
            'post_code' => 'postal code',
            'city' => 'city',
            'country' => 'country',
            'vat_number' => 'VAT number',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute is required.',
            'company_name.required' => 'The :attribute is required.',
            'email.required' => 'The :attribute is required.',
            'email.email' => 'The :attribute must be a valid email address.',
            'email.unique' => 'The :attribute must be unique.',
            'phone.required' => 'The :attribute is required.',
            'vat_number.required' => 'The :attribute is required.',
        ];
    }
}
