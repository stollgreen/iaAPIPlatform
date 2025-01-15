<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating events.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Event
 * @see \App\Http\Controllers\EventController
 */
#[OA\Schema(
    schema: "EventUpdateRequest",
    title: "EventUpdateRequest",
    description: "Validation rules for updating an event.",
    required: ["name", "date", "location_id", "organizer", "budget"],
    properties: [
        new OA\Property(property: "name", description: "The name of the event", type: "string", maxLength: 255),
        new OA\Property(property: "date", description: "The date of the event, must be today or later", type: "string", format: "date"),
        new OA\Property(property: "location_id", description: "The ID of the location", type: "integer"),
        new OA\Property(property: "organizer", description: "The organizer's name", type: "string", maxLength: 255),
        new OA\Property(property: "budget", description: "The budget for the event, must be at least 0", type: "number", format: "float"),
        new OA\Property(property: "status", description: "The ID of the event status", type: "integer", nullable: true),
    ],
    type: "object"
)]
class EventUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'location_id' => ['required', 'integer', 'exists:locations,id'],
            'organizer' => ['required', 'string', 'max:255'],
            'budget' => ['required', 'numeric', 'min:0'],
            'status' => ['nullable', 'int', 'exists:event_states,id'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'event name',
            'date' => 'event date',
            'location_id' => 'event location',
            'organizer' => 'event organizer',
            'budget' => 'event budget',
            'status' => 'event status',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute is required.',
            'name.string' => 'The :attribute must be a valid string.',
            'name.max' => 'The :attribute may not be greater than 255 characters.',
            'date.required' => 'The :attribute is required.',
            'date.date' => 'The :attribute must be a valid date.',
            'date.after_or_equal' => 'The :attribute must be today or later.',
            'location_id.required' => 'The :attribute is required.',
            'location_id.integer' => 'The :attribute must be a valid integer.',
            'location_id.exists' => 'The selected :attribute is invalid.',
            'organizer.required' => 'The :attribute is required.',
            'organizer.string' => 'The :attribute must be a valid string.',
            'organizer.max' => 'The :attribute may not be greater than 255 characters.',
            'budget.required' => 'The :attribute is required.',
            'budget.numeric' => 'The :attribute must be a valid number.',
            'budget.min' => 'The :attribute must be at least 0.',
            'status.integer' => 'The :attribute must be a valid integer.',
            'status.exists' => 'The selected :attribute is invalid.',
        ];
    }
}
