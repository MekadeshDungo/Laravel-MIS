<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facility extends Model
{
    protected $fillable = [
        'name',
        'type',
        'barangay_id',
    ];

    protected $casts = [
        'barangay_id' => 'integer',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'facility_id');
    }

    public static function getTypes(): array
    {
        return [
            'abc' => 'ABC (Animal Bite Center)',
            'clinic' => 'Veterinary Clinic',
            'hospital' => 'Veterinary Hospital',
        ];
    }
}