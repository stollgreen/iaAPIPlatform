<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of time tracking state resources.
 */
#[OA\Schema(
    schema: 'TimeTrackingStateCollection',
    title: 'TimeTrackingStateCollection',
    description: 'A collection of time tracking state resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/TimeTrackingStateResource')
        )
    ],
    type: 'object'
)]
class TimeTrackingStateCollection extends ResourceCollection
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
