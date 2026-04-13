<?php

namespace App\Models;

use App\Traits\HasStatusApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class MeatInspection extends Model
{
    use HasStatusApproval;

    protected $table = 'meat_inspections';
    protected $primaryKey = 'inspection_id';

    protected $fillable = [
        'establishment_id',
        'inspector_user_id',
        'inspection_date',
        'findings',
        'status',
        'compliance_status',
        'remarks',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(MeatEstablishment::class, 'establishment_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_user_id', 'id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereNotNull('approved_by');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereNull('approved_by');
    }

    public function scopePassed(Builder $query): Builder
    {
        return $query->where('status', 'passed');
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }
}