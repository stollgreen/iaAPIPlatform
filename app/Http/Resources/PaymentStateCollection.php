<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of payment state resources.
 */
#[OA\Schema(
    schema: 'PaymentStateCollection',
    title: 'PaymentStateCollection',
    description: 'A collection of payment state resources.',
    properties: [
        new OA\Property(
            property: 'data',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/PaymentStateResource')
        ),
    ],
    type: 'object'
)]
class PaymentStateCollection extends ResourceCollection
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
