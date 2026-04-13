<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    protected $table = 'pets';
    protected $primaryKey = 'pet_id';

    protected $fillable = [
        'owner_id',
        'pet_name',
        'species',
        'breed',
        'sex',
        'age',
        'gender',
        'color',
        'weight',
        'vaccination_status',
        'vaccination_date',
        'next_vaccination_date',
        'license_number',
        'license_expiry',
        'microchip_number',
        'health_status',
        'medical_history',
        'notes',
        'pet_image',
        'birthdate',
        'body_mark_details',
        'body_mark_image',
        'is_neutered',
        'is_crossbreed',
        'training',
        'insurance',
        'behavior',
        'likes',
        'dislikes',
        'diet',
        'allergy',
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id');
    }

    public function userOwner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'owner_id', 'id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class, 'pet_id');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'pet_id');
    }
}