<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function indexUsers()
    {

        $users = User::all();
        $permissions = Permission::all();
        return view('Admin.usuarios.index', compact('users', 'permissions'));
    }

    public function createPermissions(Permission $permission)
    {
         // Obtenha as permissões já cadastradas no banco de dados
        $permissõesCadastradas = $permission::pluck('name')->toArray();
        $listaPermissoes = $permission->all();

        // Array de todas as permissões disponíveis
        $permissoesDisponiveis = [
            'aba-produtos' => 'Permissão Aba Produtos',
            'aba-marcas' => 'Permissão Aba Marcas',
            'aba-categorias' => 'Permissão Aba Categorias',
        ];

        // Filtrar as permissões disponíveis para exibir apenas aquelas que ainda não estão cadastradas
        $permissoesNaoCadastradas = array_diff_key($permissoesDisponiveis, array_flip($permissõesCadastradas));
        $permissions = Permission::all();
        return view('Admin.permissoes.index', [
            'permissoesDisponiveis' => $permissoesNaoCadastradas,
            'allpermissoes' => $listaPermissoes
        ]);

    }
    public function storePermissions(Request $request, Permission $permission)
    {
        // dd($request->all());
        $created = $permission->create($request->all());
        if (!$created) {
            return redirect()->back()->with('error', 'Houve algum problema ao cadastrar essa permissão.');
        }
        return redirect()->back()->with('success', 'Permissão Cadastrada com sucesso!');
    }

    public function updatePermissionUser(Request $request, string $id)
    {
        $checked = $request->input('checked');
        $user = User::find($id);
        $permission = Permission::find($request->input('permission_id'));
        if (!$user || !$permission) {
            return response()->json(['error' => 'Usuário ou permissão não encontrada.'], 404);
        }

        if ($checked) {
            $user->givePermissionTo($permission->name);
            return response()->json(['success' => 'Permissão concedida com sucesso.']);
        } else {
            $user->removePermissionTo($permission->name);
            return response()->json(['success' => 'Permissão revogada com sucesso.']);
        }
    }

}
