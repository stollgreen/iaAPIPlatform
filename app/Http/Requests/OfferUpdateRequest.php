<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating an offer.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Offer
 * @see \App\Http\Controllers\OfferController
 */
#[OA\Schema(
    schema: "OfferUpdateRequest",
    title: "OfferUpdateRequest",
    description: "Validation rules for updating an offer.",
    required: ["event_id", "customer_id", "description", "total_price"],
    properties: [
        new OA\Property(property: "event_id", description: "The ID of the related event", type: "integer"),
        new OA\Property(property: "customer_id", description: "The ID of the related customer", type: "integer"),
        new OA\Property(property: "description", description: "The description of the offer", type: "string"),
        new OA\Property(property: "total_price", description: "The total price of the offer", type: "number", format: "float"),
        new OA\Property(property: "status", description: "The current status of the offer", type: "string", nullable: true),
    ],
    type: "object"
)]
class OfferUpdateRequest extends FormRequest
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
            'event_id' => ['required', 'integer', 'exists:events,id'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'description' => ['required', 'string'],
            'total_price' => ['required', 'numeric'],
            'status' => ['nullable', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'event_id' => 'event ID',
            'customer_id' => 'customer ID',
            'description' => 'offer description',
            'total_price' => 'total price',
            'status' => 'offer status',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'event_id.required' => 'The :attribute is required.',
            'event_id.integer' => 'The :attribute must be a valid integer.',
            'event_id.exists' => 'The selected :attribute does not exist.',
            'customer_id.required' => 'The :attribute is required.',
            'customer_id.integer' => 'The :attribute must be a valid integer.',
            'customer_id.exists' => 'The selected :attribute does not exist.',
            'description.required' => 'The :attribute field is required.',
            'description.string' => 'The :attribute must be a valid string.',
            'total_price.required' => 'The :attribute field is required.',
            'total_price.numeric' => 'The :attribute must be a valid number.',
            'status.string' => 'The :attribute must be a valid string.',
        ];
    }
}
