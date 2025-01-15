<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of commitment state resources
 */
#[OA\Schema(
    schema: 'CommitmentStateCollection',
    title: 'CommitmentStateCollection',
    description: 'A collection of commitment state resources',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/CommitmentStateResource')
        ),
    ],
    type: 'object'
)]
class CommitmentStateCollection extends ResourceCollection
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
