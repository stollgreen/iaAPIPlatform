<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class EventStoreRequest
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Event
 * @see \App\Http\Controllers\EventController::store
 */
#[OA\Schema(
    schema: "EventStoreRequest",
    title: "EventStoreRequest",
    description: "Validation rules for creating an event.",
    required: ["name", "date", "location_id", "organizer", "budget"],
    properties: [
        new OA\Property(property: "name", description: "The name of the event", type: "string", maxLength: 255),
        new OA\Property(property: "date", description: "The date of the event, must be today or later", type: "string", format: "date"),
        new OA\Property(property: "location_id", description: "The ID of the location", type: "integer"),
        new OA\Property(property: "organizer", description: "The organizer's name", type: "string", maxLength: 255),
        new OA\Property(property: "budget", description: "The budget for the event, must be at least 0", type: "number", format: "float"),
        new OA\Property(property: "status", description: "The ID of the event status", type: "integer", nullable: true)
    ],
    type: "object"
)]
class EventStoreRequest extends FormRequest
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
            'status' => ['nullable', 'integer', 'exists:event_states,id'],
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
            'name.required' => 'The event name is required.',
            'date.after_or_equal' => 'The event date must be today or in the future.',
            'location_id.exists' => 'The selected location does not exist.',
            'budget.min' => 'The budget must be at least 0.',
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
            'location_id' => 'location ID',
            'organizer' => 'organizer name',
            'budget' => 'event budget',
        ];
    }
}