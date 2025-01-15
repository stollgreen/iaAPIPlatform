<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $status
 * @property mixed $end_time
 * @property mixed $start_time
 * @property mixed $role
 * @property mixed $event_id
 * @property mixed $promoter_id
 * @property mixed $id
 * @property BelongsTo $state
 * @property BelongsTo $promoter
 * @property BelongsTo $event
 *
 */
#[OA\Schema(
    schema: 'CommitmentResource',
    title: 'CommitmentResource',
    description: 'Represents a commitment',
    required: ['id', 'promoter_id', 'event_id', 'role', 'start_time', 'end_time', 'status'],
    properties: array(
        new OA\Property(property: 'id', description: 'The commitment ID', type: 'integer', example: 1),
        new OA\Property(property: 'promoter_id', description: 'The ID of the promoter', type: 'integer', example: 1),
        new OA\Property(property: 'promoter', ref: '#/components/schemas/PromoterResource'),
        new OA\Property(property: 'event_id', description: 'The ID of the event', type: 'integer', example: 1),
        new OA\Property(property: 'event', ref: '#/components/schemas/EventResource'),
        new OA\Property(property: 'role', description: 'The role assigned in the commitment', type: 'string'),
        new OA\Property(property: 'start_time', description: 'The start time of the commitment', type: 'string', format: 'date-time'),
        new OA\Property(property: 'end_time', description: 'The end time of the commitment', type: 'string', format: 'date-time'),
        new OA\Property(property: 'status', description: 'The current status of the commitment', type: 'number', example: 1),
        new OA\Property(property: 'state', ref: '#/components/schemas/CommitmentStateResource'),
    ),
    type: 'object',
)]

class CommitmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'promoter_id' => $this->promoter_id,
            'promoter' => $this->promoter,
            'event_id' => $this->event_id,
            'event' => $this->event,
            'role' => $this->role,
            'start_time' => $this->start_time->format('Y-m-d H:i:s'),
            'end_time' => $this->end_time->format('Y-m-d H:i:s'),
            'status' => $this->state,
        ];
    }
}
