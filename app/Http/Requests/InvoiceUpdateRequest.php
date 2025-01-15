<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

/**
 * Handle the HTTP request for updating invoices.
 *
 * This class is responsible for validating input data
 * and ensuring that only authorized users can make the request.
 *
 * @see \App\Models\Invoice
 * @see \App\Http\Controllers\InvoiceController
 */
#[OA\Schema(
    schema: "InvoiceUpdateRequest",
    title: "InvoiceUpdateRequest",
    description: "Request body for updating invoices",
    required: ["offer_id", "customer_id", "issue_date", "due_date", "total_amount", "payment_status"],
    properties: [
        new OA\Property(property: "offer_id", description: "ID of the related offer", type: "integer"),
        new OA\Property(property: "customer_id", description: "ID of the customer", type: "integer"),
        new OA\Property(property: "issue_date", description: "The issue date of the invoice", type: "string", format: "date"),
        new OA\Property(property: "due_date", description: "The due date for payment", type: "string", format: "date"),
        new OA\Property(property: "total_amount", description: "The total amount of the invoice", type: "number"),
        new OA\Property(property: "payment_status", description: "Payment status of the invoice", type: "int"),
    ]
)]
class InvoiceUpdateRequest extends FormRequest
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
     * Get custom attributes for validator errors.
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

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'offer_id.required' => 'The :attribute is required.',
            'offer_id.integer' => 'The :attribute must be a valid integer.',
            'offer_id.exists' => 'The selected :attribute does not exist.',
            'customer_id.required' => 'The :attribute is required.',
            'customer_id.integer' => 'The :attribute must be a valid integer.',
            'customer_id.exists' => 'The selected :attribute does not exist.',
            'issue_date.required' => 'The :attribute is required.',
            'issue_date.date' => 'The :attribute must be a valid date.',
            'due_date.required' => 'The :attribute is required.',
            'due_date.date' => 'The :attribute must be a valid date.',
            'total_amount.required' => 'The :attribute is required.',
            'total_amount.numeric' => 'The :attribute must be a valid number.',
            'payment_status.required' => 'The :attribute is required.',
        ];
    }
}
