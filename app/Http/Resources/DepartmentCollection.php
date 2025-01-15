<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of department resources.
 */
#[OA\Schema(
    schema: 'DepartmentCollection',
    title: 'DepartmentCollection',
    description: 'A collection of department resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/DepartmentResource')
        ),
    ],
    type: 'object'
)]
class DepartmentCollection extends ResourceCollection
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
