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
    schema: 'CommitmentStateResource',
    title: 'CommitmentStateResource',
    description: 'Represents a commitment state',
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the commitment', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the commitment', type: 'string'),
    ],
    type: 'object',
)]
class CommitmentStateResource extends JsonResource
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
