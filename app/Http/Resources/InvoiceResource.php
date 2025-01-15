<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $payment_status
 * @property mixed $total_amount
 * @property mixed $id
 * @property mixed $offer_id
 * @property mixed $customer_id
 * @property mixed $issue_date
 * @property mixed $due_date
 */
#[OA\Schema(
    schema: 'InvoiceResource',
    title: 'InvoiceResource',
    description: 'Represents an invoice',
    required: ['id', 'offer_id', 'customer_id', 'issue_date', 'due_date', 'total_amount', 'payment_status'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the invoice', type: 'integer'),
        new OA\Property(property: 'offer_id', description: 'The ID of the associated offer', type: 'integer'),
        new OA\Property(property: 'customer_id', description: 'The ID of the customer', type: 'integer'),
        new OA\Property(property: 'issue_date', description: 'The issue date of the invoice', type: 'string', format: 'date-time'),
        new OA\Property(property: 'due_date', description: 'The due date of the invoice', type: 'string', format: 'date-time'),
        new OA\Property(property: 'total_amount', description: 'The total amount of the invoice', type: 'number', format: 'float'),
        new OA\Property(property: 'payment_status', description: 'The payment status of the invoice', type: 'string'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the invoice was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the invoice was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object',
)]
class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'offer_id' => $this->offer_id,
            'customer_id' => $this->customer_id,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'total_amount' => $this->total_amount,
            'payment_status' => $this->payment_status,
        ];
    }
}
