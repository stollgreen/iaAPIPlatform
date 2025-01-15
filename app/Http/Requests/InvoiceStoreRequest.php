<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;


/**
 * Handles the HTTP request for storing invoices.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Invoice
 * @see \App\Http\Controllers\InvoiceController::store
 */
#[OA\Schema(
    schema: "InvoiceStoreRequest",
    title: "InvoideStoreRequest",
    description: "Request body for storing invoices",
    required: ["offer_id", "customer_id", "issue_date", "due_date", "total_amount", "payment_status"],
    properties: [
        new OA\Property(property: "offer_id", description: "ID of the associated offer", type: "integer"),
        new OA\Property(property: "customer_id", description: "ID of the customer", type: "integer"),
        new OA\Property(property: "issue_date", description: "Issue date of the invoice", type: "string", format: "date"),
        new OA\Property(property: "due_date", description: "Due date of the invoice", type: "string", format: "date"),
        new OA\Property(property: "total_amount", description: "Total amount of the invoice", type: "number", format: "float"),
        new OA\Property(property: "payment_status", description: "Payment status of the invoice", type: "integer"),
    ]
)]
class InvoiceStoreRequest extends FormRequest
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
            'offer_id' => ['required', 'integer', 'exists:offers,id'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'issue_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
            'total_amount' => ['required', 'numeric'],
            'payment_status' => ['required', 'numeric', 'exists:payment_states,id'],
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
            'offer_id.exists' => 'The selected offer does not exist.',
            'customer_id.exists' => 'The selected customer does not exist.',
            'payment_status.required' => 'The payment status is required.',
            'payment_status.string' => 'The payment status must be a string.',
            'payment_status.in' => 'The payment status must be one of the following: paid, unpaid.',
            'total_amount.required' => 'The total amount is required.',
            'total_amount.numeric' => 'The total amount must be a number.',

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
            'offer_id' => 'offer ID',
            'customer_id' => 'customer ID',
            'issue_date' => 'issue date',
            'due_date' => 'due date',
            'total_amount' => 'total amount',
            'payment_status' => 'payment status',
        ];
    }
}
