<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users (except citizens) can view users list
        return $user->canAccessAdminPanel();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $targetUser): bool
    {
        // Citizens can only view their own profile
        if ($user->isCitizen()) {
            return $user->id === $targetUser->id;
        }

        // Check if user can manage the target user
        return $user->canManageUser($targetUser);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Citizens cannot create users
        if ($user->isCitizen()) {
            return false;
        }

        // Must have at least level 3 (records_staff) to create users
        return $user->getHierarchyLevel() >= 3;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $targetUser): bool
    {
        // Prevent self-modification for super_admin
        // Note: Profile update is handled separately in ProfileController
        if ($targetUser->isSelf() && $targetUser->isSuperAdmin()) {
            // Super admin can update their own profile but cannot change their own role
            return true;
        }

        // Cannot modify super_admin unless you are also super_admin (and not yourself)
        if ($targetUser->isSuperAdmin() && !$targetUser->isSelf()) {
            return $user->canModifySuperAdmin();
        }

        // Check hierarchy-based management
        return $user->canManageUser($targetUser);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $targetUser): bool
    {
        // Cannot delete yourself
        if ($targetUser->isSelf()) {
            return false;
        }

        // Cannot delete super_admin unless you are another super_admin
        if ($targetUser->isSuperAdmin()) {
            return $user->isSuperAdmin();
        }

        // Check hierarchy
        return $user->canManageUser($targetUser);
    }

    /**
     * Determine whether the user can toggle user status (activate/deactivate).
     */
    public function toggleStatus(User $user, User $targetUser): bool
    {
        // Cannot toggle your own status
        if ($targetUser->isSelf()) {
            return false;
        }

        // Cannot toggle super_admin status unless you are super_admin
        if ($targetUser->isSuperAdmin()) {
            return $user->isSuperAdmin();
        }

        // Check hierarchy
        return $user->canManageUser($targetUser);
    }

    /**
     * Determine whether the user can change the role of a user.
     */
    public function changeRole(User $user, User $targetUser): bool
    {
        // Cannot change own role
        if ($targetUser->isSelf()) {
            return false;
        }

        // Cannot change super_admin role unless you are super_admin
        if ($targetUser->isSuperAdmin()) {
            return $user->isSuperAdmin();
        }

        // Check if user can assign the target role
        return $user->canManageUser($targetUser);
    }

    /**
     * Determine whether the user can assign a specific role.
     */
    public function assignRole(User $user, string $role): bool
    {
        return $user->canAssignRole($role);
    }

    /**
     * Determine if user can access admin dashboard.
     */
    public function accessAdminDashboard(User $user): bool
    {
        return $user->canAccessAdminPanel();
    }
}