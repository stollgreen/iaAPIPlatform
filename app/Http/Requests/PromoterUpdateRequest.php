<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating a promoter.
 *
 * This class is responsible for validating the input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Promoter
 * @see \App\Http\Controllers\PromoterController
 */
#[OA\Schema(
    schema: "PromoterUpdateRequest",
    title: "PromoterUpdateRequest",
    description: "Validation rules for updating promoters",
    required: ["employee_id", "promoter_group_id", "name", "email", "phone", "skills", "certifications", "availability"],
    properties: [
        new OA\Property(property: "employee_id", description: "ID of the employee", type: "integer"),
        new OA\Property(property: "promoter_group_id", description: "ID of the promoter group", type: "integer"),
        new OA\Property(property: "name", description: "Name of the promoter", type: "string"),
        new OA\Property(property: "email", description: "Email address of the promoter", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "Contact phone number of the promoter", type: "string"),
        new OA\Property(property: "skills", description: "Skills of the promoter", type: "string"),
        new OA\Property(property: "certifications", description: "Certifications of the promoter", type: "string"),
        new OA\Property(property: "availability", description: "Availability of the promoter", type: "string"),
    ]
)]
class PromoterUpdateRequest extends FormRequest
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
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'promoter_group_id' => ['required', 'integer', 'exists:promoter_groups,id'],
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:promoters,email'],
            'phone' => ['required', 'string'],
            'skills' => ['required', 'string'],
            'certifications' => ['required', 'string'],
            'availability' => ['required', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'employee_id' => 'employee ID',
            'promoter_group_id' => 'promoter group ID',
            'name' => 'promoter name',
            'email' => 'email address',
            'phone' => 'phone number',
            'skills' => 'promoter skills',
            'certifications' => 'promoter certifications',
            'availability' => 'promoter availability',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'employee_id.required' => 'The :attribute is required.',
            'employee_id.exists' => 'The selected :attribute does not exist.',
            'promoter_group_id.required' => 'The :attribute is required.',
            'promoter_group_id.exists' => 'The selected :attribute does not exist.',
            'name.required' => 'The :attribute is required.',
            'email.required' => 'The :attribute is required.',
            'email.email' => 'The :attribute must be a valid email address.',
            'email.unique' => 'The :attribute is already in use.',
            'phone.required' => 'The :attribute is required.',
            'skills.required' => 'The :attribute are required.',
            'certifications.required' => 'The :attribute are required.',
            'availability.required' => 'The :attribute is required.',
        ];
    }
}
