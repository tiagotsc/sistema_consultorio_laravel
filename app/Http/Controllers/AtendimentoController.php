<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use App\User;
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
        return view('atendimento.edit',['dados' => $agenda]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {echo '<pre>'; print_r($_POST); exit;
        try {
            $timezone = User::find(Auth::id())->estado->timezone;   
            date_default_timezone_set($timezone);
            $data = explode('/',$request->input('data_consulta'));
            $agenda = Agenda::find($id);
            $agenda->agenda_status_id = 6; # Finalizado
            $agenda->hora_fim = date('H:i:s');
            $agenda->medico_anotacoes = $request->input('medico_anotacoes');
            if($agenda->save()){
                broadcast(new AgendaStatusEvento($agenda,'medico'))->toOthers();
                $msg = 'alert-success|Consulta concluída com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao concluir consulta! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Throwable  $e) {
            report($e);
            $msg = 'alert-warning|Erro ao concluir consulta! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('agenda.index', ['dia' => $data[0],'mes'=>$data[1],'ano'=>$data[2]])->with('alertMessage', $msg);
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
