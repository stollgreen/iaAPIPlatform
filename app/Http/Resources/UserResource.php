<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 *
 * Class UserResource
 *
 * Representation of user data as a resource for API responses.
 */
#[OA\Schema(
    schema: "UserResource",
    title: "UserResource",
    description: "Represents a user resource",
    required: ["id", "name", "email"],
    properties: [
        new OA\Property(property: "id", description: "The ID of the user", type: "integer"),
        new OA\Property(property: "name", description: "The name of the user", type: "string"),
        new OA\Property(property: "email", description: "The email of the user", type: "string", format: "email"),
        new OA\Property(property: "created_at", description: "Timestamp when the user was created", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", description: "Timestamp when the user was last updated", type: "string", format: "date-time"),
    ],
    type: "object"
)]
class UserResource extends JsonResource
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
            'email' => $this->email,
        ];
    }
}
