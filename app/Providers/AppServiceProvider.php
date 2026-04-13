<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(User::class, UserPolicy::class);

        // Define Gates for easier access control in views and controllers
        Gate::define('manage-users', function (User $user) {
            return $user->getHierarchyLevel() >= 3 && !$user->isCitizen();
        });

        Gate::define('create-users', function (User $user) {
            return $user->canAccessAdminPanel() && $user->getHierarchyLevel() >= 3;
        });

        Gate::define('access-admin-dashboard', function (User $user) {
            return $user->canAccessAdminPanel();
        });

        Gate::define('manage-super-admin', function (User $user) {
            return $user->isSuperAdmin();
        });
    }
}
