<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class PaymentState
 *
 * Represents the state of a payment in the system. Each payment state
 * is identified by a unique name.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the payment state.
 * @property string $name The name of the payment state.
 */
class PaymentState extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
    ];
}
