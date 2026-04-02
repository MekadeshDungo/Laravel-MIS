<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_type',
        'animal_id',
        'barangay_id',
        'animal_name',
        'species',
        'breed',
        'owner_name',
        'owner_contact',
        'record_date',
        'diagnosis',
        'treatment',
        'vaccine_name',
        'vaccination_date',
        'next_vaccination_date',
        'notes',
        'veterinarian_id',
        'created_by',
    ];

    protected $casts = [
        'record_date' => 'date',
        'vaccination_date' => 'date',
        'next_vaccination_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'animal_id');
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function veterinarian()
    {
        return $this->belongsTo(User::class, 'veterinarian_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}