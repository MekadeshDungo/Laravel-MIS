<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vaccination extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'vaccinations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
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
        ];
    }

    /**
     * Get the pet that was vaccinated.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    /**
     * Get the user who administered the vaccination.
     */
    public function vaccinatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vaccinated_by');
    }
}
