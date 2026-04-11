<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barangay extends Model
{
    protected $primaryKey = 'barangay_id';
    protected $table = 'barangays';

    protected $fillable = [
        'barangay_name',
        'city',
        'province',
        'latitude',
        'longitude',
        'contact_number',
        'office_email',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime',
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class, 'barangay_id', 'barangay_id');
    }

    public function biteRabiesReports(): HasMany
    {
        return $this->hasMany(BiteRabiesReport::class, 'barangay_id', 'barangay_id');
    }

    public function livestock(): HasMany
    {
        return $this->hasMany(Livestock::class, 'barangay_id', 'barangay_id');
    }

    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class, 'barangay_id', 'barangay_id');
    }

    public function strayReports(): HasMany
    {
        return $this->hasMany(StrayReport::class, 'barangay_id', 'barangay_id');
    }

    public function livestockCensuses(): HasMany
    {
        return $this->hasMany(LivestockCensus::class, 'barangay_id', 'barangay_id');
    }

    public function clinicalActions(): HasMany
    {
        return $this->hasMany(ClinicalAction::class, 'barangay_id', 'barangay_id');
    }
}
