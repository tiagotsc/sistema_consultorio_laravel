<?php
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
function intervaloHoras($horaInicio, $horaFim, $minutos){

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
function diferencaHora($horaInicio, $horaFim){
        
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

function removeAcentos($string) {
    
    $string = htmlentities($string, ENT_COMPAT, 'UTF-8');
    $string = preg_replace('/&([a-zA-Z])(uml|acute|grave|circ|tilde|cedil);/', '$1',$string);
    return $string;
    
}

function getTimezone($siglaEstado){

    $timezones = array(
        'AC' => 'America/Rio_branco',   'AL' => 'America/Maceio',
        'AP' => 'America/Belem',        'AM' => 'America/Manaus',
        'BA' => 'America/Bahia',        'CE' => 'America/Fortaleza',
        'DF' => 'America/Sao_Paulo',    'ES' => 'America/Sao_Paulo',
        'GO' => 'America/Sao_Paulo',    'MA' => 'America/Fortaleza',
        'MT' => 'America/Cuiaba',       'MS' => 'America/Campo_Grande',
        'MG' => 'America/Sao_Paulo',    'PR' => 'America/Sao_Paulo',
        'PB' => 'America/Fortaleza',    'PA' => 'America/Belem',
        'PE' => 'America/Recife',       'PI' => 'America/Fortaleza',
        'RJ' => 'America/Sao_Paulo',    'RN' => 'America/Fortaleza',
        'RS' => 'America/Sao_Paulo',    'RO' => 'America/Porto_Velho',
        'RR' => 'America/Boa_Vista',    'SC' => 'America/Sao_Paulo',
        'SE' => 'America/Maceio',       'SP' => 'America/Sao_Paulo',
        'TO' => 'America/Araguaia',    
        );
    return $timezones[$siglaEstado];
}


function formataData($data, $tipo = 'BR'){

    if($tipo == 'USA'){
        if(strlen($data) > 10){
            $inicio = explode(' ', $data);
            $data = implode('-',array_reverse(explode('/', $inicio[0]))).' '.$inicio[1];
        }else{
            $data = implode('-',array_reverse(explode('/', $data)));
        }
    }else{
        if(strlen($data) > 10){ 
            $inicio = explode(' ', $data);
            $data = implode('/',array_reverse(explode('-', $inicio[0]))).' '.$inicio[1];
        }else{
            $data = implode('/',array_reverse(explode('-', $data)));
        }
    }
    return $data;
}