<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing commitments.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\CommitmentState
 * @see \App\Http\Controllers\CommitmentStateController::store
 */
#[OA\Schema(
    schema: "CommitmentStateStoreRequest",
    title: "CommitmentStateStoreRequest",
    description: "Validation rules for creating a commitment state.",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "Name of the state", type: "string"),

    ]
)]
class CommitmentStateStoreRequest extends FormRequest
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
            'name' => 'commitment state name',
        ];
    }
}
