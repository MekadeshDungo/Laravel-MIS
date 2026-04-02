<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barangay extends Model
{
    protected $primaryKey = 'barangay_id';
    
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
        'created_at' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Get the stray reports for this barangay.
     */
    public function strayReports(): HasMany
    {
        return $this->hasMany(StrayReport::class, 'barangay_id', 'barangay_id');
    }
}
