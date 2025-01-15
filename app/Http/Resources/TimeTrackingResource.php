<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $employee_id
 * @property mixed $commitment_id
 * @property mixed $time_tracking_channel_id
 * @property mixed $time_tracking_state_id
 * @property mixed $start_time
 * @property mixed $end_time
 */
#[OA\Schema(
    schema: 'TimeTrackingResource',
    title: 'TimeTrackingResource',
    description: 'Represents a time tracking resource',
    required: ['id', 'employee_id', 'commitment_id', 'time_tracking_channel_id', 'time_tracking_state_id', 'start_time', 'end_time'],
    properties: array(
        new OA\Property(property: 'id', description: 'The time tracking record ID', type: 'integer', example: 1),
        new OA\Property(property: 'employee_id', description: 'The ID of the employee', type: 'integer', example: 1),
        new OA\Property(property: 'commitment_id', description: 'The ID of the related commitment', type: 'integer', example: 1),
        new OA\Property(property: 'time_tracking_channel_id', description: 'The ID of the tracking channel used', type: 'integer', example: 2),
        new OA\Property(property: 'time_tracking_state_id', description: 'The state ID of the time entry', type: 'integer', example: 1),
        new OA\Property(property: 'start_time', description: 'Time tracking start time', type: 'string', format: 'date-time'),
        new OA\Property(property: 'end_time', description: 'Time tracking end time', type: 'string', format: 'date-time'),
    ),
    type: 'object',
)]
class TimeTrackingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'employee' => $this->employee,
            'commitment_id' => $this->commitment_id,
            'commitment' => $this->commitment,
            'time_tracking_channel_id' => $this->time_tracking_channel_id,
            'time_tracking_channel' => $this->timeTrackingChannel,
            'start_time' => Carbon::parse($this->start_time)->format('Y-m-d H:i:s'),
            'end_time' => Carbon::parse($this->end_time)?->format('Y-m-d H:i:s'),
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
            'time_tracking_state_id' => $this->time_tracking_state_id,
            'status' => $this->timeTrackingState,
        ];
    }
}
