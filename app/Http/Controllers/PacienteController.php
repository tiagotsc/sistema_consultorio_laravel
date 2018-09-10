<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Estado;
use App\Paciente;
use Illuminate\Support\Facades\Auth;
use App\User;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:paciente-listar');
         $this->middleware('permission:paciente-criar', ['only' => ['create','store']]);
         $this->middleware('permission:paciente-editar', ['only' => ['edit','update']]);
         $this->middleware('permission:paciente-apagar', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissoes = User::find(Auth::id())->getPermissionsViaRoles()->pluck('name')->toArray();
        return view('paciente.index', ['permissoes' => json_encode($permissoes)]);
    }

    public function getpesq(Request $request){
        $dados = Paciente::select('id','matricula','nome','status')->where('nome','like','%'.$request->input('nome_cpf_rg').'%')->get();
        return json_encode(array('data' => $dados));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::where('status','A')->orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        return view('paciente.create', [
            'estados' => $estados
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
        try {
            $dados = $request->all();
            $paciente = new Paciente($dados);
            if($paciente->save()){
                $msg = 'alert-success|Paciente criado com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao criar paciente! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao criar paciente! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('paciente.create')->with('alertMessage', $msg);
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
        $paciente = Paciente::find($id);
        $estados = Estado::where('status','A')->orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        return view('paciente.edit', [
            'paciente' => $paciente,
            'estados' => $estados
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
        try {
            $paciente = Paciente::find($id);
            $dados = $request->all();
            if($paciente->update($dados)){
                $msg = 'alert-success|Paciente alterado com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao alterar paciente! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao alterar paciente! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('paciente.edit', ['id' => $paciente->id])->with('alertMessage', $msg);
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
            $paciente = Paciente::find($id);
            if($paciente->delete()){
                $msg = 'alert-success|Paciente excluido com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao excluir paciente! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao excluir paciente! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('paciente.index')->with('alertMessage', $msg);
    }
}
