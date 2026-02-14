<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Model implements \Illuminate\Contracts\Auth\Authenticatable
{
    use Authenticatable, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'secondary_role',
        'barangay',
        'clinic_name',
        'division',
        'contact_number',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's device tokens for push notifications.
     */
    public function deviceTokens()
    {
        return $this->hasMany(DeviceToken::class);
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

    // Role constants based on VET-MIS specifications
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_CITY_VETERINARIAN = 'city_vet';
    public const ROLE_RECORDS_STAFF = 'records_staff';
    public const ROLE_BARANGAY_ENCODER = 'barangay_encoder';
    public const ROLE_DISEASE_CONTROL = 'disease_control';
    public const ROLE_MEAT_INSPECTOR = 'meat_inspector';
    public const ROLE_INVENTORY_STAFF = 'inventory_staff';
    public const ROLE_CLINIC = 'clinic';
    public const ROLE_VIEWER = 'viewer';
    public const ROLE_CITIZEN = 'citizen';

    /**
     * Check if user is a super admin (System Administrator).
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    /**
     * Check if user is an administrator (City Veterinarian / Admin).
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN || $this->role === self::ROLE_CITY_VETERINARIAN;
    }

    /**
     * Check if user is a records staff.
     */
    public function isRecordsStaff(): bool
    {
        return $this->role === self::ROLE_RECORDS_STAFF;
    }

    /**
     * Check if user is a barangay encoder.
     */
    public function isBarangayEncoder(): bool
    {
        return $this->role === self::ROLE_BARANGAY_ENCODER;
    }

    /**
     * Check if user is disease control personnel.
     */
    public function isDiseaseControl(): bool
    {
        return $this->role === self::ROLE_DISEASE_CONTROL;
    }

    /**
     * Check if user is a meat inspector.
     */
    public function isMeatInspector(): bool
    {
        return $this->role === self::ROLE_MEAT_INSPECTOR;
    }

    /**
     * Check if user is inventory staff.
     */
    public function isInventoryStaff(): bool
    {
        return $this->role === self::ROLE_INVENTORY_STAFF;
    }

    /**
     * Check if user is a clinic user.
     */
    public function isClinic(): bool
    {
        return $this->role === self::ROLE_CLINIC;
    }

    /**
     * Check if user has viewing access only.
     */
    public function isViewer(): bool
    {
        return $this->role === self::ROLE_VIEWER;
    }

    /**
     * Check if user is a citizen.
     */
    public function isCitizen(): bool
    {
        return $this->role === self::ROLE_CITIZEN;
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role || $this->secondary_role === $role;
    }

    /**
     * Check if user has a specific primary role.
     */
    public function hasPrimaryRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Check if user has a specific secondary role.
     */
    public function hasSecondaryRole(string $role): bool
    {
        return $this->secondary_role === $role;
    }

    /**
     * Get effective role (primary or secondary).
     */
    public function getEffectiveRole(): string
    {
        return $this->secondary_role ?? $this->role;
    }

    /**
     * Check if user is an admin with secondary barangay role.
     */
    public function isAdminWithBarangayAccess(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN]) && 
               $this->secondary_role === self::ROLE_BARANGAY_ENCODER;
    }

    /**
     * Check if user is an admin with secondary clinic role.
     */
    public function isAdminWithClinicAccess(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN]) && 
               $this->secondary_role === self::ROLE_CLINIC;
    }

    /**
     * Get role display name.
     */
    public function getRoleDisplayName(): string
    {
        return match($this->role) {
            self::ROLE_SUPER_ADMIN => 'Super Administrator',
            self::ROLE_ADMIN => 'Veterinary Administrator',
            self::ROLE_CITY_VETERINARIAN => 'City Veterinarian',
            self::ROLE_BARANGAY_ENCODER => 'Barangay Encoder',
            self::ROLE_CLINIC => 'Veterinary Clinic User',
            self::ROLE_DISEASE_CONTROL => 'Disease Control Personnel',
            self::ROLE_MEAT_INSPECTOR => 'Meat Inspector',
            self::ROLE_INVENTORY_STAFF => 'Inventory Staff',
            self::ROLE_RECORDS_STAFF => 'Records Staff',
            self::ROLE_VIEWER => 'Viewer / Supervisor',
            self::ROLE_CITIZEN => 'Citizen / Pet Owner',
            default => 'Unknown',
        };
    }

    /**
     * Get all available roles.
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN => 'Super Administrator',
            self::ROLE_ADMIN => 'Veterinary Administrator',
            self::ROLE_CITY_VETERINARIAN => 'City Veterinarian',
            self::ROLE_RECORDS_STAFF => 'Records Staff',
            self::ROLE_BARANGAY_ENCODER => 'Barangay Encoder',
            self::ROLE_DISEASE_CONTROL => 'Disease Control Personnel',
            self::ROLE_MEAT_INSPECTOR => 'Meat Inspector',
            self::ROLE_INVENTORY_STAFF => 'Inventory Staff',
            self::ROLE_CLINIC => 'Veterinary Clinic User',
            self::ROLE_VIEWER => 'Viewer / Supervisor',
            self::ROLE_CITIZEN => 'Citizen / Pet Owner',
        ];
    }

    /**
     * Get admin roles (full access).
     */
    public static function getAdminRoles(): array
    {
        return [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_ADMIN,
        ];
    }

    /**
     * Get staff roles (division-based access).
     */
    public static function getStaffRoles(): array
    {
        return [
            self::ROLE_CITY_VETERINARIAN,
            self::ROLE_RECORDS_STAFF,
            self::ROLE_DISEASE_CONTROL,
            self::ROLE_MEAT_INSPECTOR,
            self::ROLE_INVENTORY_STAFF,
        ];
    }

    /**
     * Get all roles assigned to this user (many-to-many relationship).
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
                    ->using(UserRole::class)
                    ->withPivot('assigned_at')
                    ->withTimestamps();
    }

    /**
     * Get the pets owned by this user.
     */
    public function pets()
    {
        return $this->hasMany(Pet::class, 'owner_id');
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles) || 
               (($this->secondary_role && in_array($this->secondary_role, $roles)));
    }

    /**
     * Get the primary role name.
     */
    public function getPrimaryRoleNameAttribute(): string
    {
        $roleNames = [
            self::ROLE_SUPER_ADMIN => 'Super Administrator',
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_CITY_VETERINARIAN => 'City Veterinarian',
            self::ROLE_RECORDS_STAFF => 'Records Staff',
            self::ROLE_BARANGAY_ENCODER => 'Barangay Encoder',
            self::ROLE_DISEASE_CONTROL => 'Disease Control',
            self::ROLE_MEAT_INSPECTOR => 'Meat Inspector',
            self::ROLE_INVENTORY_STAFF => 'Inventory Staff',
            self::ROLE_CLINIC => 'Clinic',
            self::ROLE_VIEWER => 'Viewer',
            self::ROLE_CITIZEN => 'Citizen',
        ];

        return $roleNames[$this->role] ?? 'Unknown';
    }

    /**
     * Get all announcements read by this user.
     */
    public function announcementReads()
    {
        return $this->hasMany(AnnouncementRead::class);
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
