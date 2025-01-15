<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Class OfferStoreRequest
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Offer
 * @see \App\Http\Controllers\OfferController::store
 */
#[OA\Schema(
    schema: "OfferStoreRequest",
    title: "OfferStoreRequest",
    description: "Validation rules for creating an offer.",
    required: ["event_id", "customer_id", "description", "total_price"],
    properties: [
        new OA\Property(property: "event_id", description: "The ID of the event", type: "integer"),
        new OA\Property(property: "customer_id", description: "The ID of the customer", type: "integer"),
        new OA\Property(property: "description", description: "Description of the offer", type: "string"),
        new OA\Property(property: "total_price", description: "Total price of the offer", type: "number", format: "float"),
        new OA\Property(property: "status", description: "Status of the offer", type: "string", nullable: true),
    ]
)]
class OfferStoreRequest extends FormRequest
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
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'event_id.exists' => 'The selected event does not exist.',
            'customer_id.exists' => 'The selected customer does not exist.',
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
            'event_id' => 'event ID',
            'customer_id' => 'customer ID',
            'description' => 'offer description',
            'total_price' => 'total price',
        ];
    }
}
