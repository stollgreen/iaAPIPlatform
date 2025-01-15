<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing time tracking channels.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\TimeTrackingChannel
 * @see \App\Http\Controllers\TimeTrackingChannelController::store
 */
#[OA\Schema(
    schema: "TimeTrackingChannelStoreRequest",
    title: "TimeTrackingChannelStoreRequest",
    description: "Validation rules for creating a time tracking channel.",
    required: ["name", "active"],
    properties: [
        new OA\Property(property: "name", description: "The name of the time tracking channel", type: "string"),
        new OA\Property(property: "description", description: "A short description of the time tracking channel", type: "string", nullable: true),
        new OA\Property(property: "active", description: "Whether the channel is active", type: "boolean")
    ]
)]
class TimeTrackingChannelStoreRequest extends FormRequest
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
            'active' => ['required', 'bool'],
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
            'name.string' => 'The name must be a valid string.',
            'description.string' => 'The description must be a valid string.',
            'active.required' => 'The active field is required.',
            'active.bool' => 'The active field must be true or false.',
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
            'name' => 'time tracking channel name',
            'description' => 'time tracking channel description',
            'active' => 'active status',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->input('active', false),
        ]);
    }
}
