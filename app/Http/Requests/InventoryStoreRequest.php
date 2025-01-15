<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class InventoryStoreRequest
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Inventory
 * @see \App\Http\Controllers\InventoryController::store
 */
#[OA\Schema(
    schema: "InventoryStoreRequest",
    title: "InventoryStoreRequest",
    description: "Validation rules for creating an inventory item.",
    required: ["name", "type", "quantity", "available", "condition", "price", "rental_price"],
    properties: [
        new OA\Property(property: "name", description: "The name of the inventory item", type: "string"),
        new OA\Property(property: "type", description: "The type of the inventory item", type: "string"),
        new OA\Property(property: "quantity", description: "The quantity available", type: "integer"),
        new OA\Property(property: "available", description: "Availability status of the item", type: "boolean"),
        new OA\Property(property: "condition", description: "Condition of the inventory item", type: "integer"),
        new OA\Property(property: "price", description: "Price of the inventory item", type: "string"),
        new OA\Property(property: "rental_price", description: "Rental price of the inventory item", type: "string"),
    ]
)]
class InventoryStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name of the inventory item is required.',
            'type.required' => 'The type of the inventory item is required.',
            'quantity.required' => 'The quantity of the item is required.',
            'available.required' => 'You must specify the availability of the item.',
            'condition.required' => 'The condition of the item is required.',
            'price.required' => 'The price of the item is required.',
            'rental_price.required' => 'The rental price of the item is required.',
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
            'name' => 'inventory item name',
            'type' => 'inventory item type',
            'quantity' => 'item quantity',
            'available' => 'availability status',
            'condition' => 'item condition',
            'price' => 'item price',
            'rental_price' => 'item rental price',
        ];
    }
}
