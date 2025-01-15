<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Class EventStateCollection
 *
 * This resource collection handles the transformation of event state data into an array,
 * suitable for API responses, and includes OpenAPI documentation for the schema.
 */
#[OA\Schema(
    schema: 'EventStateCollection',
    title: 'EventStateCollection',
    description: 'A collection of event states.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/EventStateResource')
        )
    ],
    type: 'object'
)]
class EventStateCollection extends ResourceCollection
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
