<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for updating inventory conditions.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\InventoryCondition
 * @see \App\Http\Controllers\InventoryConditionController
 */
#[OA\Schema(
    schema: "InventoryConditionUpdateRequest",
    title: "InventoryConditionUpdateRequest",
    description: "Rules for updating inventory conditions.",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "The name of the inventory condition", type: "string"),
    ]
)]
class InventoryConditionUpdateRequest extends FormRequest
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
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'inventory condition name',
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
        ];
    }
}
