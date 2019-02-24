@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row justify-content-end">
        <div class="col-md-9">
                <h5>Enviar sms para consulta da data {{$dataFormatada}}</h5>
                </div>
        <div class="col-md-3 col align-self-end">
            <label>Saldo de SMS
            <input type="text" class="form-control" disabled value="{{$saldo['saldo_sms']}}">
            </label>
        </div>
    </div>
    <hr>  
    {!! Form::open(['id' => 'frm', 'route' => 'sms.enviar']) !!}
    <table id="frm-pesq" class="display" width="100%">
        <thead>
            <tr>
                <th class="text-center"><input type="checkbox" id="todos"></th>
                <th>Horário</th>
                <th>Doutor(a)</th>
                <th>Especialidade</th>
                <th>Paciente</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @if($dados != null and $dados->count() > 0)
            @php $cont = 0; @endphp
            @foreach($dados as $dado)
            <tr>
            <td class="text-center">
                <input type="checkbox" class="check_individual" name="agenda_id[{{$dado->id}}]" value="{{$dado->id}}">
                <input type="hidden" class="desativados" disabled name="celular[{{$dado->id}}]" value="{{$dado->paciente->celular}}">
                <input type="hidden" class="desativados" disabled name="msg[{{$dado->id}}]" value="Voce tem uma consulta marcada em {{$dado->data}} as {{$dado->horario}}  com o dr(a) {{$dado->medico->name}}\nResponda SIM para confirmar ou NAO para desmarcar.">
            </td>
                <td>{{$dado->horario}}</td>
                <td>{{$dado->medico->name}}</td>
                <td>{{$dado->Especialidade->nome}}</td>
                <td>{{$dado->paciente->nome}}<br>Celular: {{$dado->paciente->celular}}</td>
                <td>{{$dado->status->nome}}</td>
            </tr>
            @php $cont++; @endphp
            @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center">Nenhuma consulta pendente de confirmação</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="text-right marginTop">
    {!! Form::button('Enviar SMS', ['id' => 'enviar', 'class' => 'btn btn-primary','data-toggle' => 'modal', 'data-target' => '#confirmaSms']); !!}
    </div>
    {!! Form::close() !!}
</div>
<div id="confirmaSms" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Deseja enviar sms confirmando a consulta?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Serão enviados <b id="qtd_sms">0</b> sms.</p>
            </div>
            <div class="modal-footer">
                <button id="confirmar" type="button" class="btn btn-primary">Confirmar e enviar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('footerScrits')
@parent
<script src="{{ asset('js/sms/pendentes.js') }}"></script>
@endsection