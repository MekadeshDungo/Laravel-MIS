<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissingReport extends Model
{
    protected $table = 'missing_reports';
    protected $primaryKey = 'id';

    protected $fillable = [
        'pet_id',
        'last_seen_date',
        'last_seen_location',
        'contact_info',
        'source_missing_id',
    ];

    protected $casts = [
        'last_seen_date' => 'date',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }
}