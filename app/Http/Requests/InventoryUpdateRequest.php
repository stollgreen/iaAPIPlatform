<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for updating inventory items.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Inventory
 * @see \App\Http\Controllers\InventoryController
 */
#[OA\Schema(
    schema: "InventoryUpdateRequest",
    title: "InventoryUpdateRequest",
    required: ["name", "type", "quantity", "available", "condition", "price", "rental_price"],
    properties: [
        new OA\Property(property: "name", description: "The name of the inventory item", type: "string"),
        new OA\Property(property: "type", description: "The type or category of the inventory item", type: "string"),
        new OA\Property(property: "quantity", description: "The quantity of the inventory item", type: "string"),
        new OA\Property(property: "available", description: "The availability status of the inventory item", type: "boolean"),
        new OA\Property(property: "condition", description: "The condition of the inventory item (e.g., new, used)", type: "integer"),
        new OA\Property(property: "price", description: "The price of the inventory item", type: "string"),
        new OA\Property(property: "rental_price", description: "The rental price of the inventory item", type: "string"),
    ]
)]
class InventoryUpdateRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'quantity' => ['required', 'numeric'],
            'available' => ['required', 'boolean'],
            'condition' => ['required', 'numeric', 'exists:inventory_conditions,id'],
            'price' => ['required', 'numeric'],
            'rental_price' => ['required', 'numeric'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'inventory name',
            'type' => 'inventory type',
            'quantity' => 'inventory quantity',
            'available' => 'availability status',
            'condition' => 'inventory condition',
            'price' => 'inventory price',
            'rental_price' => 'rental price',
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
            'type.required' => 'The :attribute is required.',
            'type.string' => 'The :attribute must be a valid string.',
            'quantity.required' => 'The :attribute is required.',
            'quantity.string' => 'The :attribute must be a valid string.',
            'available.required' => 'The :attribute is required.',
            'available.boolean' => 'The :attribute must be true or false.',
            'condition.required' => 'The :attribute is required.',
            'condition.string' => 'The :attribute must be a valid string.',
            'price.required' => 'The :attribute is required.',
            'price.string' => 'The :attribute must be a valid string.',
            'rental_price.required' => 'The :attribute is required.',
            'rental_price.string' => 'The :attribute must be a valid string.',
        ];
    }
}
