<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Observers\PermissionObserver;
use App\Observers\RoleObserver;
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
        // Caso queira adicionar permissões para tipos de usuário já ficará pré configurada...
        Role::observe(RoleObserver::class);
        Permission::observe(PermissionObserver::class);
        Gate::before(function (User $user, $ability) {


            if ($user->roles->first()->name === 'admin') return true;

            if (Permission::existsOnCache($ability)) {

                return $user->hasPermissionTo($ability);
            }
            if (Role::existsOnCache($ability)) {
                return $user->hasRoleTo($ability);
            }
        });
    }
}
