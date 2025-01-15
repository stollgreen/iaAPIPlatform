<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Offer
 *
 * Represents a business offer in the system. An offer is linked to an event and
 * a customer, containing details such as description, total price, and status.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the offer.
 * @property int $event_id The ID of the related event. {@see Event}
 * @property int $customer_id The ID of the customer receiving the offer. {@see Customer}
 * @property string|null $description Additional details about the offer.
 * @property float $total_price The total price of the offer.
 * @property int $status The status ID of the offer. {@see OfferState}
 */
class Offer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'event_id',
        'customer_id',
        'description',
        'total_price',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'event_id' => 'integer',
        'customer_id' => 'integer',
        'total_price' => 'float',
        'status' => 'integer',
    ];

    /**
     * The event associated with this offer.
     *
     * @return BelongsTo The relationship definition for the Event model.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * The customer associated with this offer.
     *
     * @return BelongsTo The relationship definition for the Customer model.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The status of this offer.
     *
     * @return BelongsTo The relationship definition for the OfferState model.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OfferState::class, 'status', 'id');
    }
}
