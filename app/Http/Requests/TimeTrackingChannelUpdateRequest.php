<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating time tracking channels.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\TimeTrackingChannel
 * @see \App\Http\Controllers\TimeTrackingController
 */
#[OA\Schema(
    schema: "TimeTrackingChannelUpdateRequest",
    title: "TimeTrackingChannelUpdateRequest",
    description: "Validation rules for updating a time tracking channel.",
    required: ["name", "active"],
    properties: [
        new OA\Property(property: "name", description: "The name of the time tracking channel", type: "string", example: "Channel Name"),
        new OA\Property(property: "description", description: "The description of the time tracking channel", type: "string", example: "A description of the channel", nullable: true),
        new OA\Property(property: "active", description: "The active status of the time tracking channel", type: "boolean", example: true),
    ]
)]
class TimeTrackingChannelUpdateRequest extends FormRequest
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'active' => $this->input('active', false),
        ]);
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'channel name',
            'description' => 'channel description',
            'active' => 'active status',
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
            'active.required' => 'The :attribute is required.',
            'active.bool' => 'The :attribute must be true or false.',
        ];
    }
}
