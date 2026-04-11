<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    const CATEGORY_CAMPAIGN = 'campaign';
    const CATEGORY_EVENT = 'event';

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';
    const STATUS_ARCHIVED = 'archived';

    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'content',
        'attachment_path',
        'photo_path',
        'category',
        'status',
        'is_active',
        'priority',
        'publish_date',
        'expiry_date',
        'event_date',
        'event_time',
        'location',
        'contact_number',
        'created_by',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'expiry_date' => 'datetime',
        'event_date' => 'date',
        'event_time' => 'time',
        'is_active' => 'boolean',
    ];

    public static function getCategories(): array
    {
        return [
            self::CATEGORY_CAMPAIGN,
            self::CATEGORY_EVENT,
        ];
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED,
            self::STATUS_ARCHIVED,
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

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where(function ($q) {
                $q->whereNull('publish_date')
                    ->orWhere('publish_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', now());
            });
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