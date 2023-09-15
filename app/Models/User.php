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

    public function giveRoleTo(string $role): void
    {
        $p = Role::query()->firstOrCreate([
            'name'=> $role
        ]);

        $this->roles()->attach($p);
        Cache::forget('roles::of::user'. $this->id);
    }

     public function removeRoleTo(string $permission)
    {
        /** @var Role  $r */
        $r = Role::getPermission($permission);
        $this->roles()->detach($r);
        Cache::forget('roles::of::user'. $this->id);
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
}
