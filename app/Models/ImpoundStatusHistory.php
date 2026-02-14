<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImpoundStatusHistory extends Model
{
    protected $primaryKey = 'impound_status_id';

    protected $fillable = [
        'impound_id',
        'status',
        'remarks',
        'updated_by_user_id',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    /**
     * Get the impound record this history belongs to.
     */
    public function impound(): BelongsTo
    {
        return $this->belongsTo(ImpoundRecord::class, 'impound_id', 'impound_id');
    }

    /**
     * Get the user who updated this status.
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_user_id');
    }
}
