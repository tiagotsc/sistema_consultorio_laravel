<?php

namespace App\Library;
/* Version 2.0 */

class SmsEmpresa {
  
    public $chavekey;
    public $message;
    public $type;
    public $to;	
    public $transfer;
	public $action;
	public $refer;	
	public $jobdate;	
	public $jobtime;		
    
    public function Envia()
    {
      $ch = curl_init();
	  
	  $data = array('key'           => $this->chavekey, 
				    'msg' 		    => $this->message,
				    'type' 		    => $this->type,
				    'number' 	    => $this->to,
				    'jobdate' 		=> $this->jobdate,
				    'jobtime' 		=> $this->jobtime,
				    'encode'        => '0',
				    );
	
	  curl_setopt($ch, CURLOPT_URL, 'http://api.smsempresa.com.br/send');
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
	  $res    = curl_exec ($ch);
	  $err    = curl_errno($ch);
	  $errmsg = curl_error($ch);
	  $header = curl_getinfo($ch);
		
	  curl_close($ch);
	 
      if ($res){
	    return $sms = new \SimpleXmlElement($res, LIBXML_NOCDATA);
	  }
    }

    public static function consultaReposta($chaveSms)
    {
        $url = 'http://api.smsempresa.com.br/get?key='.env('SMS_TOKEN').'&action=inbox&id='.$chaveSms;
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_URL, $url);
        $contents = curl_exec($c);

        $simple = $contents;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $simple, $vals, $index);
        xml_parser_free($p);

        curl_close($c);

        $resultado = false;
        foreach ($vals as $v) {

            if (isset($v['attributes']['ID'])) {

                $resultado['chave_sms'] = $v['attributes']['ID'];
                $resultado['situacao'] = $v['attributes']['SITUACAO'];
                $resultado['data_envio'] = $v['attributes']['DATA_READ'];
                $resultado['celular'] = $situacao = $v['attributes']['TELEFONE'];
                $resultado['resposta'] = $v['value'];

            }

        }

        if ($resultado) {
            return $resultado;
        } else {
            return false;
        }

    }
	
	
	/**Acho que verifica resposta do SMS (Testar para ver se é isso) */
    public function Query()
    {
      $ch = curl_init();
	  
	  $data = array('key'           => $this->chavekey, 
				    'action' 		=> $this->action,
				    'id' 		    => $this->refer,
				    );
	
	  curl_setopt($ch, CURLOPT_URL, 'http://api.smsempresa.com.br/get');
	  curl_setopt($ch, CURLOPT_POST, 1);
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
	  $res    = curl_exec ($ch);
	  $err    = curl_errno($ch);
	  $errmsg = curl_error($ch);
	  $header = curl_getinfo($ch);
		
	  curl_close($ch);
      if ($res){
	    return $sms = new SimpleXmlElement($res, LIBXML_NOCDATA);
      }
      
    }  

    public static function consultaSaldo()
    {
        $ch = curl_init();

        $data = array('key'         => env('SMS_TOKEN'), 
                    'action'      => 'saldo');

        curl_setopt($ch, CURLOPT_URL, 'http://api.smsempresa.com.br/get');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $res    = curl_exec ($ch);
        $err    = curl_errno($ch);
        $errmsg = curl_error($ch);
        $header = curl_getinfo($ch);

        curl_close($ch);
        $res = new \SimpleXmlElement($res, LIBXML_NOCDATA);
        $resp['situacao'] = $res->retorno['situacao'];
        $resp['saldo_sms'] = $res->retorno['saldo_sms'];
        $resp['saldo_voz'] = $res->retorno['saldo_voz'];
        $resp['saldo_email'] = $res->retorno['saldo_email'];

        return $resp;
    }
}  

?>