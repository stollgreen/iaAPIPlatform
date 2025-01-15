<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $skills
 * @property mixed $description
 * @property mixed $max_members
 *
 */
#[OA\Schema(
    schema: "PromoterGroupResource",
    title: "PromoterGroupResource",
    description: "Represents a promoter group resource",
    required: ["id", "name", "skills", "description", "max_members"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the promoter group", type: "integer"),
        new OA\Property(property: "name", description: "The name of the promoter group", type: "string"),
        new OA\Property(property: "skills", description: "The skills required for the promoter group", type: "array", items: new OA\Items(type: "string")),
        new OA\Property(property: "description", description: "The description of the promoter group", type: "string"),
        new OA\Property(property: "max_members", description: "The maximum number of members in the group", type: "integer"),
        new OA\Property(property: "created_at", description: "Timestamp when the promoter group was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the promoter group was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class PromoterGroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'skills' => $this->skills,
            'description' => $this->description,
            'max_members' => $this->max_members,
        ];
    }
}
