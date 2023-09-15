<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Observers\RoleObserver;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Gate;
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
        Role::observe(RoleObserver::class);
        Gate::before(function (User $user, $ability) {
            if (Role::existsOnCache($ability)) {
                return $user->hasRoleTo($ability);
            }
        });
    }
}
