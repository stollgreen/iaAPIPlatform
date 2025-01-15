<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing payment states.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\PaymentState
 * @see \App\Http\Controllers\PaymentStateController::store
 */
#[OA\Schema(
    schema: "PaymentStateStoreRequest",
    title: "PaymentStateStoreRequest",
    description: "Rules for storing payment states.",
    required: ["name"],
    properties: [
        new OA\Property(property: "name", description: "Name of the payment state", type: "string"),
    ]
)]
class PaymentStateStoreRequest extends FormRequest
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
            'name.required' => 'The name of the payment state is required.',
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
            'name' => 'payment state name',
        ];
    }
}
