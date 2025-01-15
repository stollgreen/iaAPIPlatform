<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 */
#[OA\Schema(
    schema: 'GenderResource',
    title: 'GenderResource',
    description: 'Represents a gender',
    required: ['id', 'name'],
    properties: [
        new OA\Property(property: 'id', description: 'The gender ID', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the gender', type: 'string'),
    ],
    type: 'object',
)]
class GenderResource extends JsonResource
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
