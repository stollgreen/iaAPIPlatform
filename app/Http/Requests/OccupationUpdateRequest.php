<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating occupations.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Occupation
 * @see \App\Http\Controllers\OccupationController
 */
#[OA\Schema(
    schema: "OccupationUpdateRequest",
    title: "OccupationUpdateRequest",
    description: "Request body for updating occupations",
    required: ["name", "description", "required_skills", "hourly_rate"],
    properties: [
        new OA\Property(property: "name", description: "The name of the occupation", type: "string"),
        new OA\Property(property: "description", description: "A brief description of the occupation", type: "string"),
        new OA\Property(property: "required_skills", description: "Skills required for the occupation", type: "string"),
        new OA\Property(property: "hourly_rate", description: "The hourly rate for the occupation", type: "number", format: "float"),
        new OA\Property(property: "event", description: "The ID of the associated event (nullable)", type: "integer", nullable: true),
    ]
)]
class OccupationUpdateRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'required_skills' => ['required', 'string'],
            'hourly_rate' => ['required', 'numeric'],
            'event' => ['nullable', 'integer'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'occupation name',
            'description' => 'occupation description',
            'required_skills' => 'required skills',
            'hourly_rate' => 'hourly rate',
            'event' => 'event ID',
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
            'description.required' => 'The :attribute is required.',
            'description.string' => 'The :attribute must be a valid string.',
            'required_skills.required' => 'The :attribute are required.',
            'required_skills.string' => 'The :attribute must be a valid string.',
            'hourly_rate.required' => 'The :attribute is required.',
            'hourly_rate.numeric' => 'The :attribute must be a valid number.',
            'event.integer' => 'The :attribute must be a valid integer.',
        ];
    }
}
