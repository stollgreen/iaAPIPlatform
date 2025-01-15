<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating time tracking states.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\TimeTrackingState
 * @see \App\Http\Controllers\TimeTrackingStateController
 */
#[OA\Schema(
    schema: "TimeTrackingStateUpdateRequest",
    title: "TimeTrackingStateUpdateRequest",
    description: "Validation rules for updating a time tracking state.",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "The name of the time tracking state", type: "string", example: "In Progress"),
        new OA\Property(property: "description", description: "Description of the time tracking state", type: "string", example: "State description", nullable: true),
    ]
)]
class TimeTrackingStateUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'time tracking state name',
            'description' => 'time tracking state description',
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
            'description.string' => 'The :attribute must be a valid string.',
        ];
    }
}
