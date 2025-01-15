<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $required_skills
 * @property mixed $hourly_rate
 * @property mixed $event
 *
 * Class OccupationResource
 *
 * Representation of occupation data as a resource for API responses.
 */
#[OA\Schema(
    schema: "OccupationResource",
    title: "Occupation",
    description: "An occupation is a job that can be filled by a volunteer.",
    required: ["id", "name", "description", "hourly_rate"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the occupation", type: "integer"),
        new OA\Property(property: "name", description: "The name of the occupation", type: "string"),
        new OA\Property(property: "description", description: "A description of the occupation", type: "string"),
        new OA\Property(property: "required_skills", description: "A list of required skills", type: "array", items: new OA\Items(type: "string")),
        new OA\Property(property: "hourly_rate", description: "The hourly rate for the occupation", type: "number", format: "float"),
        new OA\Property(property: "event", ref: "#/components/schemas/EventResource", description: "The associated event", type: "object"),
        new OA\Property(property: "created_at", description: "Timestamp when the occupation was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the occupation was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class OccupationResource extends JsonResource
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
            'required_skills' => $this->required_skills,
            'hourly_rate' => $this->hourly_rate,
            'event' => $this->event,
        ];
    }
}
