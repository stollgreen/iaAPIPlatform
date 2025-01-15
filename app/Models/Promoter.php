<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Promoter
 *
 * Represents a promoter in the system. A promoter is an employee with additional
 * roles and responsibilities, often associated with a promoter group and having specific skills.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the promoter.
 * @property int $employee_id The ID of the associated employee.
 * @property int $promoter_group_id The ID of the group the promoter belongs to.
 * @property string $name The name of the promoter.
 * @property string $email The email address of the promoter.
 * @property string|null $phone The phone number of the promoter.
 * @property string|null $skills The skills of the promoter.
 * @property string|null $certifications The certifications the promoter holds.
 * @property string|null $availability The availability of the promoter.
 */
class Promoter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'employee_id',
        'promoter_group_id',
        'name',
        'email',
        'phone',
        'skills',
        'certifications',
        'availability',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'skill' => 'array',
        'employee_id' => 'integer',
        'promoter_group_id' => 'integer',
    ];

    /**
     * The employee associated with this promoter.
     *
     * @return BelongsTo The relationship definition for the Employee model.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * The promoter group this promoter belongs to.
     *
     * @return BelongsTo The relationship definition for the PromoterGroup model.
     */
    public function promoterGroup(): BelongsTo
    {
        return $this->belongsTo(PromoterGroup::class, 'id', 'id');
    }

    /**
     * The Commitments of the Promoter
     *
     * @returns HasMany
     */
    public function commitments(): HasMany
    {
        return $this->hasMany(Commitment::class, 'promoter_id', 'id')->with('state');
    }
}
