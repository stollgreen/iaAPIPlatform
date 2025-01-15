<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Invoice
 *
 * Represents an invoice in the system. An invoice is linked to an offer and a customer,
 * and includes details such as issue date, due date, total amount, and payment status.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the invoice.
 * @property int $offer_id The ID of the offer associated with the invoice.
 * @property int $customer_id The ID of the customer associated with the invoice.
 * @property \Illuminate\Support\Carbon $issue_date The issue date of the invoice.
 * @property \Illuminate\Support\Carbon $due_date The due date of the invoice.
 * @property float $total_amount The total amount of the invoice.
 * @property int $payment_status The status ID of the invoice payment. {@see PaymentState}
 */
class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'offer_id',
        'customer_id',
        'issue_date',
        'due_date',
        'total_amount',
        'payment_status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'offer_id' => 'integer',
        'customer_id' => 'integer',
        'issue_date' => 'date',
        'due_date' => 'date',
        'total_amount' => 'float',
        'payment_status' => 'integer',
    ];

    /**
     * The offer associated with the invoice.
     *
     * @return BelongsTo The relationship definition for the Offer model.
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * The customer associated with the invoice.
     *
     * @return BelongsTo The relationship definition for the Customer model.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The payment status of the invoice.
     *
     * @return BelongsTo The relationship definition for the PaymentState model.
     */
    public function paymentStates(): BelongsTo
    {
        return $this->belongsTo(PaymentState::class);
    }
}
