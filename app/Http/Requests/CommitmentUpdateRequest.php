<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating commitments.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Commitment
 * @see \App\Http\Controllers\CommitmentController
 */
#[OA\Schema(
    schema: "CommitmentUpdateRequest",
    title: "CommitmentUpdateRequest",
    description: "Validation rules for updating a commitment.",
    required: ["promoter_id", "event_id", "role", "start_time", "end_time"],
    properties: [
        new OA\Property(property: "promoter_id", description: "ID of the promoter", type: "integer", example: '1'),
        new OA\Property(property: "event_id", description: "ID of the event", type: "integer", example: '1'),
        new OA\Property(property: "role", description: "Role assigned to the commitment", type: "string", example: "Rollenname"),
        new OA\Property(property: "start_time", description: "Start time of the commitment", type: "string", format: "date-time", example: "2021-01-01T00:00:00+00:00"),
        new OA\Property(property: "end_time", description: "End time of the commitment", type: "string", format: "date-time", example: "2021-01-01T00:00:00+00:00"),
        new OA\Property(property: "status", description: "Status of the commitment", type: "integer", example: 1, nullable: true),
    ]
)]
class CommitmentUpdateRequest extends FormRequest
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
            'promoter_id' => ['required', 'integer', 'exists:promoters,id'],
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'role' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date', 'before:end_time'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'status' => ['nullable', 'integer', 'exists:commitment_states,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'promoter_id' => 'promoter ID',
            'event_id' => 'event ID',
            'role' => 'role',
            'start_time' => 'start time',
            'end_time' => 'end time',
            'status' => 'status',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'promoter_id.required' => 'The :attribute is required.',
            'promoter_id.integer' => 'The :attribute must be a valid number.',
            'promoter_id.exists' => 'The :attribute does not exist in the system.',
            'event_id.required' => 'The :attribute is required.',
            'event_id.integer' => 'The :attribute must be a valid number.',
            'event_id.exists' => 'The :attribute does not exist in the system.',
            'role.required' => 'The :attribute is required.',
            'role.string' => 'The :attribute must be a valid string.',
            'role.max' => 'The :attribute must not be more than 255 characters.',
            'start_time.required' => 'The :attribute is required.',
            'start_time.date' => 'The :attribute must be a valid date.',
            'start_time.before' => 'The :attribute must be before the end time.',
            'end_time.required' => 'The :attribute is required.',
            'end_time.date' => 'The :attribute must be a valid date.',
            'end_time.after' => 'The :attribute must be after the start time.',
            'status.string' => 'The :attribute must be a valid string.',
            'status.exists' => 'The :attribute must exist in the commitment states.',
        ];
    }
}
