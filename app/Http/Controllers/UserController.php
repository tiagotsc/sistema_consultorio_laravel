<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Especialidade;
use App\Estado;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:usuario-listar');
         $this->middleware('permission:usuario-criar', ['only' => ['create','store']]);
         $this->middleware('permission:usuario-editar', ['only' => ['edit','update']]);
         $this->middleware('permission:usuario-apagar', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    public function getpesq(Request $request){
        $dados = User::select('id','matricula','name','status')->where('name','like','%'.$request->input('nome_cpf').'%')->get();
        return json_encode(array('data' => $dados));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $perfis = Role::orderBy('name')->pluck('name', 'name');
        $estados = Estado::where('status','A')->orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        $especialidades = Especialidade::where('status','A')->orderBy('nome')->pluck('nome', 'id');
        return view('user.create', [
            'estados' => $estados,
            'especialidades' => $especialidades,
            'perfis' => $perfis
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $especialidades = $request->input('especialidade');
        $perfis = $request->input('perfis');
        try {
            $dados = $request->except(['_token', 'especialidade', 'password', 'perfis']);
            if($request->input('password')){
                $dados['password'] = bcrypt($request->input('password'));
            }
            $user = new User($dados);
            if($user->save()){
                $user->especialidades()->attach($especialidades);
                $user->syncRoles($perfis);
                $msg = 'alert-success|Usuário criado com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao criar usuário! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao criar usuário! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('usuario.create')->with('alertMessage', $msg);
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perfis = Role::orderBy('name')->pluck('name', 'name');
        $user = User::find($id);
        $userPerfis = $user->getRoleNames()->toArray();
        $userEsp = $user->especialidades()->pluck('especialidade_id');
        $estados = Estado::where('status','A')->orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        $especialidades = Especialidade::where('status','A')->orderBy('nome')->pluck('nome', 'id');
        return view('user.edit', [
            'user' => $user,
            'userPerfis' => $userPerfis,
            'estados' => $estados,
            'especialidades' => $especialidades,
            'userEsp' => $userEsp,
            'perfis' => $perfis
            ]);
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
        $especialidades = $request->input('especialidade');
        $perfis = $request->input('perfis');
        try {
            $user = User::find($id);
            $dados = $request->except(['_token', 'especialidade','perfis']);
            if($request->input('password')){
                $dados['password'] = bcrypt($request->input('password'));
            }
            if($user->update($dados)){
                $user->especialidades()->sync($especialidades);
                $user->syncRoles($perfis);
                $msg = 'alert-success|Usuário alterado com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao alterar usuário! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao alterar usuário! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('usuario.edit', ['id' => $user->id])->with('alertMessage', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);
            if($user->delete()){
                $msg = 'alert-success|Usuário excluido com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao excluir usuário! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao excluir usuário! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('usuario.index')->with('alertMessage', $msg);
    }
}
