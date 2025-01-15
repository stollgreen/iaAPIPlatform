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
    schema: 'DepartmentResource',
    title: 'DepartmentResource',
    description: 'Represents a department',
    required: ['id', 'name'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the department', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the department', type: 'string'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the department was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the department was last updated', type: 'string', format: 'date-time')
    ],
    type: 'object',
)]
class DepartmentResource extends JsonResource
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
