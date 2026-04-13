<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccination extends Model
{
    protected $table = 'vaccinations';

    protected $fillable = [
        'pet_id',
        'vaccinated_by',
        'vaccine_type',
        'vaccination_date',
        'next_vaccination_date',
        'batch_number',
        'veterinarian',
        'notes',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
        'next_vaccination_date' => 'date',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function vaccinatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vaccinated_by', 'id');
    }

    public function veterinarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vaccinated_by', 'id');
    }
}