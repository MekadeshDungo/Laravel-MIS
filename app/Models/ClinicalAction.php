<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicalAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_type',
        'animal_id',
        'barangay_id',
        'animal_name',
        'species',
        'owner_name',
        'owner_contact',
        'action_date',
        'description',
        'diagnosis',
        'treatment_given',
        'medication',
        'follow_up_date',
        'outcome',
        'veterinarian_id',
        'created_by',
    ];

    protected $casts = [
        'action_date' => 'date',
        'follow_up_date' => 'date',
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

    public const ACTION_TYPES = [
        'surgery' => 'Surgery',
        'treatment' => 'Treatment',
        'checkup' => 'Check-up',
        'emergency' => 'Emergency',
        'dental' => 'Dental Care',
        'grooming' => 'Grooming',
        'other' => 'Other',
    ];

    public const OUTCOMES = [
        'completed' => 'Completed',
        'ongoing' => 'Ongoing',
        'referred' => 'Referred',
        'died' => 'Died/Euthanized',
        'released' => 'Released',
    ];
}