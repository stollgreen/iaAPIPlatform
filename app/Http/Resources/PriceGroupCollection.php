<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of price group resources.
 */
#[OA\Schema(
    schema: 'PriceGroupCollection',
    title: 'PriceGroupCollection',
    description: 'A collection of price group resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/PriceGroupResource')
        ),
    ],
    type: 'object'
)]
class PriceGroupCollection extends ResourceCollection
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
