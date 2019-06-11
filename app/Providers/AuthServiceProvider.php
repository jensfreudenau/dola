<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];
    
    const SUPERADMIN = 1;
    const ADVANCEDUSER = 2;
    const SIMPLEUSER = 3;

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $user = Auth::user();

        
        // Auth gates for: User management
        Gate::define('user_management_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });

        // Auth gates for: Roles
        Gate::define('role_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('role_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('role_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('role_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('role_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });

        // Auth gates for: Hashes
        Gate::define('hashes_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('hashes_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('hashes_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('hashes_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('hashes_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });

        // Auth gates for: Users
        Gate::define('user_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('user_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('user_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('user_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('user_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });

        // Auth gates for: Teams
        Gate::define('organizer_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('organizer_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('organizer_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('organizer_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('organizer_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });

        // Auth gates for: Page
        Gate::define('page_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('page_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        
        // Auth gates for: Participators
        Gate::define('participator_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('participator_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('participator_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('participator_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('participator_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });

        // Auth gates for: Games
        Gate::define('record_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('record_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('record_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('record_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('record_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });

        // Auth gates for: Address
        Gate::define('address_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('address_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('address_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('address_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('address_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });

        // Auth gates for: Competition
        Gate::define('competition_access', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('competition_create', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('competition_edit', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });
        Gate::define('competition_view', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER, self::SIMPLEUSER]);
        });
        Gate::define('competition_delete', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN]);
        });
        Gate::define('competition_delete_file', function ($user) {
            return in_array($user->role_id, [self::SUPERADMIN, self::ADVANCEDUSER]);
        });

    }
}
