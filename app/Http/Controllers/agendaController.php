<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgendaConfig;
use App\Especialidade;
use App\User;
use App\Agenda;
use App\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $agendaConfig = AgendaConfig::first();
        #$horas = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        $horas = DB::table('agendas')->distinct()->select(DB::raw('substr(horario, 1, 5) as horario'))->orderBy('horario')->pluck('horario','horario')->prepend('', '');
        $dataEscolhida = $request->dia.'/'.$request->mes.'/'.$request->ano;
        return view('agenda.index', ['data' => $dataEscolhida, 'tipo' => $request->tipo, 'horas'=> $horas]);
    }

    public function getpesq(Request $request){
        /*$dados = Paciente::select('id','matricula','nome','cpf','rg','telefone','celular','status')
                            #->where('horario','like',$request->input('horario').'%')
                            ->where('nome','like','%'.$request->input('input_dado').'%')
                            ->orWhere('cpf','like','%'.$request->input('input_dado').'%')
                            ->orWhere('rg','like','%'.$request->input('input_dado').'%')
                            ->orWhere('telefone','like','%'.$request->input('input_dado').'%')
                            ->orWhere('celular','like','%'.$request->input('input_dado').'%')
                            ->get();*/
        $buscar = $request->input('input_dado');
        $horario = $request->input('horario');
        $dados = Agenda::join('pacientes', 'pacientes.id', '=', 'agendas.paciente_id')
                        ->select('agendas.id','agendas.horario','pacientes.matricula','pacientes.nome','pacientes.cpf','pacientes.rg','pacientes.telefone','pacientes.celular','pacientes.status')
                        ->where('agendas.horario','like',$horario.'%')
                        ->where(function ($query) use($buscar) {
                            $query->where('pacientes.nome','like','%'.$buscar.'%')
                            ->orWhere('pacientes.cpf','like','%'.$buscar.'%')
                            ->orWhere('pacientes.rg','like','%'.$buscar.'%')
                            ->orWhere('pacientes.telefone','like','%'.$buscar.'%')
                            ->orWhere('pacientes.celular','like','%'.$buscar.'%');
                        })
                        
                        ->get();#echo '<pre>';
                        #print_r($dados); exit();
        return json_encode(array('data' => $dados));
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
        #$agendaConfig = AgendaConfig::first();
        #$horas = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        return view('agenda.create',[
                                        'dataSelecionada' => $request->input('valores'), 
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
    {   try{
            if($request->input('paciente_id') != ''){ #Atualizar
                $paciente = Paciente::find($request->input('paciente_id'));
                $paciente->telefone = $request->input('telefone');
                $paciente->celular = $request->input('celular');
            }else{ # Insere
                $dadoPaciente['nome'] = strtoupper($this->removeAcentos($request->input('nome_paciente')));
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
        return redirect()->route('agenda.index', ['tipo'=>'secretaria','dia' => $data[0],'mes'=>$data[1],'ano'=>$data[2]])->with('alertMessage', $msg);
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
        $idEspecialidade = $agenda->especialidade_id;
        #echo '<pre>'; print_r($agenda);exit();
        $especialidades = Especialidade::whereHas('users', function ($query) {
            $query->whereNotNull('user_id');
        })->orderBy('nome')->pluck('nome', 'id')->prepend('Selecione...', '');
        $medicos = User::whereHas('especialidades', function ($query) use($idEspecialidade) {
            $query->where('especialidade_id', $idEspecialidade);
        })->orderBy('name')->pluck('name', 'id')->prepend('Selecione...', '');
        #$agendaConfig = AgendaConfig::first();
        #$horas = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        return view('agenda.edit',[
                                        'dataSelecionada' => $agenda->data, 
                                        'dados' => $agenda,
                                        #'horas' => $horas,
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

    public function getMedicos($idEspecialidade)
    {
        $medicos = User::select('id', 'name')->whereHas('especialidades', function ($query) use($idEspecialidade) {
            $query->where('especialidade_id', $idEspecialidade);
        })->orderBy('name')->get();
        return response()->json($medicos);
    }

    public function getHorariosDisponiveis(Request $request)
    {
        $agendaConfig = AgendaConfig::first();
        $todosHorarios = $this->intervaloHoras($agendaConfig->inicio.':00',$agendaConfig->fim.':00', $agendaConfig->intervalo);
        
        $data = Carbon::createFromFormat('d/m/Y', $request->data)->format('Y-m-d'); 
        $medico = $request->medico;
        $especialidades = $request->especialidade;

        $horariosMarcados = Agenda::select('horario')
                        ->where([['medico_id', $request->medico], ['especialidade_id', $request->especialidade]])
                        ->pluck('horario')->toArray();
        $horariosDisponiveis = array_values(array_diff($todosHorarios, $horariosMarcados));
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

    /**
     * Util::intervaloHoras()
     * 
     * Retorna todos os horários encontrados encima dos minutos informados
     * 
     * @param mixed $horaInicio Hora inicial para iniciar intervalos
     * @param mixed $horaFim Hora fim para iniciar intervalos
     * @param mixed $minutos Minutos que será utilizados para gerar intervalos
     * @return Horários encontrados dentro do intervalos
     */
    public function intervaloHoras($horaInicio, $horaFim, $minutos){
    
        //Hora início
        $inicio 		= new \DateTime($horaInicio);
     
        //Hora fim
        $fim 		= new \DateTime($horaFim);
     
        //Pega todos os horários/intervalos de acordo com os minutos informados
        $horarios = array();
        while($inicio <= $fim){
            $horarios[] = $inicio->format('H:i');
            $inicio = $inicio->modify('+ '.$minutos.' minutes');
        }
        return $horarios;
    }

    /**
     * Util::diferencaHora()
     * 
     * Retorna a diferença das horas informadas
     * 
     * @param mixed $horaInicio Hora inicial para subtração
     * @param mixed $horaFim Hora final para subatração
     * @return A direfença das horas
     */
    public function diferencaHora($horaInicio, $horaFim){
         
        // Converte as duas datas para um objeto DateTime do PHP
        // PARA O PHP 5.3 OU SUPERIOR
        $inicio = \DateTime::createFromFormat('H:i:s', $horaInicio);
        // PARA O PHP 5.2
        // $inicio = date_create_from_format('H:i:s', $inicio);
         
        $fim = \DateTime::createFromFormat('H:i:s', $horaFim);
        // $fim = date_create_from_format('H:i:s', $fim);
     
        $intervalo = $inicio->diff($fim);
     
        // Formata a diferença de horas para
        // aparecer no formato 00:00:00 na página
        return $intervalo->format('%H:%I:%S');
    
    }

    public function removeAcentos($string) {
	   
        $string = htmlentities($string, ENT_COMPAT, 'UTF-8');
        $string = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/', '$1',$string);
		return $string;
		
	}
}
