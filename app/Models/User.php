<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\PetOwner;
use Spatie\Permission\Traits\HasRoles;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable, Authorizable
{
    use Authenticatable, Notifiable, HasRoles;

    protected $guard_name = 'web';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'password',
        'barangay_id',
        'facility_id',
        'contact_number',
        'address',
        'status',
        // OTP fields
        'otp_code',
        'otp_expires_at',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
        'otp_expires_at',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name (accessor for backward compatibility).
     */
    public function getNameAttribute(): string
    {
        $parts = array_filter([
            $this->first_name,
            $this->middle_name,
            $this->last_name
        ]);
        return implode(' ', $parts);
    }

    /**
     * Set the user's full name (mutator for backward compatibility).
     * Parses the name and splits into first_name, middle_name, last_name.
     */
    public function setNameAttribute($value): void
    {
        if (empty($value)) {
            $this->attributes['first_name'] = null;
            $this->attributes['middle_name'] = null;
            $this->attributes['last_name'] = null;
            return;
        }

        $parts = explode(' ', trim($value));
        $count = count($parts);

        if ($count === 1) {
            $this->attributes['first_name'] = $parts[0];
            $this->attributes['middle_name'] = null;
            $this->attributes['last_name'] = null;
        } elseif ($count === 2) {
            $this->attributes['first_name'] = $parts[0];
            $this->attributes['middle_name'] = null;
            $this->attributes['last_name'] = $parts[1];
        } else {
            $this->attributes['first_name'] = $parts[0];
            $this->attributes['middle_name'] = $parts[1];
            $this->attributes['last_name'] = implode(' ', array_slice($parts, 2));
        }
    }

    /**
     * Get the barangay this user is assigned to.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get the facility this user is assigned to.
     */
    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }

    public function setOtpCodeAttribute($value): void
    {
        $this->attributes['otp_code'] = $value ? bcrypt($value) : $value;
    }

    public function verifyOtp(string $otp): bool
    {
        if (!$this->otp_code || !$this->otp_expires_at) {
            return false;
        }

        if (Carbon::now()->gt($this->otp_expires_at)) {
            return false;
        }

        return Hash::check($otp, $this->otp_code);
    }

    /**
     * Get the user's device tokens for push notifications.
     */
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
    }

    /**
     * Get the pet owner profile for this user.
     */
    public function petOwner()
    {
        return $this->hasOne(PetOwner::class, 'user_id');
    }

    /**
     * Get the unique identifier for the user.
     */
    public function getAuthIdentifier(): mixed
    {
        return $this->getKey();
    }

    /**
     * Get the name of the unique identifier for the user.
     */
    public function getAuthIdentifierName(): string
    {
        return $this->getKeyName();
    }

    /**
     * Get the password for the user.
     */
    public function getAuthPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the column name for the password.
     */
    public function getAuthPasswordName(): string
    {
        return 'password';
    }

    /**
     * Get the remember token for the user.
     */
    public function getRememberToken(): ?string
    {
        return $this->{$this->getRememberTokenName()};
    }

    /**
     * Get the name of the remember token column.
     */
    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }

    /**
     * Set the remember token for the user.
     */
    public function setRememberToken($value): void
    {
        $this->{$this->getRememberTokenName()} = $value;
    }

    /**
     * Check if the user has a given ability.
     * Implements Authorizable interface for Laravel Gate compatibility.
     */
    public function can($ability, $arguments = [])
    {
        return $this->checkPermissionTo($ability);
    }

    // Role constants - Clean Role Structure for Vet MIS (7 roles)
    public const ROLE_SUPER_ADMIN = 'super_admin';          // IT Personnel
    public const ROLE_CITY_VET = 'city_vet';               // City Veterinarian (Admin/Office Head)
    public const ROLE_ADMIN_STAFF = 'admin_staff';         // Administrative Assistant IV (Book Binder 4)
    public const ROLE_ADMIN_ASST = 'admin_asst';           // Administrative Assistant (Gatekeeper)
    public const ROLE_ASSISTANT_VET = 'assistant_vet';     // Assistant Veterinarian (Vet 3)
    public const ROLE_CLINIC = 'clinic';                   // External Vet Clinic
    public const ROLE_HOSPITAL = 'hospital';                // External Vet Hospital
    public const ROLE_LIVESTOCK_INSPECTOR = 'livestock_inspector'; // Livestock Inspector (Book Binder 1)
    public const ROLE_MEAT_INSPECTOR = 'meat_inspector';     // Meat & Post-Abattoir Inspector
    public const ROLE_RECORDS_STAFF = 'records_staff';       // Records Management
    public const ROLE_CITY_POUND = 'city_pound';             // City Pound Personnel
    public const ROLE_CITIZEN = 'citizen';                  // Pet owner/citizen portal

    /**
     * Check if user is a super admin (System Administrator).
     * Uses Spatie hasRole() for permission checking.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if user is an administrator (City Veterinarian / Admin).
     * Uses Spatie hasRole() for permission checking.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('city_vet') || $this->hasRole('super_admin');
    }

    /**
     * Check if user is a City Veterinarian.
     * Uses Spatie hasRole() for permission checking.
     */
    public function isCityVet(): bool
    {
        return $this->hasRole('city_vet');
    }

    /**
     * Check if user is a records staff.
     * Uses Spatie hasRole() for permission checking.
     */
    public function isRecordsStaff(): bool
    {
        return $this->hasRole('records_staff');
    }

    /**
     * Check if user is a barangay encoder.
     * Uses Spatie hasRole() for permission checking.
     */
    public function isBarangayEncoder(): bool
    {
        return $this->hasRole('barangay_encoder');
    }

    /**
     * Check if user is a meat inspector.
     * Uses Spatie hasRole() for permission checking.
     */
    public function isMeatInspector(): bool
    {
        return $this->hasRole('meat_inspector');
    }

    /**
     * Check if user is assistant vet (includes former inventory staff and city pound roles).
     * Uses Spatie hasRole() for permission checking.
     */
    public function isAssistantVet(): bool
    {
        return $this->hasRole('assistant_vet');
    }

    /**
     * Check if user is admin assistant (gatekeeper).
     * Uses Spatie hasRole() for permission checking.
     */
    public function isAdminAsst(): bool
    {
        return $this->hasRole('admin_asst');
    }

    /**
     * Check if user is a citizen.
     * Uses Spatie hasRole() for permission checking.
     */
    public function isCitizen(): bool
    {
        return $this->hasRole('citizen');
    }

    /**
     * Get effective role.
     * Returns the first Spatie role assigned to the user.
     */
    public function getEffectiveRole(): string
    {
        $roles = $this->getRoleNames();
        return $roles->first() ?? 'viewer';
    }

    /**
     * Get the user's role (from Spatie, for backward compatibility).
     * Returns the primary role name from Spatie roles.
     */
    public function getRoleAttribute(): string
    {
        return $this->getEffectiveRole();
    }

    /**
     * Check if user is admin with barangay access.
     */
    public function isAdminWithBarangayAccess(): bool
    {
        return $this->hasAnyRole([self::ROLE_CITY_VET, self::ROLE_SUPER_ADMIN, self::ROLE_ADMIN_STAFF]);
    }

    /**
     * Check if user is admin with clinic access.
     */
    public function isAdminWithClinicAccess(): bool
    {
        return $this->hasAnyRole([self::ROLE_CITY_VET, self::ROLE_SUPER_ADMIN, self::ROLE_ASSISTANT_VET]);
    }

    /**
     * Get role display name.
     */
    public function getRoleDisplayName(): string
    {
        return match($this->getRoleAttribute()) {
            self::ROLE_SUPER_ADMIN => 'Super Administrator (IT)',
            self::ROLE_CITY_VET => 'City Veterinarian (Admin/Office Head)',
            self::ROLE_ADMIN_STAFF => 'Administrative Assistant IV',
            self::ROLE_ADMIN_ASST => 'Admin Assistant (Gatekeeper)',
            self::ROLE_ASSISTANT_VET => 'Assistant Veterinarian (Vet 3)',
            self::ROLE_CLINIC => 'External Vet Clinic',
            self::ROLE_HOSPITAL => 'External Vet Hospital',
            self::ROLE_LIVESTOCK_INSPECTOR => 'Livestock Inspector',
            self::ROLE_MEAT_INSPECTOR => 'Meat & Post-Abattoir Inspector',
            self::ROLE_RECORDS_STAFF => 'Records Staff',
            self::ROLE_CITY_POUND => 'City Pound Personnel',
            self::ROLE_CITIZEN => 'Citizen (Pet Owner)',
            default => 'Unknown',
        };
    }

    /**
     * Get all available roles.
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN => 'Super Administrator (IT)',
            self::ROLE_CITY_VET => 'City Veterinarian (Admin/Office Head)',
            self::ROLE_ADMIN_STAFF => 'Administrative Assistant IV (Book Binder 4)',
            self::ROLE_ADMIN_ASST => 'Admin Assistant (Gatekeeper)',
            self::ROLE_ASSISTANT_VET => 'Assistant Veterinarian (Vet 3)',
            self::ROLE_CLINIC => 'External Vet Clinic',
            self::ROLE_HOSPITAL => 'External Vet Hospital',
            self::ROLE_LIVESTOCK_INSPECTOR => 'Livestock Inspector (Book Binder 1)',
            self::ROLE_MEAT_INSPECTOR => 'Meat & Post-Abattoir Inspector',
            self::ROLE_RECORDS_STAFF => 'Records Staff',
            self::ROLE_CITY_POUND => 'City Pound Personnel',
            self::ROLE_CITIZEN => 'Citizen (Pet Owner)',
        ];
    }

    /**
     * Get role hierarchy levels (higher number = more permissions).
     */
    public static function getRoleHierarchy(): array
    {
        return [
            self::ROLE_SUPER_ADMIN => 10,       // IT Personnel - Highest
            self::ROLE_CITY_VET => 8,           // Admin/Office Head
            self::ROLE_ADMIN_STAFF => 6,         // Administrative Assistant IV
            self::ROLE_ADMIN_ASST => 5,         // Admin Assistant (Gatekeeper)
            self::ROLE_ASSISTANT_VET => 5,      // Assistant Veterinarian
            self::ROLE_CLINIC => 4,              // External Vet Clinic
            self::ROLE_HOSPITAL => 4,              // External Vet Hospital
            self::ROLE_LIVESTOCK_INSPECTOR => 4,// Livestock Inspector
            self::ROLE_MEAT_INSPECTOR => 4,     // Meat & Post-Abattoir Inspector
            self::ROLE_RECORDS_STAFF => 3,      // Records Management
            self::ROLE_CITY_POUND => 3,         // City Pound Personnel
            self::ROLE_CITIZEN => 1,            // Pet owner / citizen portal
        ];
    }

    /**
     * Get the hierarchy level for this user.
     */
    public function getHierarchyLevel(): int
    {
        $role = $this->getRoleAttribute();
        return self::getRoleHierarchy()[$role] ?? 0;
    }

    /**
     * Check if user can manage another user based on role hierarchy.
     * User can only manage users with equal or lower hierarchy level.
     */
    public function canManageUser(User $targetUser): bool
    {
        // Super admin cannot be managed by anyone
        if ($targetUser->hasRole(self::ROLE_SUPER_ADMIN)) {
            return false;
        }

        // If target is super_admin, only another super_admin can manage (but cannot delete self)
        if ($targetUser->hasRole(self::ROLE_SUPER_ADMIN)) {
            return $this->hasRole(self::ROLE_SUPER_ADMIN);
        }

        // Other users: check hierarchy
        return $this->getHierarchyLevel() >= $targetUser->getHierarchyLevel();
    }

    /**
     * Check if user can assign a specific role.
     * Users cannot assign roles higher than their own level.
     */
    public function canAssignRole(string $role): bool
    {
        $roleLevel = self::getRoleHierarchy()[$role] ?? 0;
        return $this->getHierarchyLevel() >= $roleLevel;
    }

    /**
     * Get available roles for assignment based on user's hierarchy.
     */
    public function getAssignableRoles(): array
    {
        $userLevel = $this->getHierarchyLevel();
        $hierarchy = self::getRoleHierarchy();

        $assignable = [];
        foreach ($hierarchy as $role => $level) {
            if ($level <= $userLevel) {
                $assignable[$role] = self::getRoles()[$role] ?? $role;
            }
        }

        return $assignable;
    }

    /**
     * Check if user can access admin dashboard.
     * Citizens cannot access admin areas.
     */
    public function canAccessAdminPanel(): bool
    {
        return !$this->hasRole(self::ROLE_CITIZEN);
    }

    /**
     * Check if user can modify super admin account.
     */
    public function canModifySuperAdmin(): bool
    {
        return $this->hasRole(self::ROLE_SUPER_ADMIN);
    }

    /**
     * Check if this is the authenticated user's own account.
     */
    public function isSelf(): bool
    {
        return $this->id === auth()->id();
    }

    /**
     * Get primary admin roles.
     */
    public static function getAdminRoles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_CITY_VET,
        ];
    }

    /**
     * Get operational staff roles.
     */
    public static function getStaffRoles(): array
    {
        return [
            self::ROLE_CITY_VET,
            self::ROLE_ADMIN_STAFF,
            self::ROLE_ASSISTANT_VET,
            self::ROLE_CLINIC,
            self::ROLE_LIVESTOCK_INSPECTOR,
            self::ROLE_MEAT_INSPECTOR,
            self::ROLE_RECORDS_STAFF,
            self::ROLE_CITY_POUND,
        ];
    }

    /**
     * Get the pets owned by this user.
     */
    public function pets()
    {
        // User → pet_owners → pets (through pet_owners table)
        return $this->hasManyThrough(Pet::class, PetOwner::class, 'user_id', 'owner_id')
            ->orderBy('pet_name');
    }

    /**
     * Get the bite rabies reports reported by this user.
     */
    public function biteRabiesReportsReported(): HasMany
    {
        return $this->hasMany(BiteRabiesReport::class, 'reported_by', 'id');
    }

    /**
     * Get the bite rabies reports approved by this user.
     */
    public function biteRabiesReportsApproved(): HasMany
    {
        return $this->hasMany(BiteRabiesReport::class, 'approved_by', 'id');
    }

    /**
     * Get the announcements created by this user.
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'created_by', 'id');
    }

    /**
     * Get livestock recorded by this user.
     */
    public function livestockRecorded(): HasMany
    {
        return $this->hasMany(Livestock::class, 'recorded_by', 'id');
    }

    /**
     * Get system logs created by this user.
     */
    public function systemLogs(): HasMany
    {
        return $this->hasMany(SystemLog::class, 'user_id', 'id');
    }

    /**
     * Get notifications for this user.
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    /**
     * Get all announcements read by this user.
     */
    public function announcementReads(): HasMany
    {
        return $this->hasMany(AnnouncementRead::class, 'user_id', 'id');
    }

    /**
     * Check if user has read a specific announcement.
     */
    public function hasReadAnnouncement(int $announcementId): bool
    {
        return $this->announcementReads()
                    ->where('announcement_id', $announcementId)
                    ->exists();
    }

    /**
     * Mark an announcement as read.
     */
    public function markAnnouncementAsRead(int $announcementId): void
    {
        if (!$this->hasReadAnnouncement($announcementId)) {
            AnnouncementRead::create([
                'announcement_id' => $announcementId,
                'user_id' => $this->id,
                'read_at' => now(),
            ]);
        }
    }
}
