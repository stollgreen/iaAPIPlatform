<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of time tracking resources.
 */
#[OA\Schema(
    schema: 'TimeTrackingCollection',
    title: 'TimeTrackingCollection',
    description: 'A collection of time tracking resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/TimeTrackingResource')
        )
    ],
    type: 'object'
)]
class TimeTrackingCollection extends ResourceCollection
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
