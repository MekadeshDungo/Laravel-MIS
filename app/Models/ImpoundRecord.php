<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImpoundRecord extends Model
{
    protected $primaryKey = 'impound_id';

    protected $fillable = [
        'stray_report_id',
        'animal_tag_code',
        'intake_condition',
        'intake_location',
        'intake_date',
        'current_disposition',
    ];

    protected $casts = [
        'intake_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get the stray report this impound belongs to.
     */
    public function strayReport(): BelongsTo
    {
        return $this->belongsTo(StrayReport::class, 'stray_report_id', 'stray_report_id');
    }

    /**
     * Get the status history for this impound.
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(ImpoundStatusHistory::class, 'impound_id', 'impound_id');
    }

    /**
     * Get adoption requests for this impound.
     */
    public function adoptionRequests(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'impound_id', 'impound_id');
    }

    /**
     * Get disposition badge color.
     */
    public function getDispositionBadgeColor(): string
    {
        return match($this->current_disposition) {
            'impounded' => 'bg-warning',
            'claimed' => 'bg-success',
            'adopted' => 'bg-info',
            'transferred' => 'bg-secondary',
            'euthanized' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
