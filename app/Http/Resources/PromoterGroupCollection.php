<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Attributes as OA;

/**
 * Represents a collection of promoter group resources.
 *
 * This schema definition specifies the structure for the "PromoterGroupCollection".
 * It includes a "data" property which is an array of PromoterGroupResource items.
 */
#[OA\Schema(
    schema: "PromoterGroupCollection",
    title: "PromoterGroupCollection",
    description: "A collection of promoter group resources.",
    properties: array(
        new OA\Property(
            property: "data",
            description: "Array of promoter group resources",
            type: "array",
            items: new OA\Items(ref: "#/components/schemas/PromoterGroupResource")
        ),
    ),
    type: "object"
)]
class PromoterGroupCollection extends ResourceCollection
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
