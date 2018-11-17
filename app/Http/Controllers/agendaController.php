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

class AgendaController extends Controller
{
    public function __construct()
    {
        
        /*dd( Auth::user()->name );
        $estado = Auth::user()->estado->sigla;
        $timezone = getTimezone($estado);
        date_default_timezone_set($timezone);
        #date_default_timezone_set("Asia/Bangkok");
        echo date_default_timezone_get();
        exit;*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if($request->dia == null or $request->mes == null or $request->ano === null){
            $timezone = User::find(Auth::id())->estado->timezone;   
            date_default_timezone_set($timezone);
            $dia = date('d');
            $mes = date('m');
            $ano = date('Y');
        }
        if(auth()->user()->medico == 'S'){
            $usuarioTipo = 'medico';
        }else{
            $usuarioTipo = 'secretaria';
        }
        $todosStatus = AgendaStatus::/*where([['status','A'],['usuario_tipo','like','%'.$usuarioTipo.'%']])->*/get();
        $todasSequencias = array();
        foreach($todosStatus as $status){
            $todasSequencias[$status->id] = $status->statusSequencia($usuarioTipo)->pluck('agenda_status.nome',DB::raw("concat('_',agenda_status.id) id"))->toArray();
        }
        #dd($todasSequencias);
        $AgendaStatus = AgendaStatus::pluck('nome','id');
        $agendaConfig = AgendaConfig::first();
        #$horas = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        $horas = DB::table('agendas')->distinct()->select(DB::raw('substr(horario, 1, 5) as horario'))->orderBy('horario')->pluck('horario','horario')->prepend('', '');
        $dataEscolhida = $dia.'/'.$mes.'/'.$ano;
        return view('agenda.index', [
                                        'data' => $dataEscolhida, 
                                        'tipo' => ucfirst($usuarioTipo), 
                                        'horas' => $horas, 
                                        'agendaStatus' => $AgendaStatus, 
                                        'userId' => Auth::id(),
                                        'todasSequencias' => json_encode($todasSequencias)
                                    ]);
    }

    public function getpesq(Request $request){
        $buscar = $request->input('input_dado');
        $horario = $request->input('horario');
        $dados = Agenda::join('pacientes', 'pacientes.id', '=', 'agendas.paciente_id')
                        ->join('agenda_status','agenda_status.id','=','agendas.agenda_status_id')
                        ->join('users', 'users.id','=','agendas.medico_id')
                        ->join('especialidades','especialidades.id','=','agendas.especialidade_id')
                        ->select(
                                    'agendas.id',
                                    'agendas.horario',
                                    'pacientes.matricula',
                                    'agendas.paciente_id',
                                    'pacientes.nome',
                                    'pacientes.cpf',
                                    'pacientes.rg',
                                    'pacientes.telefone',
                                    'pacientes.celular',
                                    'pacientes.novoPaciente as novo',
                                    'agenda_status.nome as status',
                                    'agendas.medico_id',
                                    'users.name as medico',
                                    'especialidades.nome as especialidade',
                                    'agenda_status.id as status_id'
                                    )
                        ->where('agendas.horario','like',$horario.'%')
                        ->where(function ($query) use($buscar) {
                            $query->where('pacientes.nome','like','%'.$buscar.'%')
                            ->orWhere('pacientes.cpf','like','%'.$buscar.'%')
                            ->orWhere('pacientes.rg','like','%'.$buscar.'%')
                            ->orWhere('pacientes.telefone','like','%'.$buscar.'%')
                            ->orWhere('pacientes.celular','like','%'.$buscar.'%');
                        })
                        ->orderBy('agendas.horario')
                        ->get();#echo '<pre>';
                        #print_r($dados); exit();
        #return json_encode(array('data' => $dados));
        return response()->json(['data' => $dados]);
    }

