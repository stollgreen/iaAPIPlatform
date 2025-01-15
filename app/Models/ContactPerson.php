<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ContactPerson
 *
 * Represents a contact person related to a location with details such as name, email,
 * phone, and role.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the contact person.
 * @property string $name The name of the contact person.
 * @property string $email The email address of the contact person.
 * @property string|null $phone The phone number of the contact person.
 * @property int $location_id The ID of the associated location.
 * @property string|null $role The role or position of the contact person.
 */
class ContactPerson extends Model
{
    use HasFactory;

    /**
     * The name of the table associated with the model.
     *
     * @var string $table
     */
    protected $table = 'contact_persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'location_id',
        'role',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'location_id' => 'integer',
    ];

    /**
     * The location associated with this contact person.
     *
     * @return BelongsTo The relationship definition for the Location model.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }
}
