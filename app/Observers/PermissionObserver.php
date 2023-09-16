<?php

namespace App\Observers;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     */
    public function created(Permission $permission): void
    {
        Cache::forget('permissions');
        Cache::rememberForever('permissions', fn () => Permission::all());
    }

    /**
     * Handle the Permission "updated" event.
     */
    public function updated(Permission $permission): void
    {
        //
    }

    /**
     * Handle the Permission "deleted" event.
     */
    public function deleted(Permission $permission): void
    {
        // Definir uma nova coleção como valor padrão
        $permissionsInCache = Cache::get('permissions', new Collection());
        // Verificar se a permissão está no cache
        $updatedPermissions = $permissionsInCache->filter(function ($cachedPermission) use ($permission) {
            return $cachedPermission['name'] !== $permission && $cachedPermission['id'] !== $permission['id'];
        });
        // Atualizar o cache com as permissões restantes
        Cache::forever('permissions', $updatedPermissions->values());
    }

    /**
     * Handle the Permission "restored" event.
     */
    public function restored(Permission $permission): void
    {
        //
    }

    /**
     * Handle the Permission "force deleted" event.
     */
    public function forceDeleted(Permission $permission): void
    {
        //
    }
}
