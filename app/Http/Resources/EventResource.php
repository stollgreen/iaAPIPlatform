<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $date
 * @property mixed $location_id
 * @property mixed $organizer
 * @property mixed $budget
 * @property mixed $status
 */
#[OA\Schema(
    schema: "EventResource",
    title: "EventResource",
    description: "Represents an event",
    required: ["id", "name", "date", "location_id"],
    properties: [
        new OA\Property(property: "id", description: "The event ID", type: "integer"),
        new OA\Property(property: "name", description: "The name of the event", type: "string"),
        new OA\Property(property: "date", description: "The date of the event", type: "string", format: "date-time"),
        new OA\Property(property: "location_id", description: "The ID of the location where the event takes place", type: "integer"),
        new OA\Property(property: "organizer", description: "The organizer of the event", type: "string"),
        new OA\Property(property: "budget", description: "The budget allocated for the event", type: "number", format: "float"),
        new OA\Property(property: "status", description: "The current status of the event", type: "string"),
        new OA\Property(property: "created_at", description: "Timestamp when the event was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the event was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date' => $this->date,
            'location_id' => $this->location_id,
            'organizer' => $this->organizer,
            'budget' => $this->budget,
            'status' => $this->status,
        ];
    }
}
