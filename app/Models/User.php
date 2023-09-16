<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function roles() :BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions() :BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    public function giveRoleTo(string $role): void
    {
        /** @var Role  $p */
        $p = Role::getRole($role);
        $this->roles()->attach($p);
        Cache::forget('roles::of::user'. $this->id);
    }

    public function givePermissionTo(string $permission): void
    {
        /** @var Permission  $p */
        $p = Permission::getPermission($permission);
        $this->permissions()->attach($p);
        Cache::forget('permissions::of::user'. $this->id);

    }

     public function removeRoleTo(string $role)
    {
        /** @var Role  $r */
        $r = Role::getRole($role);
        $this->roles()->detach($r);
        Cache::forget('roles::of::user'. $this->id);
    }

     public function removePermissionTo(string $permission)
    {
        /** @var Permission  $p */
        $p = Permission::getPermission($permission);
        $this->permissions()->detach($p);
        Cache::forget('permissions::of::user'. $this->id);
    }

    public function hasRoleTo(string $role): bool
    {
        /** @var Collection $rolesOfUser */

        $rolesOfUser =  Cache::rememberForever('roles::of::user'. $this->id, function() {

            return $this->roles()->get();
        });




        $r  =  $rolesOfUser->where('name', $role)->isNotEmpty();

        return  $r;
    }

    public function hasPermissionTo(string $permission): bool
    {
        /** @var Collection $permissionsOfUser */

        $permissionsOfUser =  Cache::rememberForever('permissions::of::user'. $this->id, function() {

            return $this->permissions()->get();
        });




        $r  =  $permissionsOfUser->where('name', $permission)->isNotEmpty();

        return  $r;
    }
}
