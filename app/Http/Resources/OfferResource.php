<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $event_id
 * @property mixed $customer_id
 * @property mixed $description
 * @property mixed $total_price
 * @property mixed $status
 *
 * Class OfferResource
 *
 * Representation of offer data as a resource for API responses.
 */
#[OA\Schema(
    schema: "OfferResource",
    title: "OfferResource",
    description: "Represents an offer.",
    required: ["id", "event_id", "customer_id", "description", "total_price", "status"],
    properties: [
        new OA\Property(property: "id", description: "The offer ID", type: "integer"),
        new OA\Property(property: "event_id", description: "The ID of the associated event", type: "integer"),
        new OA\Property(property: "customer_id", description: "The ID of the associated customer", type: "integer"),
        new OA\Property(property: "description", description: "The description of the offer", type: "string"),
        new OA\Property(property: "total_price", description: "The total price of the offer", type: "number", format: "float"),
        new OA\Property(property: "status", description: "The current status of the offer", type: "string"),
        new OA\Property(property: "created_at", description: "Timestamp when the offer was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the offer was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class OfferResource extends JsonResource
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
            'event_id' => $this->event_id,
            'customer_id' => $this->customer_id,
            'description' => $this->description,
            'total_price' => $this->total_price,
            'status' => $this->status,
        ];
    }
}
