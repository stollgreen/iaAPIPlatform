<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating event states.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\EventState
 * @see \App\Http\Controllers\EventStateController
 */
#[OA\Schema(
    schema: "EventStateUpdateRequest",
    title: "EventStateUpdateRequest",
    description: "EventStateUpdateRequest",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "The name of the event state", type: "string", maxLength: 255),
    ]
)]
class EventStateUpdateRequest extends FormRequest
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
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'event state name',
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
        ];
    }
}
