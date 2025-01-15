<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $discount
 * @property mixed $currency
 *
 * Class PriceGroupResource
 *
 * Representation of price group data as a resource for API responses.
 */
#[OA\Schema(
    schema: "PriceGroupResource",
    title: "PriceGroupResource",
    description: "Represents a price group resource",
    required: ["id", "name", "description", "discount", "currency"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the price group", type: "integer"),
        new OA\Property(property: "name", description: "The name of the price group", type: "string"),
        new OA\Property(property: "description", description: "A description of the price group", type: "string"),
        new OA\Property(property: "discount", description: "The discount applied to the price group", type: "number", format: "float"),
        new OA\Property(property: "currency", description: "The currency associated with the price group", type: "string"),
        new OA\Property(property: "created_at", description: "Timestamp when the price group was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the price group was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class PriceGroupResource extends JsonResource
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
            'description' => $this->description,
            'discount' => $this->discount,
            'currency' => $this->currency,
        ];
    }
}
