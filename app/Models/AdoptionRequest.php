<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdoptionRequest extends Model
{
    protected $primaryKey = 'adoption_request_id';

    protected $fillable = [
        'impound_id',
        'adopter_name',
        'adopter_contact',
        'address',
        'request_status',
        'requested_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get the impound record this adoption belongs to.
     */
    public function impound(): BelongsTo
    {
        return $this->belongsTo(ImpoundRecord::class, 'impound_id', 'impound_id');
    }

    /**
     * Get the status history for this adoption.
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(AdoptionStatusHistory::class, 'adoption_request_id', 'adoption_request_id');
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->request_status) {
            'pending' => 'bg-warning',
            'approved' => 'bg-info',
            'rejected' => 'bg-danger',
            'completed' => 'bg-success',
            default => 'bg-secondary',
        };
    }
}
