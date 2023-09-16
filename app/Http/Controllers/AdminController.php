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

        return view('Admin.permissoes.index', [
            'permissoesDisponiveis' => $permission->permissionsAvaiables($permission),
            'allpermissoes' => $permission->all()
        ]);

    }
    public function storePermissions(Request $request, Permission $permission)
    {
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
            $user->givePermissionTo($permission->name); // Atribuir permissão para o usuário.
            return response()->json(['success' => 'Permissão concedida com sucesso.']);
        } else {
            $user->removePermissionTo($permission->name); // Revogar permissão para o usuário.
            return response()->json(['success' => 'Permissão revogada com sucesso.']);
        }
    }
    public function deletePermissionUser($id)
    {
        Permission::find($id)->delete();
        return redirect()->back()->with(['success' => 'Permissão deletada com sucesso.']);
    }
}
