<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of commitment resources.
 */
#[OA\Schema(
    schema: 'CommitmentCollection',
    title: 'CommitmentCollection',
    description: 'A collection of commitment resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/CommitmentResource')
        )
    ],
    type: 'object'
)]
class CommitmentCollection extends ResourceCollection
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
