<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating a promoter group.
 *
 * This class is responsible for validating the input data
 * and ensuring that only authorized users can make
 * the request.
 *
 * @see \App\Models\PromoterGroup
 * @see \App\Http\Controllers\PromoterGroupController
 */
#[OA\Schema(
    schema: "PromoterGroupUpdateRequest",
    title: "PromoterGroupUpdateRequest",
    description: "PromoterGroupUpdateRequest",
    required: ["name", "skills", "description", "max_members"],
    properties: [
        new OA\Property(property: "name", description: "Name of the promoter group", type: "string"),
        new OA\Property(property: "skills", description: "Skills associated with the promoter group", type: "array", items: new OA\Items(title: "PromoterGroupUpdateRequestSkillItems", type: "integer")),
        new OA\Property(property: "description", description: "Description of the promoter group", type: "string"),
        new OA\Property(property: "max_members", description: "Maximum number of members in the promoter group", type: "integer"),
    ]
)]
class PromoterGroupUpdateRequest extends FormRequest
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
            'skills' => ['required'],
            'description' => ['required', 'string'],
            'max_members' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'promoter group name',
            'skills' => 'promoter group skills',
            'description' => 'promoter group description',
            'max_members' => 'maximum group members',
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
            'skills.required' => 'The :attribute are required.',
            'description.required' => 'The :attribute is required.',
            'description.string' => 'The :attribute must be a valid string.',
            'max_members.required' => 'The :attribute field is required.',
            'max_members.integer' => 'The :attribute must be a valid integer.',
            'max_members.min' => 'The :attribute must be at least 1.',
        ];
    }
}
