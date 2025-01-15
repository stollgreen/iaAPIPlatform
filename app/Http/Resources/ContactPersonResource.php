<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $location_id
 * @property mixed $role
 */
#[OA\Schema(
    schema: 'ContactPersonResource',
    title: 'ContactPersonResource',
    description: 'Represents a contact person',
    required: ['id', 'name', 'email', 'phone', 'location_id', 'role'],
    properties: [
        new OA\Property(property: 'id', description: 'The unique identifier of the contact person', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the contact person', type: 'string'),
        new OA\Property(property: 'email', description: 'The email address of the contact person', type: 'string', format: 'email'),
        new OA\Property(property: 'phone', description: 'The phone number of the contact person', type: 'string'),
        new OA\Property(property: 'location_id', description: 'The location associated with the contact person', type: 'integer'),
        new OA\Property(property: 'role', description: 'The role of the contact person', type: 'string'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the contact person was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the contact person was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object',
)]
class ContactPersonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'location_id' => $this->location_id,
            'role' => $this->role,
        ];
    }
}
