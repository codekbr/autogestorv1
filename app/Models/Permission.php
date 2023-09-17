<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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


    public function permissionsAvaiables(Permission $permission)
    {
        $permissõesCadastradas = $permission::pluck('name')->toArray();
        // Array de todas as permissões disponíveis
        $permissoesDisponiveis = [
            'aba-produtos' => 'Permissão Aba Produtos',
            'aba-marcas' => 'Permissão Aba Marcas',
            'aba-categorias' => 'Permissão Aba Categorias',
        ];

        // Filtrar as permissões disponíveis para exibir apenas aquelas que ainda não estão cadastradas
        $permissoesNaoCadastradas = array_diff_key($permissoesDisponiveis, array_flip($permissõesCadastradas));

        return $permissoesNaoCadastradas;
    }


}
