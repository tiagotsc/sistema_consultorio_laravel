<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estado;
use App\Unidade;

class UnidadeController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:unidade-gerenciar');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dados = Unidade::orderBy('nome')->get();
        return view('unidade.index',['dados' => $dados]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::where('status','A')->orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        return view('unidade.create',['estados' => $estados]);
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
            $dados = Unidade::create($request->except('telefone'));
            if($dados){
                $telefones = array();
                foreach($request->input('telefone') as $telefone){
                    $telefones[]['telefone'] = $telefone;
                }
                $dados->telefones()->createMany($telefones);
                $msg = 'alert-success|Clínica / consultório criado com sucesso!';
            }else{
                $msg = 'alert-danger|Erro ao cadastrar clínica / consultório! Se persistir, comunique o administrador!';
            }
        } catch (Throwable $e) {
            $msg = 'alert-danger|Erro ao cadastrar clínica / consultório! Se persistir, comunique o administrador!';
        }
        return redirect()->route('unidade.edit',[$dados->id])->with('alertMessage', $msg);
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
        $dados = Unidade::find($id);
        $estados = Estado::orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        return view('unidade.edit',['estados' => $estados, 'dados' => $dados, 'telefones' => $dados->telefones]);
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
            $dados = Unidade::find($id);
            if($dados->update($request->except('telefone'))){
                $telefones = array();
                foreach($request->input('telefone') as $telefone){
                    $telefones[]['telefone'] = $telefone;
                }
                $dados->telefones()->delete();
                $dados->telefones()->createMany($telefones);
                $msg = 'alert-success|Clínica / consultóro alterado com sucesso!';
            }else{
                $msg = 'alert-danger|Erro ao alterar clínica / consultóro! Se persistir, comunique o administrador!';
            }
        } catch (Throwable $e) {
            $msg = 'alert-danger|Erro ao alterar clínica / consultóro! Se persistir, comunique o administrador!';
        }
        return redirect()->route('unidade.edit',[$dados->id])->with('alertMessage', $msg);
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
            $dados = Unidade::find($id);
            if($dados->delete()){
                $msg = 'alert-success|Clínica / consultório apagado com sucesso!';
            }else{
                $msg = 'alert-danger|Erro ao apagar clínica / consultório! Se persistir, comunique o administrador!';
            }
        } catch (Throwable $e) {
            $msg = 'alert-danger|Erro ao apagar clínica / consultório! Se persistir, comunique o administrador!';
        }
        return redirect()->route('unidade.index')->with('alertMessage', $msg);
    }
}
