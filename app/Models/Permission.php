<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;

class Permission extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['name', 'description'];

    public static function getPermission(string $permission) : Permission
    {
        // dd($permission);
        $p = self::getAllFromCache()->where('name', $permission)->first();

        if (!$p) {

            $p = Permission::query()->create(['name' => $permission]);
        }

        return $p;
    }


    public static function getAllFromCache(): Collection
    {
        /** @var Collection $permissions */
        $permissions = Cache::rememberForever('permissions', function( ) {
            return  self::all();
        });

        return $permissions;
    }


    public static function existsOnCache(string $permission): bool
    {

        return self::getAllFromCache()->where('name', $permission)->isNotEmpty();
    }


}
