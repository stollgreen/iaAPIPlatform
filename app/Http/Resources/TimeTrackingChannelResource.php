<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $active
 */
#[OA\Schema(
    schema: "TimeTrackingChannelResource",
    title: "TimeTrackingChannelResource",
    description: "Represents a time tracking channel",
    required: ["id", "name", "description", "active"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the time tracking channel", type: "integer", example: 1),
        new OA\Property(property: "name", description: "The name of the time tracking channel", type: "string", example: "Timesheet"),
        new OA\Property(property: "description", description: "The description of the time tracking channel", type: "string", example: "Timesheet"),
        new OA\Property(property: "active", description: "The active status of the time tracking channel", type: "boolean", example: true),
    ],
    type: "object",
)]
class TimeTrackingChannelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'active' => $this->active,
        ];
    }
}
