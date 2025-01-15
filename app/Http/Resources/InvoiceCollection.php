<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of invoice resources.
 */
#[OA\Schema(
    schema: 'InvoiceCollection',
    title: 'InvoiceCollection',
    description: 'A collection of invoice resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/InvoiceResource')
        ),
    ],
    type: 'object'
)]
class InvoiceCollection extends ResourceCollection
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
