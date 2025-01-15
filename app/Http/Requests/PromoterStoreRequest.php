<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;


/**
 * Handles the HTTP request for storing promoters.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Promoter
 * @see \App\Http\Controllers\PromoterController::store
 */
#[OA\Schema(
    schema: "PromoterStoreRequest",
    title: "PromoterStoreRequest",
    description: "Validation rules for storing promoters",
    required: ["employee_id", "promoter_group_id", "name", "email", "phone", "skills", "certifications", "availability"],
    properties: [
        new OA\Property(property: "employee_id", description: "ID of the employee", type: "integer"),
        new OA\Property(property: "promoter_group_id", description: "ID of the promoter group", type: "integer"),
        new OA\Property(property: "name", description: "Name of the promoter", type: "string"),
        new OA\Property(property: "email", description: "Email of the promoter", type: "string", format: "email"),
        new OA\Property(property: "phone", description: "Phone number of the promoter", type: "string"),
        new OA\Property(property: "skills", description: "Skills of the promoter", type: "string"),
        new OA\Property(property: "certifications", description: "Certifications of the promoter", type: "string"),
        new OA\Property(property: "availability", description: "Availability of the promoter", type: "string"),
    ]
)]
class PromoterStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'employee_id.exists' => 'The employee does not exist.',
            'promoter_group_id.exists' => 'The promoter group does not exist.',
            'email.unique' => 'The email is already in use.',
            'phone.required' => 'The phone is required.',
            'skills.required' => 'The skills are required.',
            'certifications.required' => 'The certifications are required.',
            'availability.required' => 'The availability is required.',
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
            'employee_id' => 'employee ID',
            'promoter_group_id' => 'promoter group ID',
            'name' => 'name',
            'email' => 'email address',
            'phone' => 'phone number',
            'skills' => 'skills',
            'certifications' => 'certifications',
            'availability' => 'availability',
        ];
    }
}
