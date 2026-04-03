<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    // New field types for the enhanced announcement module
    public const TYPE_VACCINATION = 'Vaccination Program';
    public const TYPE_RABIES_ALERT = 'Rabies Alert';
    public const TYPE_LIVESTOCK = 'Livestock Advisory';
    public const TYPE_MEAT_INSPECTION = 'Meat Inspection Notice';
    public const TYPE_GENERAL = 'General Announcement';

    public const AUDIENCE_PUBLIC = 'Public';
    public const AUDIENCE_PET_OWNERS = 'Pet Owners';
    public const AUDIENCE_FARMERS = 'Farmers / Livestock Owners';
    public const AUDIENCE_INTERNAL = 'Internal Staff';

    public const PRIORITY_NORMAL = 'Normal';
    public const PRIORITY_IMPORTANT = 'Important';
    public const PRIORITY_URGENT = 'Urgent';

    public const STATUS_DRAFT = 'Draft';
    public const STATUS_PUBLISHED = 'Published';
    public const STATUS_ARCHIVED = 'Archived';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'audience',
        'priority',
        'status',
        'publish_date',
        'expiry_date',
        'body',
        'image_path',
        'attachment_path',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'publish_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    /**
     * Get available types.
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_VACCINATION,
            self::TYPE_RABIES_ALERT,
            self::TYPE_LIVESTOCK,
            self::TYPE_MEAT_INSPECTION,
            self::TYPE_GENERAL,
        ];
    }

    /**
     * Get available audiences.
     */
    public static function getAudiences(): array
    {
        return [
            self::AUDIENCE_PUBLIC,
            self::AUDIENCE_PET_OWNERS,
            self::AUDIENCE_FARMERS,
            self::AUDIENCE_INTERNAL,
        ];
    }

    /**
     * Get available priorities.
     */
    public static function getPriorities(): array
    {
        return [
            self::PRIORITY_NORMAL,
            self::PRIORITY_IMPORTANT,
            self::PRIORITY_URGENT,
        ];
    }

    /**
     * Get available statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT,
            self::STATUS_PUBLISHED,
            self::STATUS_ARCHIVED,
        ];
    }

    /**
     * Scope to get only published announcements visible to public.
     * Logic: status = Published AND current date >= publish_date AND (expiry_date is null OR current date <= expiry_date)
     */
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

    /**
     * Scope to order by priority (urgent first).
     */
    public function scopeOrderedByPriority($query)
    {
        return $query->orderByRaw(
            "CASE priority 
                WHEN 'Urgent' THEN 1 
                WHEN 'Important' THEN 2 
                ELSE 3 END"
        );
    }

    /**
     * Get the user that created the announcement.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
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
     * Get the image URL.
     */
    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }

    /**
     * Get the attachment URL.
     */
    public function getAttachmentUrlAttribute(): ?string
    {
        if ($this->attachment_path) {
            return asset('storage/' . $this->attachment_path);
        }
        return null;
    }

    /**
     * Check if announcement is currently visible (published and within date range).
     */
    public function isVisible(): bool
    {
        if ($this->status !== self::STATUS_PUBLISHED) {
            return false;
        }

        $now = now();
        
        // Check publish_date
        if ($this->publish_date && $this->publish_date > $now) {
            return false;
        }

        // Check expiry_date
        if ($this->expiry_date && $this->expiry_date < $now) {
            return false;
        }

        return true;
    }

    /**
     * Check if user can edit/delete this announcement.
     */
    public function canEdit(User $user): bool
    {
        // Admin roles can edit
        if (in_array($user->role, ['super_admin', 'city_vet', 'admin_staff'])) {
            return true;
        }
        
        // Creator can edit their own announcements
        return $this->user_id === $user->id;
    }

    /**
     * Get priority badge color class.
     */
    public function getPriorityBadgeClass(): string
    {
        return match($this->priority) {
            self::PRIORITY_URGENT => 'bg-danger text-white',
            self::PRIORITY_IMPORTANT => 'bg-warning text-dark',
            default => 'bg-secondary text-white',
        };
    }

    /**
     * Get status badge color class.
     */
    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            self::STATUS_PUBLISHED => 'bg-success text-white',
            self::STATUS_DRAFT => 'bg-secondary text-white',
            self::STATUS_ARCHIVED => 'bg-dark text-white',
            default => 'bg-secondary text-white',
        };
    }
}
