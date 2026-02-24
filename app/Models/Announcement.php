<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'photo_path',
        'event_date',
        'event_time',
        'location',
        'contact_number',
        'organized_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'event_date' => 'date',
    ];

    /**
     * Get the user that created the announcement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get users who have read this announcement.
     */
    public function reads(): HasMany
    {
        return $this->hasMany(AnnouncementRead::class, 'announcement_id');
    }

    /**
     * Get the linked service forms.
     */
    public function serviceForms(): BelongsToMany
    {
        return $this->belongsToMany(ServiceForm::class, 'announcement_forms', 'announcement_id', 'form_id')
            ->withTimestamps();
    }

    /**
     * Get the photo URL.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        if ($this->photo_path) {
            return asset('storage/' . $this->photo_path);
        }
        return null;
    }
}
