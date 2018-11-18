<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgendaConfig;
use App\Especialidade;
use App\User;
use App\Agenda;
use App\AgendaStatus;
use App\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\AgendaStatusEvento;
use DB;

class AtendimentoController extends Controller
{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        #$timezone = User::find(Auth::id())->estado->timezone;   
        #date_default_timezone_set($timezone);
        $agenda = Agenda::find($id);
        if($agenda->agenda_status_id == 4){ # Chamado
            $agenda->hora_inicio = date('H:i:s');
            $agenda->agenda_status_id = 5; # Em atendimento
            if($agenda->save()){
                if(auth()->user()->medico == 'S'){
                    $usuarioTipo = 'medico';
                }else{
                    $usuarioTipo = 'secretaria';
                }
                broadcast(new AgendaStatusEvento($agenda,$usuarioTipo))->toOthers();
            }
        }
        echo 'Em atendimento';
        exit;
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
        //
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
