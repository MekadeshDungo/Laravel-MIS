<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Livestock extends Model
{
    protected $table = 'livestock';
    protected $primaryKey = 'livestock_id';

    protected $fillable = [
        'owner_id',
        'barangay_id',
        'species',
        'breed',
        'color',
        'gender',
        'age',
        'age_unit',
        'tag_number',
        'owner_name',
        'owner_contact',
        'address',
        'status',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'owner_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }
}
