<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\FuncionarioRequest;
use App\Funcionario;
use App\Especialidade;
use App\Estado;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('funcionario.index');
    }

    public function getpesq(Request $request){
        $dados = DB::table('funcionarios')->select('id','matricula','nome','idPerfil','status')->where('nome','like','%'.$request->input('nome_cpf').'%')->get();
        return json_encode(array('data' => $dados));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {/*
        $funcionario = new Funcionario();
        $especialidades = $funcionario->find(2)->especialidades;
        foreach($especialidades as $t){
            echo $t->nome.'<br>'; 
        }
        echo $funcionario->find(2)->estado->nome;
        exit();*/
        #echo '<pre>'; print_r($teste); exit();
        $estados = Estado::where('status','A')->orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        $especialidades = Especialidade::where('status','A')->orderBy('nome')->pluck('nome', 'id');
        return view('funcionario.create', [
                                        'estados' => $estados,
                                        'especialidades' => $especialidades
                                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FuncionarioRequest $request)
    { 
        $especialidades = $request->input('especialidade');
        try {
            $dados = $request->except(['_token', 'especialidade']);
            $funcionario = new Funcionario($dados);
            if($funcionario->save()){
                $funcionario->especialidades()->attach($especialidades);
                $msg = 'alert-success|Funcionário criado com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao criar funcionário! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao criar funcionário! Se o erro persistir, entre em contato com o administrador.';
        }
        #echo '<pre>'; print_r($especialidades); exit();
        #echo $funcionario->especialidades()->attach($especialidades); exit();
        return redirect()->route('funcionario.create')->with('alertMessage', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcionario = Funcionario::find($id);
        $funcEsp = $funcionario->especialidades()->pluck('especialidade_id');
        $estados = Estado::where('status','A')->orderBy('nome')->pluck('sigla', 'id')->prepend('', '');
        $especialidades = Especialidade::where('status','A')->orderBy('nome')->pluck('nome', 'id');
        return view('funcionario.edit', [
            'funcionario' => $funcionario,
            'estados' => $estados,
            'especialidades' => $especialidades,
            'funcEsp' => $funcEsp
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FuncionarioRequest $request)
    {
        $especialidades = $request->input('especialidade');
        try {
            $dados = $request->except(['_token', 'especialidade']);
            $funcionario = Funcionario::find($request->input('id'));
            if($funcionario->update($dados)){
                #$funcionario->especialidades()->attach($especialidades);
                $msg = 'alert-success|Funcionário alterado com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao alterar funcionário! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao alterar funcionário! Se o erro persistir, entre em contato com o administrador.';
        }
        #echo '<pre>'; print_r($especialidades); exit();
        #echo $funcionario->especialidades()->attach($especialidades); exit();
        return redirect()->route('funcionario.edit', ['id' => $funcionario->id])->with('alertMessage', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
