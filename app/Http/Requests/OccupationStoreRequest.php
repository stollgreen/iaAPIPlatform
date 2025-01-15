<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles validation for storing new occupations.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Occupation
 * @see \App\Http\Controllers\OccupationController::store
 */
#[OA\Schema(
    schema: "OccupationStoreRequest",
    title: "OccupationStoreRequest",
    description: "Request body for storing new occupations",
    required: ["name", "description", "required_skills", "hourly_rate"],
    properties: [
        new OA\Property(property: "name", description: "The name of the occupation", type: "string"),
        new OA\Property(property: "description", description: "Detailed description of the occupation", type: "string"),
        new OA\Property(property: "required_skills", description: "Skills needed for the occupation", type: "string"),
        new OA\Property(property: "hourly_rate", description: "Hourly rate for the occupation", type: "number", format: "float"),
        new OA\Property(property: "event", description: "Optional event associated with the occupation", type: "integer", nullable: true),
    ]
)]
class OccupationStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The occupation name is required.',
            'description.required' => 'The description is required.',
            'required_skills.required' => 'The skills field is required.',
            'hourly_rate.required' => 'The hourly rate is required.',
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
            'required_skills' => 'skills',
            'hourly_rate' => 'hourly rate',
            'event' => 'linked event',
        ];
    }
}
