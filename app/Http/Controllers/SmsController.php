<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Agenda;
use App\AgendaSms;
use App\Library\SmsEmpresa;
use DB;
use Illuminate\Support\Facades\Auth;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pendentesEnvio()
    {
        $saldo = SmsEmpresa::consultaSaldo();

        $timezone = User::find(Auth::id())->estado->timezone;   
        date_default_timezone_set($timezone);
        $dataHoje = date('Y-m-d');
        $agendaProximaData = Agenda::where('data','>',$dataHoje)->select('data')->orderBy('data')->first();
        if($agendaProximaData != null){
            $agenda = Agenda::where([
                                        ['data',$agendaProximaData->getOriginal('data')],
                                        ['agenda_status_id',1],
                                        ['envio_sms','N']
                                        ])
                                ->whereHas('paciente', function ($query) {
                                    $query->whereNotNull('celular')
                                            ->where('celular','!=', '');;
                                })
                                ->orderBy('horario')->get();
        }else{
            $agenda = null;
        }
        return view('sms.pendentes',[
                                    'dados' => $agenda, 
                                    'data' => $dataHoje, 
                                    'dataFormatada' => ($agendaProximaData)? $agendaProximaData->data : null,
                                    'saldo' => $saldo
                                    ]);
    }

    public function enviando(Request $request)
    {
        try {
            $SmsEmpresa = new SmsEmpresa();
            $SmsEmpresa->chavekey = env('SMS_TOKEN'); // Chave de acesso.
            #$SmsEmpresa->message = 'Voce tem uma consulta marcada em #04/12/2018# as #09:00# com o dr(a) #Roberto#\nResponda SIM para confirmar ou NAO para desmarcar.'; // Texto da mensagem a ser enviada.
            $SmsEmpresa->type = "9"; // Tipo da mensagem. 0-Sms ; 1-Voz.
            /*$SmsEmpresa->to = '21985854033'; // Telefone do destinatário com ddd.
            #$SmsEmpresa->transfer = "21986422683"; 				   // Número para transferência ao fim da chamada (Aplicável somente para type = 1 (Voz))
            $resultado = $SmsEmpresa->Envia();
            */

            $agendaIds = $request->input('agenda_id');
            $celulares = $request->input('celular');
            $msgs = $request->input('msg');
            if($agendaIds != null){
                $dados = array();
                $cont = 0;
                foreach($agendaIds as $agendaId){

                    $SmsEmpresa->to = formataCelularApi('21985854033'); // Telefone do destinatário com ddd.
                    $SmsEmpresa->message = $msgs[$agendaId];
                    $resultado = $SmsEmpresa->Envia();

                    $dados[$cont]['sms_chave'] = $resultado->retorno['id'];
                    $dados[$cont]['celular'] = $celulares[$agendaId];
                    $dados[$cont]['msg'] = $msgs[$agendaId];
                    $dados[$cont]['sms_status'] = $resultado->retorno['situacao'];
                    $dados[$cont]['agenda_id'] = $agendaId;
                    $dados[$cont]['created_at'] = now();
                    $dados[$cont]['updated_at'] = now();
                    $cont++;

                }
                DB::table('agenda_sms')->insert($dados);
                Agenda::whereIn('id',$agendaIds)->update(['envio_sms' => 'S']);
                $msg = 'alert-success|'.$cont.' sms enviado(s) com sucesso!';
            }else{
                $msg = 'alert-warning|Nenhum sms foi enviado!';
            }
        } catch (Throwable $e) {
            report($e);
            $msg = 'alert-warning|Erro ao enviar sms! Se o erro persistir, entre em contato com o administrador.';
        }
        return redirect()->route('sms.pendentes')->with('alertMessage', $msg);
    }

    public function resposta()
    {
        $timezone = User::find(Auth::id())->estado->timezone;   
        date_default_timezone_set($timezone);
        $dataHoje = date('Y-m-d');
        $pendentesResposta = Agenda::where([
                                                ['data','>=',$dataHoje],
                                                ['envio_sms','S'],
                                                ])
                                        ->whereHas('paciente', function ($query) {
                                            $query->whereNotNull('celular')
                                                    ->where('celular','!=', '');
                                        })
                                        ->whereHas('sms', function ($query) {
                                            $query->whereNull('sms_resposta');
                                        })
                                        ->orderBy('horario')->get();
        #dd($pendentesResposta[0]->sms);
        return view('sms.resposta',['dados' => $pendentesResposta]);
    }

    public function verificandoResposta(Request $request)
    {
        $agendaIds = $request->input('agenda_id');
        $AgendaSms = AgendaSms::whereIn('agenda_id', $agendaIds)->get();
        $respostaSim = array();
        $respostaNao = array();
        foreach($AgendaSms as $sms){
            $resultado = SmsEmpresa::consultaReposta($sms->sms_chave);
            if($resultado){
                $resposta = formataRespostaSMS($resultado['resposta']);
                if($resposta == 'NAO'){
                    $respostaNao[] = $sms->agenda_id;
                }else{
                    $respostaSim[] = $sms->agenda_id;
                }
            }
        }
        AgendaSms::whereIn('agenda_id', $respostaNao)->update(['sms_resposta' => 'NAO']);
        AgendaSms::whereIn('agenda_id', $respostaSim)->update(['sms_resposta' => 'SIM']);
        if(count($respostaNao) > 0){
            Agenda::whereIn('id',$respostaNao)->update(['agenda_status_id' => 2]);
        }
        $msg = 'alert-success|'.count($respostaSim).' pacientes confirmaram e '.count($respostaNao).' desmarcaram!';
        return redirect()->route('sms.resposta')->with('alertMessage', $msg);
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
        //
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
