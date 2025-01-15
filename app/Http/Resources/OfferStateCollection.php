<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of offer state resources.
 */
#[OA\Schema(
    schema: 'OfferStateCollection',
    title: 'OfferStateCollection',
    description: 'A collection of offer state resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/OfferStateResource')
        ),
    ],
    type: 'object'
)]
class OfferStateCollection extends ResourceCollection
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
