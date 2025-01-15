<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing time tracking states.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\TimeTrackingState
 * @see \App\Http\Controllers\TimeTrackingStateController::store
 */
#[OA\Schema(
    schema: "TimeTrackingStateStoreRequest",
    title: "TimeTrackingStateStoreRequest",
    description: "Validation rules for creating a time tracking state.",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "Name of the time tracking state", type: "string"),
        new OA\Property(property: "description", description: "Description of the time tracking state", type: "string", nullable: true)
    ]
)]
class TimeTrackingStateStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The :attribute must be a valid string.',
            'description.string' => 'The :attribute must be a valid string.',
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
            'name' => 'time tracking state name',
            'description' => 'time tracking state description',
        ];
    }
}
