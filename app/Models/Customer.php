<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Customer
 *
 * Represents a customer entity in the system. A customer may have associated events, invoices,
 * or offers in the system. Includes basic details like name, contact information, and address.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the customer.
 * @property string $name The full name of the customer.
 * @property string|null $company_name The name of the customer's company (if applicable).
 * @property string $email The email address of the customer.
 * @property string|null $phone The phone number of the customer (optional).
 * @property string|null $address_line_1 The primary address line of the customer.
 * @property string|null $address_line_2 The secondary address line of the customer (optional).
 * @property string|null $post_code The postal code for the customer's address.
 * @property string|null $city The city in which the customer resides.
 * @property int|null $country The ID of the customer's country.
 * @property string|null $vat_number The VAT identification number of the customer (if applicable).
 */
class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'company_name',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'post_code',
        'city',
        'country',
        'vat_number',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'country' => 'integer',
    ];

    /**
     * The country associated with the customer.
     *
     * @return BelongsTo The relationship definition for the Country model.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
