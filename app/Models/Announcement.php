<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    const CATEGORY_CAMPAIGN = 'campaign';
    const CATEGORY_EVENT = 'event';

    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'content',
        'attachment_path',
        'photo_path',
        'category',
        'is_active',
        'event_date',
        'event_time',
        'location',
        'contact_number',
        'created_by',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];

    public static function getCategories(): array
    {
        return [
            self::CATEGORY_CAMPAIGN,
            self::CATEGORY_EVENT,
        ];
    }

    public function scopeCampaigns($query)
    {
        return $query->where('category', self::CATEGORY_CAMPAIGN);
    }

    public function scopeEvents($query)
    {
        return $query->where('category', self::CATEGORY_EVENT);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reads(): HasMany
    {
        return $this->hasMany(AnnouncementRead::class, 'announcement_id');
    }

    public function usersRead(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'announcement_reads');
    }
}