<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating countries.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Country
 * @see \App\Http\Controllers\CountryController
 */
#[OA\Schema(
    schema: "CountryUpdateRequest",
    title: "CountryUpdateRequest",
    description: "CountryUpdateRequest",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "Name of the country", type: "string"),
    ]
)]
class CountryUpdateRequest extends FormRequest
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
            'name' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'country name',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The :attribute must be a valid string.',
        ];
    }
}
