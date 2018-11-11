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