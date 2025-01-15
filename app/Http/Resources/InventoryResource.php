<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $type
 * @property mixed $quantity
 * @property mixed $available
 * @property mixed $condition
 * @property mixed $price
 * @property mixed $rental_price
 */
#[OA\Schema(
    schema: 'InventoryResource',
    title: 'InventoryResource',
    description: 'Represents an inventory item',
    required: ['id', 'name', 'type', 'quantity', 'available', 'condition'],
    properties: [
        new OA\Property(property: 'id', description: 'The inventory ID', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the inventory item', type: 'string'),
        new OA\Property(property: 'type', description: 'The type of the inventory item', type: 'string'),
        new OA\Property(property: 'quantity', description: 'The quantity of the inventory item', type: 'integer'),
        new OA\Property(property: 'available', description: 'The availability status of the inventory', type: 'boolean'),
        new OA\Property(property: 'condition', description: 'The condition of the inventory item', type: 'string'),
        new OA\Property(property: 'price', description: 'The purchase price of the inventory item', type: 'number', format: 'float'),
        new OA\Property(property: 'rental_price', description: 'The rental price of the inventory item', type: 'number', format: 'float'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the inventory item was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the inventory item was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object',
)]
class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'quantity' => $this->quantity,
            'available' => $this->available,
            'condition' => $this->condition,
            'price' => $this->price,
            'rental_price' => $this->rental_price,
        ];
    }
}
