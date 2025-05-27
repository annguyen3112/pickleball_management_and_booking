<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Enums\UserRole;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('checkCourtOwner', function ($user) {
            if ($user->role == UserRole::CourtOwner) return true;
            return false;
        });
        
        Gate::define('checkSystemAdmin', function ($user) {
            return $user->role == UserRole::SystemAdmin;
        });

        Gate::define('checkAdmin', function ($user) {
            return $user->role === UserRole::Employee || $user->role === UserRole::CourtOwner;
        });
    }
}
