<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8"/>
    <title>Receita Médica</title>
    <link rel="stylesheet" href="{{ asset('css/receita.css') }}">
</head>
<!--<body onload="window.print()">-->
<body>
    <p class="logo">Medi<span>+</span>  </p>
    <hr />
    <div class="cabecalho">
        <p class="doutor">Dr(a): {{$agenda->medico->name}}</p>
        <p class="endereco">
            <b>Endereço:</b> {{$unidade->endereco}}, {{$unidade->numero}} 
            @if($unidade->complemento)- {{$unidade->complemento !=''}} @endif <br>
            <b>Bairro: </b> {{$unidade->bairro}} - {{$unidade->estado->nome}}<br>
            @if($unidade->email != '')<b>Email: </b>{{$unidade->email}} @endif <br>
            @if($unidadeTelefone != '')<b>Telefones: </b>{{$unidadeTelefone}} @endif
        </p>
    </div>
    <hr />
    <div class="paciente">
        <strong>Paciente: {{$agenda->paciente->nome}}</strong>
    </div>
    <hr />
    <div class="receita">
        <p>{!!$receita->descricao!!}</p>
    </div>
    <p class="assinatura">{{$agenda->medico->name}}</p>
</body>
</html>