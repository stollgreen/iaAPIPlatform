<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating time tracking entries.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\TimeTracking
 * @see \App\Http\Controllers\TimeTrackingController
 */
#[OA\Schema(
    schema: "TimeTrackingUpdateRequest",
    title: "TimeTrackingUpdateRequest",
    description: "Validation rules for updating a time tracking entry.",
    required: ["employee_id", "commitment_id", "time_tracking_channel_id", "time_tracking_state_id", "start_time", "end_time"],
    properties: [
        new OA\Property(property: "employee_id", description: "ID of the employee", type: "integer", example: 1),
        new OA\Property(property: "commitment_id", description: "ID of the commitment", type: "integer", example: 1),
        new OA\Property(property: "time_tracking_channel_id", description: "ID of the time tracking channel", type: "integer", example: 1),
        new OA\Property(property: "time_tracking_state_id", description: "ID of the time tracking state", type: "integer", example: 1),
        new OA\Property(property: "start_time", description: "Start time of the time tracking entry", type: "string", format: "date-time", example: "2021-01-01T00:00:00+00:00"),
        new OA\Property(property: "end_time", description: "End time of the time tracking entry", type: "string", format: "date-time", example: "2021-01-01T01:00:00+00:00"),
    ]
)]
class TimeTrackingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'commitment_id' => ['required', 'integer', 'exists:commitments,id'],
            'time_tracking_channel_id' => ['required', 'integer', 'exists:time_tracking_channels,id'],
            'time_tracking_state_id' => ['required', 'integer', 'exists:time_tracking_states,id'],
            'start_time' => ['required', 'date', 'before:end_time'],
            'end_time' => ['required', 'date', 'after:start_time'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'employee_id' => 'employee ID',
            'commitment_id' => 'commitment ID',
            'time_tracking_channel_id' => 'time tracking channel ID',
            'time_tracking_state_id' => 'time tracking state ID',
            'start_time' => 'start time',
            'end_time' => 'end time',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'employee_id.required' => 'The :attribute is required.',
            'employee_id.integer' => 'The :attribute must be a valid number.',
            'employee_id.exists' => 'The :attribute does not exist in the system.',
            'commitment_id.required' => 'The :attribute is required.',
            'commitment_id.integer' => 'The :attribute must be a valid number.',
            'commitment_id.exists' => 'The :attribute does not exist in the system.',
            'time_tracking_channel_id.integer' => 'The :attribute must be a valid number.',
            'time_tracking_channel_id.exists' => 'The :attribute does not exist in the system.',
            'time_tracking_state_id.required' => 'The :attribute is required.',
            'time_tracking_state_id.integer' => 'The :attribute must be a valid number.',
            'time_tracking_state_id.exists' => 'The :attribute does not exist in the system.',
            'start_time.required' => 'The :attribute is required.',
            'start_time.date' => 'The :attribute must be a valid date.',
            'start_time.before' => 'The :attribute must be before the end time.',
            'end_time.required' => 'The :attribute is required.',
            'end_time.date' => 'The :attribute must be a valid date.',
            'end_time.after' => 'The :attribute must be after the start time.',
        ];
    }
}
