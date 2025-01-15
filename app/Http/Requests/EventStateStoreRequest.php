<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing event states.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\EventState
 * @see \App\Http\Controllers\EventStateController::store
 */
#[OA\Schema(
    schema: "EventStateStoreRequest",
    title: "EventStateStoreRequest",
    description: "Validation rules for creating an event state.",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "The name of the event state", type: "string", maxLength: 255)
    ],
    type: "object"
)]
class EventStateStoreRequest extends FormRequest
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
            'name.required' => 'The name of the event state is required.',
            'name.max' => 'The name of the event state must not exceed 255 characters.',
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
            'name' => 'event state name',
        ];
    }
}
