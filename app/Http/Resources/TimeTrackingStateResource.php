<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 */
#[OA\Schema(
    schema: 'TimeTrackingStateResource',
    title: 'TimeTrackingStateResource',
    description: 'Represents a time tracking state',
    required: ['id', 'name', 'description'],
    properties: array(
        new OA\Property(property: 'id', description: 'The ID of the time tracking state', type: 'integer', example: 1),
        new OA\Property(property: 'name', description: 'The name of the time tracking state', type: 'string', example: 'Active'),
        new OA\Property(property: 'description', description: 'The description of the time tracking state', type: 'string', example: 'State indicating an active tracking time'),
    ),
    type: 'object',
)]
class TimeTrackingStateResource extends JsonResource
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
        ];
    }
}
