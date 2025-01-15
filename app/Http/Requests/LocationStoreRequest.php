<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing locations.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Location
 * @see \App\Http\Controllers\LocationController::store
 */
#[OA\Schema(
    schema: "LocationStoreRequest",
    title: "LocationStoreRequest",
    description: "The request schema for storing a location",
    required: ["name", "address", "city", "country", "postal_code", "capacity"],
    properties: [
        new OA\Property(property: "name", description: "The name of the location", type: "string"),
        new OA\Property(property: "address", description: "The address of the location", type: "string"),
        new OA\Property(property: "city", description: "The city of the location", type: "string"),
        new OA\Property(property: "country", description: "The ID of the country", type: "integer"),
        new OA\Property(property: "postal_code", description: "The postal code of the location", type: "string"),
        new OA\Property(property: "capacity", description: "The capacity of the location", type: "integer"),
    ]
)]
class LocationStoreRequest extends FormRequest
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
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'integer'],
            'postal_code' => ['required', 'string'],
            'capacity' => ['required', 'integer'],
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
            'country.required' => 'The country field is required and must be a valid ID.',
            'capacity.required' => 'The capacity field is required and must be a number.',
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
            'postal_code' => 'postal code',
        ];
    }
}
