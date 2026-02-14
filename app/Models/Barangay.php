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
        'contact_number',
        'office_email',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the barangay users for this barangay.
     */
    public function barangayUsers(): HasMany
    {
        return $this->hasMany(BarangayUser::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get the stray reports for this barangay.
     */
    public function strayReports(): HasMany
    {
        return $this->hasMany(StrayReport::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get active barangay users.
     */
    public function activeUsers()
    {
        return $this->barangayUsers()->where('status', 'active');
    }
}
