<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Class ServiceAreaCollection
 *
 * This resource collection handles the transformation of service area data into an array,
 * suitable for API responses, and includes OpenAPI documentation for the schema.
 */
#[OA\Schema(
    schema: 'ServiceAreaCollection',
    title: 'ServiceAreaCollection',
    description: 'A collection of service areas.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/ServiceAreaResource')
        )
    ],
    type: 'object'
)]
class ServiceAreaCollection extends ResourceCollection
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
