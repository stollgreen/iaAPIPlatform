<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Class EventCollection
 *
 * This resource collection handles the transformation of event data into an array,
 * suitable for API responses, and includes OpenAPI documentation for the schema.
 */
#[OA\Schema(
    schema: 'EventCollection',
    title: 'EventCollection',
    description: 'A collection of events.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/EventResource')
        )
    ],
    type: 'object'
)]
class EventCollection extends ResourceCollection
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
