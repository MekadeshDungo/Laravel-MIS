<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    protected $table = 'pets';
    protected $primaryKey = 'pet_id';
    public $timestamps = false;

    protected $fillable = [
        'owner_id',
        'barangay_id',
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
        'source_module',
        'source_module_id',
        'is_approved',
        'consolidated_at',
        'pet_status',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'is_approved' => 'boolean',
        'consolidated_at' => 'datetime',
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

    public function missingReport(): HasMany
    {
        return $this->hasMany(MissingReport::class, 'pet_id');
    }

    public function traits(): BelongsToMany
    {
        return $this->belongsToMany(AdoptionTrait::class, 'pet_traits', 'pet_id', 'trait_id')
            ->withTimestamps();
    }
}