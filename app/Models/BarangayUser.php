<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangayUser extends Model
{
    protected $primaryKey = 'barangay_user_id';

    protected $fillable = [
        'barangay_id',
        'user_id',
        'position_title',
        'access_level',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Get the barangay this user belongs to.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get the user account.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get notifications for this barangay user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'barangay_user_id', 'barangay_user_id');
    }

    /**
     * Get unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }
}
