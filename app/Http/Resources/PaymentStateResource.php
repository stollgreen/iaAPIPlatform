<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 *
 * Class PaymentStateResource
 *
 * Representation of payment state data as a resource for API responses.
 */
#[OA\Schema(
    schema: "PaymentStateResource",
    title: "PaymentStateResource",
    description: "Represents a payment state resource",
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the payment state", type: "integer"),
        new OA\Property(property: "name", description: "The name of the payment state", type: "string"),
        new OA\Property(property: "created_at", description: "Timestamp when the payment state was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the payment state was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class PaymentStateResource extends JsonResource
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
        ];
    }
}
