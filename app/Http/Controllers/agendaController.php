<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AgendaConfig;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataEscolhida = $request->dia.'/'.$request->mes.'/'.$request->ano;
        return view('agenda.index', ['data' => $dataEscolhida, 'tipo' => $request->tipo]);
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
    
    /**
     * Tela de marcar consulta
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function marcar(Request $request)
    {
        $agendaConfig = AgendaConfig::first();
        $horas = $this->intervaloHoras($agendaConfig->inicio.':00:00',$agendaConfig->fim.':00:00', $agendaConfig->intervalo);
        return view('agenda.marcar',['dataSelecionada' => $request->input('valores'), 'horas' => $horas]);
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
        $inicio = DateTime::createFromFormat('H:i:s', $horaInicio);
        // PARA O PHP 5.2
        // $inicio = date_create_from_format('H:i:s', $inicio);
         
        $fim = DateTime::createFromFormat('H:i:s', $horaFim);
        // $fim = date_create_from_format('H:i:s', $fim);
     
        $intervalo = $inicio->diff($fim);
     
        // Formata a diferença de horas para
        // aparecer no formato 00:00:00 na página
        return $intervalo->format('%H:%I:%S');
    
    }
}
