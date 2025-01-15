<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $description
 * @property mixed $category
 * @property mixed $required_certification
 * @property mixed $related_occupations
 */
#[OA\Schema(
    schema: 'SkillResource',
    title: 'SkillResource',
    description: 'Represents a skill',
    required: ['id', 'name', 'category'],
    properties: [
        new OA\Property(property: 'id', description: 'The skill ID', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the skill', type: 'string'),
        new OA\Property(property: 'description', description: 'The description of the skill', type: 'string'),
        new OA\Property(property: 'category', description: 'The category of the skill', type: 'string'),
        new OA\Property(property: 'required_certification', description: 'The required certification for the skill', type: 'string'),
        new OA\Property(property: 'related_occupations', description: 'List of related occupations', type: 'array', items: new OA\Items(ref: '#/components/schemas/OccupationResource')),
        new OA\Property(property: 'created_at', description: 'Timestamp when the skill was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the skill was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
class SkillResource extends JsonResource
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
            'category' => $this->category,
            'required_certification' => $this->required_certification,
            'related_occupations' => $this->related_occupations,
        ];
    }
}
