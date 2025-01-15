<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of time tracking channel resources.
 */
#[OA\Schema(
    schema: 'TimeTrackingChannelCollection',
    title: 'TimeTrackingChannelCollection',
    description: 'Represents a collection of time tracking channels.',
    properties: [
        new OA\Property(
            property: 'data',
            description: 'The list of time tracking channels.',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/TimeTrackingChannelResource')
        )
    ],
    type: 'object'
)]
class TimeTrackingChannelCollection extends ResourceCollection
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
