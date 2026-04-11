<?php

namespace App\Models;

use App\Traits\Approvable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class ImpoundRecord extends Model
{
    use Approvable;

    protected $table = 'impound_records';
    protected $primaryKey = 'impound_id';

    protected $fillable = [
        'stray_report_id',
        'animal_type',
        'animal_name',
        'species',
        'breed',
        'color',
        'gender',
        'age',
        'owner_name',
        'owner_contact',
        'animal_tag_code',
        'intake_condition',
        'intake_location',
        'intake_date',
        'barangay_id',
        'current_disposition',
        'approved_by',
        'approved_at',
        'recorded_by',
    ];

    protected $casts = [
        'intake_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function strayReport(): BelongsTo
    {
        return $this->belongsTo(StrayReport::class, 'stray_report_id', 'stray_report_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ImpoundStatusHistory::class, 'impound_id', 'impound_id');
    }

    public function adoptionRequests(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'impound_id', 'impound_id');
    }

    public function scopeImpounded(Builder $query): Builder
    {
        return $query->where('current_disposition', 'impounded');
    }
}