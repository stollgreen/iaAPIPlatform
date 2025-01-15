<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $parent_area_id
 */
#[OA\Schema(
    schema: 'ServiceAreaResource',
    title: 'ServiceAreaResource',
    description: 'Represents a service area',
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the service area', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the service area', type: 'string'),
        new OA\Property(property: 'description', description: 'The description of the service area', type: 'string'),
        new OA\Property(property: 'parent_area_id', description: 'The ID of the parent service area', type: 'integer')
    ],
    type: 'object'
)]
class ServiceAreaResource extends JsonResource
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
            'parent_area_id' => $this->parent_area_id,
        ];
    }
}
