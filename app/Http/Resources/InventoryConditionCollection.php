<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of inventory condition resources.
 */
#[OA\Schema(
    schema: 'InventoryConditionCollection',
    title: 'InventoryConditionCollection',
    description: 'A collection of inventory condition resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/InventoryConditionResource')
        ),
    ],
    type: 'object'
)]
class InventoryConditionCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}