    /**
     * Tela de marcação de consulta.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $especialidades = Especialidade::whereHas('users', function ($query) {
           $query->whereNotNull('user_id');
        })->orderBy('nome')->pluck('nome', 'id')->prepend('Selecione...', '');
        $data = $request->input('valores');
        if($data < date('d/m/Y')){
            $data = date('d/m/Y');
        }
        #$agendaConfig = AgendaConfig::first();
        #$horas = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        return view('agenda.create',[
                                        'dataSelecionada' => $data, 
                                        #'horas' => $horas,
                                        'especialidades' => $especialidades
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
        try{
            if($request->input('paciente_id') != ''){ #Atualizar
                $paciente = Paciente::find($request->input('paciente_id'));
                $paciente->telefone = $request->input('telefone');
                $paciente->celular = $request->input('celular');
            }else{ # Insere
                $dadoPaciente['nome'] = strtoupper(removeAcentos($request->input('nome_paciente')));
                $dadoPaciente['telefone'] = $request->input('telefone');
                $dadoPaciente['celular'] = $request->input('celular');
                $paciente = new Paciente($dadoPaciente);
            }
            $paciente->save();
            $dados['data'] = $request->input('data_marcar');
            $dados['plano_saude'] = $request->input('plano');
            $dados['especialidade_id'] = $request->input('especialidade');
            $dados['medico_id'] = $request->input('medico');
            $dados['horario'] = $request->input('horario_marcado');
            $dados['paciente_id'] = $paciente->id;
            $dados['marcou_user_id'] = Auth::id();
            $agenda = new Agenda($dados);
            $data = explode('/',$request->input('data_marcar'));
            if($agenda->save()){
                $msg = 'alert-success|Consulta marcada com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao marcar consulta! Se o erro persistir, entre em contato com o administrador.';
            }
        }catch(Throwable $e){
            report($e);
            $msg = 'alert-warning|Erro ao marcar consulta! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('agenda.index', ['dia' => $data[0],'mes'=>$data[1],'ano'=>$data[2]])->with('alertMessage', $msg);
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
        $agenda = Agenda::find($id);
        $horarios = $this->horariosDisponiveis($agenda->data, $agenda->medico_id, $agenda->especialidade_id);
        $idEspecialidade = $agenda->especialidade_id;
        $especialidades = Especialidade::whereHas('users', function ($query) {
            $query->whereNotNull('user_id');
        })->orderBy('nome')->pluck('nome', 'id')->prepend('Selecione...', '');
        $medicos = User::whereHas('especialidades', function ($query) use($idEspecialidade) {
            $query->where('especialidade_id', $idEspecialidade);
        })->orderBy('name')->pluck('name', 'id')->prepend('Selecione...', '');
        return view('agenda.edit',[
                                        'dataSelecionada' => $agenda->data, 
                                        'dados' => $agenda,
                                        'horarios' => $horarios,
                                        'especialidades' => $especialidades,
                                        'medicos' => $medicos
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
        try{
            if($request->input('paciente_id') != ''){ #Atualizar
                $paciente = Paciente::find($request->input('paciente_id'));
                $paciente->telefone = $request->input('telefone');
                $paciente->celular = $request->input('celular');
            }else{ # Insere
                $dadoPaciente['nome'] = strtoupper(removeAcentos($request->input('nome_paciente')));
                $dadoPaciente['telefone'] = $request->input('telefone');
                $dadoPaciente['celular'] = $request->input('celular');
                $paciente = new Paciente($dadoPaciente);
            }
            $paciente->save();
            $dados['data'] = $request->input('data_marcar');
            $dados['plano_saude'] = $request->input('plano');
            $dados['especialidade_id'] = $request->input('especialidade');
            $dados['medico_id'] = $request->input('medico');
            $dados['horario'] = $request->input('horario_marcado');
            $dados['paciente_id'] = $paciente->id;
            $dados['marcou_user_id'] = Auth::id();
            $data = explode('/',$request->input('data_marcar'));
            $agenda = Agenda::find($id);
            if($agenda->update($dados)){
                $msg = 'alert-success|Consulta alterada com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao alterar consulta! Se o erro persistir, entre em contato com o administrador.';
            }
        }catch(Throwable $e){
            report($e);
            $msg = 'alert-warning|Erro ao alterar consulta! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('agenda.index', ['dia' => $data[0],'mes'=>$data[1],'ano'=>$data[2]])->with('alertMessage', $msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $data = explode('/',$request->data);
            $agenda = Agenda::find($id);
            if($agenda->delete()){
                $msg = 'alert-success|Consulta excluída com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao excluir consulta! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Throwable  $e) {
            report($e);
            $msg = 'alert-warning|Erro ao excluir consulta! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('agenda.index', ['dia' => $data[0],'mes'=>$data[1],'ano'=>$data[2]])->with('alertMessage', $msg);
    }

    public function getMedicos($idEspecialidade)
    {
        $medicos = User::select('id', 'name')->whereHas('especialidades', function ($query) use($idEspecialidade) {
            $query->where('especialidade_id', $idEspecialidade);
        })->orderBy('name')->get();
        return response()->json($medicos);
    }

    public function alteraStatus(Request $request, $id)
    { 
        $timezone = User::find(Auth::id())->estado->timezone;   
        date_default_timezone_set($timezone);
        try {
            if(auth()->user()->medico == 'S'){
                $usuarioTipo = 'medico';
            }else{
                $usuarioTipo = 'secretaria';
            }
            $agenda = Agenda::find($id);
            $dados['agenda_status_id'] = $request->input('agenda_status_id');
            if($request->input('agenda_status_id') == 3){ # Presente
                $dados['hora_presenca'] = date('H:i:s');
            }
            if($agenda->update($dados)){
                broadcast(new AgendaStatusEvento($agenda,$usuarioTipo))->toOthers();
                $msg = 'alert-success|Status da consulta alterada com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao alterar status da consulta! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Throwable  $e) {
            report($e);
            $msg = 'alert-warning|Erro ao alterar status da consulta! Se o erro persistir, entre em contato com o administrador.';
        }
        $data = explode('/',$request->input('data'));
        return redirect()->route('agenda.index',['dia'=>$data[0],'mes'=>$data[1],'ano'=>$data[2]])->with('alertMessage', $msg);
    }

    public function atende()
    {

    }

    public function horariosDisponiveis($dataInformada, $medicoId, $especialidadeId)
    {
        if(!preg_match('/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/', $dataInformada)){
            return array();
        }
        $agendaConfig = AgendaConfig::first();
        $todosHorarios = intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        
        $data = Carbon::createFromFormat('d/m/Y', $dataInformada)->format('Y-m-d'); 
        $medico = $medicoId;
        $especialidades = $especialidadeId;

        $horariosMarcados = Agenda::select(DB::raw('substr(horario, 1, 5) as horario'))
                        ->where([['data', $data],['medico_id', $medico], ['especialidade_id', $especialidadeId]])
                        ->pluck('horario')->toArray();
        return ($horariosMarcados)? array_values(array_diff($todosHorarios, $horariosMarcados)): $todosHorarios;
    }

    public function ajaxHorariosDisponiveis(Request $request)
    {
        $horariosDisponiveis = $this->horariosDisponiveis($request->data, $request->medico, $request->especialidade);
        /*$agendaConfig = AgendaConfig::first();
        $todosHorarios = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        
        $data = Carbon::createFromFormat('d/m/Y', $request->data)->format('Y-m-d'); 
        $medico = $request->medico;
        $especialidades = $request->especialidade;

        $horariosMarcados = Agenda::select('horario')
                        ->where([['medico_id', $request->medico], ['especialidade_id', $request->especialidade]])
                        ->pluck('horario')->toArray();
        $horariosDisponiveis = array_values(array_diff($todosHorarios, $horariosMarcados));*/
        return response()->json($horariosDisponiveis);
    }

    public function pacienteBusca(Request $request)
    {
        $pacientesEncontrados = Paciente::select('id','nome','cpf','telefone','celular')
                                            ->where('nome','like',$request->dadoBusca.'%')
                                            ->orWhere('cpf','like',$request->dadoBusca.'%')
                                            ->orWhere('telefone','like',$request->dadoBusca.'%')
                                            ->orWhere('celular','like',$request->dadoBusca.'%')
                                            ->get();
        return response()->json($pacientesEncontrados);
    }
}
