<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 *
 * Class OfferStateResource
 *
 * Representation of offer state data as a resource for API responses.
 */
#[OA\Schema(
    schema: "OfferStateResource",
    title: "OfferStateResource",
    description: "Represents a offer state resource",
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the offer state", type: "integer"),
        new OA\Property(property: "name", description: "The name of the offer state", type: "string"),
        new OA\Property(property: "created_at", description: "Timestamp when the offer state was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the offer state was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class OfferStateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'offers' => $this->whenExistsLoaded('offers')
        ];
    }
}
