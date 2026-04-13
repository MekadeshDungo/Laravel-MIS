<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PetTrait extends Model
{
    use HasFactory;

    protected $fillable = [
        'adoption_id',
        'trait_id',
    ];

    public function adoptionPet(): BelongsTo
    {
        return $this->belongsTo(AdoptionPet::class, 'adoption_id');
    }

    public function trait(): BelongsTo
    {
        return $this->belongsTo(AdoptionTrait::class, 'trait_id');
    }
}