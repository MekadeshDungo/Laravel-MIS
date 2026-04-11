<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AdoptionTrait extends Model
{
    use HasFactory;

    protected $table = 'traits';

    protected $fillable = [
        'name',
    ];

    public function adoptionPets(): BelongsToMany
    {
        return $this->belongsToMany(AdoptionPet::class, 'pet_traits')
            ->withTimestamps();
    }
}