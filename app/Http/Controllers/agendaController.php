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
use App\Unidade;
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
        $dia = $request->dia; $mes = $request->mes; $ano = $request->ano;
        if($request->dia == null or $request->mes == null or $request->ano === null){
            $timezone = User::find(Auth::id())->estado->timezone;   
            date_default_timezone_set($timezone);
            $dia = date('d'); $mes = date('m'); $ano = date('Y');
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
        $AgendaStatus = AgendaStatus::pluck('nome','id');
        $agendaConfig = AgendaConfig::first();
        #$horas = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        $horas = DB::table('agendas')->distinct()->select(DB::raw('substr(horario, 1, 5) as horario'))->orderBy('horario')->pluck('horario','horario')->prepend('', '');
        $dataEscolhida = $dia.'/'.$mes.'/'.$ano;
        $unidadeUser = DB::table('unidade_users')->where('user_id',Auth::id())->pluck('unidade_id')->toArray();
        $unidades = Unidade::where('status','A')->whereIn('id',$unidadeUser)->orderBy('nome')->pluck('nome','id');
        $unidadeSession = $request->session()->get('unidade_session', DB::table('unidade_users')->where('user_id',Auth::id())->first()->unidade_id);
        return view('agenda.index', [
                                        'data' => $dataEscolhida, 
                                        'tipo' => ucfirst($usuarioTipo), 
                                        'horas' => $horas, 
                                        'agendaStatus' => $AgendaStatus, 
                                        'userId' => Auth::id(),
                                        'unidades' => $unidades,
                                        'unidadeSession' => $unidadeSession,
                                        'todasSequencias' => json_encode($todasSequencias)
                                    ]);
    }

    public function getpesq(Request $request){
        
        if(auth()->user()->medico == 'S'){
            $idMedico = Auth::id();
        }else{
            $idMedico = false;
        }
        $buscar = $request->input('input_dado');
        $horario = $request->input('horario');
        $unidade = $request->input('unidade');
        $data = formataData($request->input('data'),'USA');
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
                        );
        if($idMedico){
            $dados = $dados->where('agendas.medico_id',$idMedico);
        }
        $dados = $dados->where('agendas.data',$data)
                        ->where('agendas.unidade_id', $unidade)
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
        $unidadeUsuarioUnica = DB::table('unidade_users')->where('user_id', Auth::id())->first()->unidade_id;
        $especialidades = Especialidade::whereHas('users', function ($query) use($unidadeUsuarioUnica) {
           $query->whereNotNull('users_especialidades.user_id');
           $query->whereIn('users_especialidades.user_id',function($query) use($unidadeUsuarioUnica) {
            $query->select('unidade_users.user_id')->from('unidade_users')->where('unidade_users.unidade_id', $unidadeUsuarioUnica);
            });
        })->orderBy('nome')->pluck('nome', 'id')->prepend('Selecione...', '');
        $data = $request->input('valores');
        if($data < date('d/m/Y')){
            $data = date('d/m/Y');
        }
        $unidades = Unidade::where('status','A')->orderBy('nome')->pluck('nome','id')->prepend('Selecione...', '');
        #$agendaConfig = AgendaConfig::first();
        #$horas = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        return view('agenda.create',[
                                        'dataSelecionada' => $data, 
                                        #'horas' => $horas,
                                        'especialidades' => $especialidades,
                                        'unidades' => $unidades,
                                        'unidadeUsuarioUnica' => $unidadeUsuarioUnica
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
            $dados['unidade_id'] = $request->input('unidade_id');
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
        $unidades = Unidade::where('status','A')->orderBy('nome')->pluck('nome','id');
        return view('agenda.edit',[
                                        'dataSelecionada' => $agenda->data, 
                                        'dados' => $agenda,
                                        'horarios' => $horarios,
                                        'especialidades' => $especialidades,
                                        'medicos' => $medicos,
                                        'unidades' => $unidades
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
            $dados['unidade_id'] = $request->input('unidade_id');
            $data = explode('/',$request->input('data_marcar'));
            $agenda = Agenda::find($id);
            if($agenda->agenda_status_id == 2){ # Desistiu
                $dados['agenda_status_id'] = 1; # Marcado
            }
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
                        ->where([
                                    ['data', $data],
                                    ['medico_id', $medico], 
                                    ['agenda_status_id','!=',2] # Desistiu
                                    #['especialidade_id', $especialidadeId]
                                ])
                        ->pluck('horario')->toArray();
        return ($horariosMarcados)? array_values(array_diff($todosHorarios, $horariosMarcados)): $todosHorarios;
    }

    public function ajaxHorariosDisponiveis(Request $request)
    {
        $horariosDisponiveis = $this->horariosDisponiveis($request->data, $request->medico, $request->especialidade);
        return response()->json($horariosDisponiveis);
    }

    public function ajaxEspecialidades($unidade = null)
    {
        if($unidade != null){
            $especialidades = Especialidade::whereHas('users', function ($query) use($unidade) {
                $query->whereNotNull('users_especialidades.user_id');
                $query->whereIn('users_especialidades.user_id',function($query) use($unidade) {
                 $query->select('unidade_users.user_id')->from('unidade_users')->where('unidade_users.unidade_id', $unidade);
                 });
             })->orderBy('nome')->get();
        }else{
            $especialidades = array();
        }
        return response()->json($especialidades);
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

    public function estatistica($dia = null, $mes = null, $ano = null, $unidade = null)
    {
        $data = $ano.'-'.$mes.'-'.$dia;
        if($dia == null or $mes == null or $ano === null){
            $timezone = User::find(Auth::id())->estado->timezone;   
            date_default_timezone_set($timezone);
            $data = date('Y-m-d');
        }
        #$data = '2018-12-15';
        $resultado = DB::table('agendas')
                    ->select(
                                DB::raw('count(*) as total'),
                                DB::raw("(select count(*) from agendas as sec where sec.agenda_status_id = 6 and sec.data = '".$data."') as atendidos"), # Finalizados
                                DB::raw("(select count(*) from agendas where agenda_status_id = 1 and data = '".$data."') as ausentes"), # Marcados, pois ainda não chegaram
                                DB::raw("(select count(*) from agendas where agenda_status_id = 2 and data = '".$data."') as desistiu") # Desistiu
                            )
                    ->where('data',$data);
        if($unidade != null){
            $resultado = $resultado->where('unidade_id', $unidade);
        }else{
            $unidadeSession = session('unidade_session', DB::table('unidade_users')->where('user_id',Auth::id())->first()->unidade_id);
            $resultado = $resultado->where('unidade_id', $unidadeSession);
        }
                    #->whereNotIn('agenda_status_id',[2])
        $resultado = $resultado->first(); # Status != Desistiu
        $dados = array('total'=> 0, 'porc_atendidos'=> 0, 'porc_ausentes'=> 0, 'porc_desistiu'=> 0, 'data' => formataData($data));
        if($resultado->total != 0){
            $dados['total']             = $resultado->total;
            $dados['porc_atendidos']    = round(($resultado->atendidos / $resultado->total) * 100,2);
            $dados['porc_ausentes']     = round(($resultado->ausentes / $resultado->total) * 100,2);
            $dados['porc_desistiu']     = round(($resultado->desistiu / $resultado->total) * 100,2);
            $dados['data']              = formataData($data);
        }
        return response()->json($dados);
    }

    public function ajaxAgendamentosUnidade(Request $request, $unidadeId = null)
    {
        if($unidadeId != null){
            $request->session()->put('unidade_session', $unidadeId);
            $user = User::findOrFail(Auth::id());
            $timezone = $user->estado->timezone;
            date_default_timezone_set($timezone);
            $agendamentos = Agenda::select(DB::raw('data as data_db'),DB::raw('count(*) as count'))
                                    ->where([
                                                ['agenda_status_id','!=',2],
                                                ['unidade_id', $unidadeId],
                                                ['data','>',date("Y-m-d", strtotime("-6 months"))]
                                            ])
                                    ->groupBy('data')
                                    ->get();
            if($agendamentos != null){
                foreach($agendamentos as $agendamento){
                    $agenda[$agendamento->data_db] = array('number' => $agendamento->count, 'badgeClass' => 'badge-warning');
                }
            }
        }
        $agenda[date('Y-m-d')]['class'] = 'calendarHoje';
        return response()->json($agenda);
    }
}
