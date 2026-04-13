<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'device_type',
        'device_name',
        'is_active',
        'last_used_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
    ];

    /**
     * Get the user that owns the device token.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active tokens.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include web tokens.
     */
    public function scopeWeb($query)
    {
        return $query->where('device_type', 'web');
    }

    /**
     * Scope a query to only include mobile tokens.
     */
    public function scopeMobile($query)
    {
        return $query->whereIn('device_type', ['android', 'ios']);
    }

    /**
     * Update the last_used_at timestamp.
     */
    public function touchUsage()
    {
        $this->update(['last_used_at' => now()]);
    }
}
