<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating location details.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Location
 * @see \App\Http\Controllers\LocationController
 */
#[OA\Schema(
    schema: "LocationUpdateRequest",
    title: "LocationUpdateRequest",
    description: "The request schema for updating a location",
    required: ["name", "address", "city", "country", "postal_code", "capacity"],
    properties: [
        new OA\Property(property: "name", description: "The name of the location", type: "string"),
        new OA\Property(property: "address", description: "The address of the location", type: "string"),
        new OA\Property(property: "city", description: "The city where the location is", type: "string"),
        new OA\Property(property: "country", description: "The ID of the country", type: "integer"),
        new OA\Property(property: "postal_code", description: "The postal code of the location", type: "string"),
        new OA\Property(property: "capacity", description: "The capacity of the location", type: "integer"),
    ]
)]
class LocationUpdateRequest extends FormRequest
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
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'location name',
            'address' => 'location address',
            'city' => 'location city',
            'country' => 'location country',
            'postal_code' => 'location postal code',
            'capacity' => 'location capacity',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute is required.',
            'address.required' => 'The :attribute is required.',
            'city.required' => 'The :attribute is required.',
            'country.required' => 'The :attribute is required.',
            'country.integer' => 'The :attribute must be a valid integer.',
            'postal_code.required' => 'The :attribute is required.',
            'capacity.required' => 'The :attribute is required.',
            'capacity.integer' => 'The :attribute must be a valid integer.',
        ];
    }
}
