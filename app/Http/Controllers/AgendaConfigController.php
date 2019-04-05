<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgendaConfig;

class AgendaConfigController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:agenda_config-gerenciar');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agendaConfig = AgendaConfig::first();
        return view('agenda_config.create',['agendaConfig' => $agendaConfig]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
            $dados = $request->all();
            $agendaConfig = AgendaConfig::find($id);
            if($agendaConfig->update($dados)){
                $msg = 'alert-success|Configuração alterada sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao alterar configuração! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Exception $e) {
            report($e);
            $msg = 'alert-warning|Erro ao alterar configuração! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('agendaconfig.create')->with('alertMessage', $msg);
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
