<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * Class EventStateResource
 *
 * Represents event state data as a resource.
 * @property mixed $name
 * @property mixed $id
 */
#[OA\Schema(
    schema: "EventStateResource",
    title: "EventStateResource",
    description: "Represents a event state resource",
    required: ["id", "name"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the event state", type: "integer"),
        new OA\Property(property: "name", description: "The name of the event state", type: "string"),
        new OA\Property(property: "created_at", description: "Timestamp when the event state was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the event state was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class EventStateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
