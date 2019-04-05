<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RelatorioCategoria;
use Illuminate\Support\Facades\Auth;
use DB;

class RelatorioCategoriaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:relatorio_categoria-gerenciar');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $relatorioCategoria = new RelatorioCategoria();
        $relatorioCategoria = $relatorioCategoria->select(
            'id',
            'nome',
            DB::raw("case when status = 'A' then 'Ativo' else 'Inativo' end as status")
        );
        if($buscar != null){
            $relatorioCategoria = $relatorioCategoria->where('nome','like',"%".$buscar."%");
        }
        return view('relatorio_categoria.index',['dados' => $relatorioCategoria->orderBy('nome')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('relatorio_categoria.create');
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
            $relatorioCategoria = RelatorioCategoria::create($request->all());
            if($relatorioCategoria){
                $msg = 'alert-success|Categoria criada com sucesso!';
            }else{
                $msg = 'alert-danger|Erro ao cadastrar categoria! Se persistir, comunique o administrador!';
            }
        } catch (Throwable $e) {
            $msg = 'alert-danger|Erro ao cadastrar categoria! Se persistir, comunique o administrador!';
        }
        
        return redirect()->route('relatorioCategoria.index');
        
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
        $relatorioCategoria = RelatorioCategoria::find($id);
        return view('relatorio_categoria.edit',['dados'=>$relatorioCategoria]);
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
            $relatorioCategoria = RelatorioCategoria::find($id);
            if($relatorioCategoria->update($request->all())){
                $msg = 'alert-success|Categoria alterada com sucesso!';
            }else{
                $msg = 'alert-danger|Erro ao alterar categoria! Se persistir, comunique o administrador!';
            }
        } catch (Throwable $e) {
            $msg = 'alert-danger|Erro ao alterar categoria! Se persistir, comunique o administrador!';
        }
        return redirect()->route('relatorioCategoria.edit',[$relatorioCategoria->id])->with('alertMessage', $msg);
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
            $relatorioCategoria = RelatorioCategoria::find($id);
            if($relatorioCategoria->delete()){
                $msg = 'alert-success|Categoria apagada com sucesso!';
            }else{
                $msg = 'alert-danger|Erro ao apagar categoria! Se persistir, comunique o administrador!';
            }
        } catch (Throwable $e) {
            $msg = 'alert-danger|Erro ao apagar categoria! Se persistir, comunique o administrador!';
        }
        return redirect()->route('relatorioCategoria.index')->with('alertMessage', $msg);
    }
}
