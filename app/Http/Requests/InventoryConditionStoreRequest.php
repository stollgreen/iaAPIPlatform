<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing inventory conditions.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\InventoryCondition
 * @see \App\Http\Controllers\InventoryConditionController::store
 */
#[OA\Schema(
    schema: "InventoryConditionStoreRequest",
    title: "InventoryConditionStoreRequest",
    description: "Rules for storing inventory conditions.",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "The name of the inventory condition", type: "string"),
    ]
)]
class InventoryConditionStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The inventory condition name is required.',
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
            'name' => 'inventory condition name',
        ];
    }
}
