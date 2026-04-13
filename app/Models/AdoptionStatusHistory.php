<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdoptionStatusHistory extends Model
{
    protected $primaryKey = 'adoption_status_id';

    protected $fillable = [
        'adoption_request_id',
        'status',
        'remarks',
        'updated_by_user_id',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    /**
     * Get the adoption request this history belongs to.
     */
    public function adoptionRequest(): BelongsTo
    {
        return $this->belongsTo(AdoptionRequest::class, 'adoption_request_id', 'adoption_request_id');
    }

    /**
     * Get the user who updated this status.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
}
