<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing offer states.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\OfferState
 * @see \App\Http\Controllers\OfferStateController::store
 */
#[OA\Schema(
    schema: "OfferStateStoreRequest",
    title: "OfferStateStoreRequest",
    description: "Validation rules for storing offer states",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "Name of the offer state", type: "string"),
    ]
)]
class OfferStateStoreRequest extends FormRequest
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
            'name' => 'offer state name',
        ];
    }
}
