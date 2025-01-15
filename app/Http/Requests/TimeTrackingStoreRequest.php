<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing time tracking entries.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\TimeTracking
 * @see \App\Http\Controllers\TimeTrackingController::store
 */
#[OA\Schema(
    schema: "TimeTrackingStoreRequest",
    title: "TimeTrackingStoreRequest",
    description: "Validation rules for creating a time tracking entry.",
    required: ["employee_id", "commitment_id", "time_tracking_channel_id", "time_tracking_state_id", "start_time", "end_time"],
    properties: [
        new OA\Property(property: "employee_id", description: "The ID of the employee", type: "integer"),
        new OA\Property(property: "commitment_id", description: "The ID of the commitment", type: "integer"),
        new OA\Property(property: "time_tracking_channel_id", description: "The ID of the time tracking channel", type: "integer"),
        new OA\Property(property: "time_tracking_state_id", description: "The ID of the time tracking state", type: "integer"),
        new OA\Property(property: "start_time", description: "The start time of the tracking (in datetime format)", type: "string", format: "datetime"),
        new OA\Property(property: "end_time", description: "The end time of the tracking (in datetime format)", type: "string", format: "datetime"),
    ]
)]
class TimeTrackingStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'employee_id.required' => 'The employee ID is required.',
            'commitment_id.required' => 'The commitment ID is required.',
            'time_tracking_channel_id.required' => 'The time tracking channel ID is required.',
            'time_tracking_state_id.required' => 'The time tracking state ID is required.',
            'start_time.required' => 'The start time is required.',
            'start_time.datetime' => 'The start time must be a valid datetime.',
            'end_time.required' => 'The end time is required.',
            'end_time.datetime' => 'The end time must be a valid datetime.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
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
}
