<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agenda;
use App\Receita;
use App\User;
use App\Paciente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\AgendaStatusEvento;
use DB;
use \Mpdf\Mpdf;

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
        $historico = Agenda::where([
                                ['id','!=',$agenda->id],
                                #['medico_id', $agenda->medico_id],
                                ['especialidade_id', $agenda->especialidade_id],
                                ['agenda_status_id','!=',2]
                                ])
                                ->orderBy('data','desc')
                                ->orderBy('horario','desc')
                                ->get();
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
        return view('atendimento.edit',['dados' => $agenda, 'historico' => $historico]);
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
            $timezone = User::find(Auth::id())->estado->timezone;   
            date_default_timezone_set($timezone);
            $data = explode('/',$request->input('data_consulta'));
            $agenda = Agenda::find($id);
            $agenda->agenda_status_id = 6; # Finalizado
            $agenda->hora_fim = date('H:i:s');
            $agenda->medico_anotacoes = $request->input('medico_anotacoes');
            if($agenda->save()){
                if($request->input('receita') != null){
                    $receitas = array();
                    foreach($request->input('receita') as $receita){
                        $receitas[] = array('descricao' => $receita);
                    }
                    $agenda->receitas()->delete();
                    $agenda->receitas()->createMany($receitas);
                }
                broadcast(new AgendaStatusEvento($agenda,'medico'))->toOthers();
                $msg = 'alert-success|Consulta concluída com sucesso!';
            }else{
                $msg = 'alert-warning|Erro ao concluir consulta! Se o erro persistir, entre em contato com o administrador.';
            }
        } catch (Throwable  $e) {
            report($e);
            $msg = 'alert-warning|Erro ao concluir consulta! Se o erro persistir, entre em contato com o administrador.';
        }
        #return redirect()->route('agenda.index', ['dia' => $data[0],'mes'=>$data[1],'ano'=>$data[2]])->with('alertMessage', $msg);
        return redirect()->route('atendimento.edit', [$agenda->id])->with('alertMessage', $msg);
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

    public function receitaImprimir($agenda, $receita)
    {
        $mpdf = new Mpdf();
        $dados = Receita::find($receita);
        $agenda = Agenda::find($agenda);
        $unidade = $agenda->medico->unidades->first();
        $telefones = $agenda->medico->unidades->first()->telefones->pluck('telefone')->toArray();
        $unidadeTelefone = ($telefones)? implode(' / ',$telefones): '';

        $receita = view('atendimento.receita',[
                                                'agenda' => $agenda, 
                                                'receita' => $dados,
                                                'unidade' => $unidade,
                                                'unidadeTelefone' => $unidadeTelefone
                                                ]);
        $mpdf->WriteHTML($receita);
        $mpdf->Output();
        #$mpdf->Output('receita_'.date('m-Y-h-i-s').'.pdf',base_path('/public/receitas/')); #Armazenar num diretório
    }
}
