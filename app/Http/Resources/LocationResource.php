<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $address
 * @property mixed $city
 * @property mixed $country
 * @property mixed $postal_code
 * @property mixed $capacity
 */
#[OA\Schema(
    schema: 'LocationResource',
    title: 'LocationResource',
    description: 'Represents a location',
    required: ['id', 'name', 'address', 'city', 'country', 'postal_code', 'capacity'],
    properties: [
        new OA\Property(property: 'id', description: 'The location ID', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the location', type: 'string'),
        new OA\Property(property: 'address', description: 'The address of the location', type: 'string'),
        new OA\Property(property: 'city', description: 'The city of the location', type: 'string'),
        new OA\Property(property: 'country', description: 'The country of the location', type: 'string'),
        new OA\Property(property: 'postal_code', description: 'The postal code of the location', type: 'string'),
        new OA\Property(property: 'capacity', description: 'The capacity of the location', type: 'integer'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the location was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the location was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object',
)]
class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'city' => $this->city,
            'country' => $this->country,
            'postal_code' => $this->postal_code,
            'capacity' => $this->capacity,
        ];
    }
}
