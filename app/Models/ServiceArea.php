<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ServiceArea
 *
 * Represents a service area in the system. A service area can have a name, description,
 * and a parent area to establish a hierarchy.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the service area.
 * @property string $name The name of the service area.
 * @property string|null $description A description of the service area.
 * @property int|null $parent_area_id The ID of the parent service area.
 */
class ServiceArea extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'description',
        'parent_area_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'parent_area_id' => 'integer',
    ];

    /**
     * The parent service area.
     *
     * @return BelongsTo The relationship definition for the parent ServiceArea model.
     */
    public function parentArea(): BelongsTo
    {
        return $this->belongsTo(ServiceArea::class, 'parent_area_id');
    }
}
