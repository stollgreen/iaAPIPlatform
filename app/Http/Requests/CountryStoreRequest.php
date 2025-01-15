<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the validation and authorization for storing a country.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * {@see \App\Http\Requests\CountryStoreRequest}
 * {@see \App\Http\Controllers\CountryController}
 */
#[OA\Schema(
    schema: "CountryStoreRequest",
    title: "CountryStoreRequest",
    description: "CountryStoreRequest",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "Name of the country", type: "string"),
    ]
)]
class CountryStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:countries,name'],
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
            'name.required' => 'The country name is required.',
            'name.unique' => 'The country name has already been taken.',
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
            'name' => 'country name',
        ];
    }
}
