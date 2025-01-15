<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 */
#[OA\Schema(
    schema: 'CountryResource',
    title: 'CountryResource',
    description: 'Represents a country',
    required: ['id', 'name'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the country', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the country', type: 'string'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the country was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the country was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object',
)]
class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
