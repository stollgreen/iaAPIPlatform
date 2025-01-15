<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing skills.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Skill
 * @see \App\Http\Controllers\SkillController
 */
#[OA\Schema(
    schema: "SkillStoreRequest",
    title: "SkillStoreRequest",
    description: "Validation rules for storing skills",
    required: ["name", "description", "category", "required_certification"],
    properties: [
        new OA\Property(property: "name", description: "The name of the skill", type: "string"),
        new OA\Property(property: "description", description: "The description of the skill", type: "string"),
        new OA\Property(property: "category", description: "The category of the skill", type: "string"),
        new OA\Property(property: "required_certification", description: "The required certification for the skill", type: "string"),
    ]
)]
class SkillStoreRequest extends FormRequest
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
            'category' => ['required', 'string'],
            'required_certification' => ['required', 'string'],
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
            'name.required' => 'The skill name is required.',
            'description.required' => 'The skill description is required.',
            'category.required' => 'The skill category is required.',
            'required_certification.required' => 'The required certification is mandatory.',
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
            'name' => 'skill name',
            'description' => 'skill description',
            'category' => 'skill category',
            'required_certification' => 'required certification',
        ];
    }
}
