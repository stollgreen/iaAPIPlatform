<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating price groups.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\PriceGroup
 * @see \App\Http\Controllers\PriceGroupController
 */
#[OA\Schema(
    schema: "PriceGroupUpdateRequest",
    title: "PriceGroupUpdateRequest",
    description: "Validation rules for updating price groups",
    required: ["name", "description", "discount", "currency"],
    properties: [
        new OA\Property(property: "name", description: "Name of the price group", type: "string"),
        new OA\Property(property: "description", description: "Description of the price group", type: "string"),
        new OA\Property(property: "discount", description: "Discount rate for the price group", type: "string"),
        new OA\Property(property: "currency", description: "Currency of the price group", type: "string"),
    ]
)]
class PriceGroupUpdateRequest extends FormRequest
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
     * Get custom attributes for validator errors.
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
            'discount.required' => 'The :attribute is required.',
            'discount.string' => 'The :attribute must be a valid string.',
            'currency.required' => 'The :attribute is required.',
            'currency.string' => 'The :attribute must be a valid string.',
        ];
    }
}
