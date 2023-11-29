<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Http\Enums\RoleType;
use App\Models\User;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('owner', function (User $user) {
            return $user->checkRole(RoleType::Owner->value);
        });

        Gate::define('admin', function (User $user) {
            return $user->checkRole(RoleType::Administrator->value);
        });

        Gate::define('master', function (User $user) {
            return $user->checkRole(RoleType::Master->value);
        });
    }
}
