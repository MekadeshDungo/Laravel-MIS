<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RabiesVaccinationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clinic_name',
        'patient_name',
        'patient_contact',
        'patient_address',
        'pet_name',
        'pet_species',
        'pet_breed',
        'pet_age',
        'pet_gender',
        'pet_color',
        'vaccine_brand',
        'vaccine_batch_number',
        'vaccination_date',
        'vaccination_time',
        'next_vaccination_date',
        'weight',
        'vaccination_type',
        'observations',
        'status',
        'notes',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
        'vaccination_time' => 'time',
        'next_vaccination_date' => 'date',
        'pet_age' => 'integer',
        'weight' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
