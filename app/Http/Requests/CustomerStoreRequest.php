<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the validation and authorization for storing a customer.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * {@see \App\Models\Customer}
 * {@see \App\Http\Controllers\CustomerController}
 */
#[OA\Schema(
    schema: "CustomerStoreRequest",
    title: "CustomerStoreRequest",
    description: "Validation rules for storing a customer.",
    required: ["name", "company_name", "email", "phone", "vat_number"],
    properties: [
        new OA\Property(property: "name", description: "Name of the customer", type: "string"),
        new OA\Property(property: "company_name", description: "Company name of the customer", type: "string"),
        new OA\Property(property: "email", description: "Email of the customer", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "Phone number of the customer", type: "string"),
        new OA\Property(property: "address_line_1", description: "Address line 1 of the customer", type: "string", nullable: true),
        new OA\Property(property: "address_line_2", description: "Address line 2 of the customer", type: "string", nullable: true),
        new OA\Property(property: "post_code", description: "Postal code of the customer", type: "string", nullable: true),
        new OA\Property(property: "city", description: "City of the customer", type: "string", nullable: true),
        new OA\Property(property: "country", description: "Country of the customer", type: "string", nullable: true),
        new OA\Property(property: "vat_number", description: "VAT number of the customer", type: "string"),
    ]
)]
class CustomerStoreRequest extends FormRequest
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
            'country' => ['nullable'],
            'vat_number' => ['required', 'string'],
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
            'email.unique' => 'The email address is already registered for another customer.',
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
}
