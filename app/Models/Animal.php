<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'animals';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'client_id',
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
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'vaccination_date' => 'date',
            'next_vaccination_date' => 'date',
            'license_expiry' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the owner (Client) of this animal.
     */
    public function owner()
    {
        return $this->belongsTo(Client::class, 'client_id', 'client_id');
    }

    /**
     * Get the user owner (for User-based ownership).
     */
    public function userOwner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the barangay associated with this animal.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    /**
     * Get vaccinations for this animal.
     */
    public function vaccinations()
    {
        return $this->hasMany(Vaccination::class);
    }

    /**
     * Get rabies cases associated with this animal.
     */
    public function rabiesCases()
    {
        return $this->hasMany(RabiesCase::class);
    }
}