<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;


/**
 * Handles the HTTP request for creating a service area.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\ServiceArea
 * @see \App\Http\Controllers\ServiceAreaController::store
 */
#[OA\Schema(
    schema: "ServiceAreaStoreRequest",
    title: "ServiceAreaStoreRequest",
    description: "Validation rules for creating a service area.",
    required: ["name", "description"],
    properties: [
        new OA\Property(property: "name", description: "The name of the service area", type: "string"),
        new OA\Property(property: "description", description: "A description of the service area", type: "string"),
        new OA\Property(property: "parent_area_id", description: "The parent area ID, if applicable", type: "integer", nullable: true)
    ],
    type: "object"
)]
class ServiceAreaStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name of the service area is required.',
            'description.required' => 'The description of the service area is required.',
            'parent_area_id.exists' => 'The selected parent area does not exist.',
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
            'name' => 'service area name',
            'description' => 'service area description',
            'parent_area_id' => 'parent area ID',
        ];
    }
}
