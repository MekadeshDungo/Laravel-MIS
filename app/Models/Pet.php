<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'species',
        'breed',
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
        'photo_url',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'age' => 'string',
        'weight' => 'float',
        'vaccination_date' => 'datetime',
        'next_vaccination_date' => 'datetime',
        'license_expiry' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the owner of the pet.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the medical history for the pet.
     *
     * NOTE: This relationship requires PetMedicalRecord model to be created.
     *       For now, medical records are stored in the health_status and
     *       medical_history fields of the Pet model.
     */
    public function medicalHistory()
    {
        // @todo Implement with PetMedicalRecord model when created
        // Temporarily returning empty collection to prevent errors
        return $this->morphMany(\Illuminate\Database\Eloquent\Model::class, 'pet');
    }

    /**
     * Get the vaccinations for the pet.
     *
     * NOTE: This relationship requires Vaccination model to be created.
     *       Vaccination records are currently tracked via the
     *       vaccination_status, vaccination_date, and next_vaccination_date fields.
     */
    public function vaccinations()
    {
        // @todo Implement with Vaccination model when created
        // Temporarily returning empty collection to prevent errors
        return $this->morphMany(\Illuminate\Database\Eloquent\Model::class, 'pet');
    }

    /**
     * Scope a query to filter by species.
     */
    public function scopeSpecies($query, string $species)
    {
        return $query->where('species', $species);
    }

    /**
     * Scope a query to filter by owner.
     */
    public function scopeOwner($query, string $ownerId)
    {
        return $query->where('owner_id', $ownerId);
    }

    /**
     * Scope a query for vaccinated pets.
     */
    public function scopeVaccinated($query)
    {
        return $query->where('vaccination_status', 'vaccinated');
    }
}
