<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handles the HTTP request for storing price groups.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\PriceGroup
 * @see \App\Http\Controllers\PriceGroupController::store
 */
#[OA\Schema(
    schema: "PriceGroupStoreRequest",
    title: "PriceGroupStoreRequest",
    description: "Rules for storing price groups.",
    required: ["name", "description", "discount", "currency"],
    properties: [
        new OA\Property(property: "name", description: "The name of the price group", type: "string"),
        new OA\Property(property: "description", description: "The description of the price group", type: "string"),
        new OA\Property(property: "discount", description: "The discount for the price group", type: "string"),
        new OA\Property(property: "currency", description: "The currency identifier for the price group", type: "string"),
    ]
)]
class PriceGroupStoreRequest extends FormRequest
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
            'discount' => ['required', 'string'],
            'currency' => ['required', 'string'],
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
            'name.required' => 'The price group name is required.',
            'description.required' => 'The price group description is required.',
            'discount.required' => 'The discount is required.',
            'currency.required' => 'The currency is required.',
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
            'name' => 'price group name',
            'description' => 'price group description',
            'discount' => 'price group discount',
            'currency' => 'price group currency',
        ];
    }
}
