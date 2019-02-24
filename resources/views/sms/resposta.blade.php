@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-12">
            <h5>Consultas pendentes de resposta</h5>
        </div>
    </div>
    <hr> 
    {!! Form::open(['id' => 'frm', 'route' => 'sms.verificar']) !!}
    <table id="frm-pesq" class="table">
        <thead>
            <tr>
                <th>Data - hora</th>
                <th>Doutor(a) - Especialidade</th>
                <th>Paciente</th>
                <th>Status</th>
                <th>Resposta</th>
            </tr>
        </thead>
        <tbody>
            @if($dados->count() > 0)
            @php $cont = 0; @endphp
            @foreach($dados as $dado)
            <tr>
                <td>
                    <input type="hidden" name="agenda_id[]" value="{{$dado->id}}">
                    {{$dado->data}} - {{$dado->horario}}
                </td>
                <td>{{$dado->medico->name}} - {{$dado->Especialidade->nome}}</td>
                <td>{{$dado->paciente->nome}}</td>
                <td>{{$dado->status->nome}}</td>
                <td>{{$dado->sms->sms_resposta}}</td>
            </tr>
            @php $cont++; @endphp
            @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center">Nenhuma consulta pendente de resposta</td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="text-right marginTop">
    {!! Form::button('Verificar respostas', ['id' => 'verificar', 'class' => 'btn btn-primary','data-toggle' => 'modal', 'data-target' => '#confirmaSms']); !!}
    </div>
    {!! Form::close() !!}
</div>
@endsection
@section('footerScrits')
@parent
<script src="{{ asset('js/sms/resposta.js') }}"></script>
@endsection