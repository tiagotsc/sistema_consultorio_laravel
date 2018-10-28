<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\User;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:perfil-listar');
         $this->middleware('permission:perfil-criar', ['only' => ['create','store']]);
         $this->middleware('permission:perfil-editar', ['only' => ['edit','update']]);
         $this->middleware('permission:perfil-apagar', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$roles = Role::orderBy('id','DESC');
        return view('role.index');
    }

    public function getpesq(Request $request)
    {    
        $dados = Role::where('name','like','%'.$request->input('nome').'%')->orderBy('id','DESC')->get();
        return json_encode(array('data' => $dados));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissoesGrupo = Permission::distinct()
                            ->select(DB::raw("SUBSTRING(name, 1, LOCATE('-', name) - 1) grupo"))
                            ->orderBy('grupo')
                            ->pluck('grupo','grupo')->prepend('Todos');
        $permission = Permission::select('id','name', DB::raw("SUBSTRING(name, 1, LOCATE('-', name) - 1) grupo"))->orderBy('name')->get();
        
        return view('role.create', ['permission' => $permission, 'permissoesGrupo' => $permissoesGrupo]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'permission' => 'required',
            ]);
    
            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permission'));
            if($role){
                $msg = 'alert-success|Role criado com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao criar perfil! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Throwable  $e) {
            report($e);
            $msg = 'alert-warning|Erro ao criar perfil! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('roles.index')->with('alertMessage', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permissoesGrupo = Permission::distinct()
                            ->select(DB::raw("SUBSTRING(name, 1, LOCATE('-', name) - 1) grupo"))
                            ->orderBy('grupo')
                            ->pluck('grupo','grupo')->prepend('Todos');
        $permission = Permission::select('id','name', DB::raw("SUBSTRING(name, 1, LOCATE('-', name) - 1) grupo"))->orderBy('name')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id')
            ->toArray();
        return view('role.edit', ['role' => $role, 'permission' => $permission, 'rolePermissions' => $rolePermissions, 'permissoesGrupo' => $permissoesGrupo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try {
            $this->validate($request, [
                'name' => 'required',
                'permission' => 'required',
            ]);
    
            $role = Role::find($id);
            $role->name = $request->input('name');
            $role->save();
    
            $role->syncPermissions($request->input('permission'));
            if($role){
                $msg = 'alert-success|Role alterada com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao alterar perfil! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Throwable  $e) {
            report($e);
            $msg = 'alert-warning|Erro ao alterar perfil! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('roles.edit', ['id' => $role->id])->with('alertMessage', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
