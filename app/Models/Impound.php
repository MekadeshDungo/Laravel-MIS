<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Impound extends Model
{
    protected $table = 'impounds';
    protected $primaryKey = 'impound_id';

    protected $fillable = [
        'pet_id',
        'stray_report_id',
        'animal_tag_code',
        'intake_condition',
        'intake_date',
        'intake_location',
        'impound_reason',
        'captured_by_user_id',
        'current_disposition',
        'status',
        'release_date',
    ];

    protected $casts = [
        'intake_date' => 'date',
        'release_date' => 'date',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function strayReport(): BelongsTo
    {
        return $this->belongsTo(StrayReport::class, 'stray_report_id', 'stray_report_id');
    }

    public function capturedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'captured_by_user_id', 'id');
    }
}