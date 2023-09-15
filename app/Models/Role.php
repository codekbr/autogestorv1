<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = ['name', 'description'];


    public static function getRole(string $role) : Role
    {
        $p = self::getAllFromCache()->where('name', $role)->first();

        if (!$p) {
            $p = Role::query()->create(['name' => $role]);
        }

        return $p;
    }

     public static function existsOnCache(string $roles): bool
    {

        $r = self::getAllFromCache()->where('name', $roles)->isNotEmpty();
        return $r;
    }

     public static function getAllFromCache(): Collection
    {
        /** @var Collection $roles */
        $roles = Cache::rememberForever('roles', function( ) {
            return  self::all();
        });



        return $roles;
    }
}
