<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating service areas.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\ServiceArea
 * @see \App\Http\Controllers\ServiceAreaController
 */
#[OA\Schema(
    schema: "ServiceAreaUpdateRequest",
    title: "ServiceAreaUpdateRequest",
    description: "Validation rules for updating a service area.",
    required: ["name", "description"],
    properties: [
        new OA\Property(property: "name", description: "The name of the service area", type: "string"),
        new OA\Property(property: "description", description: "The description of the service area", type: "string"),
        new OA\Property(property: "parent_area_id", description: "The ID of the parent area, if applicable", type: "integer", nullable: true),
    ]
)]
class ServiceAreaUpdateRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'parent_area_id' => ['nullable', 'integer', 'exists:parent_areas,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'service area name',
            'description' => 'service area description',
            'parent_area_id' => 'parent area',
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
            'description.required' => 'The :attribute is required.',
            'description.string' => 'The :attribute must be a valid string.',
            'parent_area_id.exists' => 'The selected :attribute does not exist.',
            'parent_area_id.integer' => 'The :attribute must be an integer.',
        ];
    }
}
