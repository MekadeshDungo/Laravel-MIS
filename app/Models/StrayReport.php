<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StrayReport extends Model
{
    protected $primaryKey = 'stray_report_id';

    protected $fillable = [
        'barangay_id',
        'reported_by_user_id',
        'report_type',
        'species',
        'description',
        'location_text',
        'street_address',
        'landmark',
        'photo_path',
        'urgency_level',
        'report_status',
        'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get the barangay this report belongs to.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get the user who reported.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }

    /**
     * Get the impound record for this report.
     */
    public function impoundRecord(): HasOne
    {
        return $this->hasOne(ImpoundRecord::class, 'stray_report_id', 'stray_report_id');
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->report_status) {
            'new' => 'bg-danger',
            'validated' => 'bg-info',
            'responding' => 'bg-warning',
            'closed' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * Get urgency badge color.
     */
    public function getUrgencyBadgeColor(): string
    {
        return match($this->urgency_level) {
            'low' => 'bg-success',
            'medium' => 'bg-warning',
            'high' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
