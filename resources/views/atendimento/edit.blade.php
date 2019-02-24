@extends('./layout.master')

@section('headerCss')
@parent
<link rel="stylesheet" href="{{ asset('plugin/jqueryte/jquery-te-1.4.0.css') }}">
@endsection

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h5>Atendimento</h5>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('agenda.index') }}">Voltar para agenda</a>
        </div>
    </div>
    <hr>
    {!! Form::model($dados, ['route' => ['atendimento.update', $dados->id], 'method' => 'put', 'id' => 'frm', 'class' => 'form']) !!}
    <div class="row">
        <div class="col-md-12">
            <h6><strong>{{$dados->data}} às {{$dados->horario}}</strong></h6>
            <table class="table">
                <tr>
                    <th>Paciente</th>
                    <th>Médico</th>
                    <th>Especialidade</th>
                </tr>
                <tr>
                    <td>{{$dados->paciente->matricula}} - {{$dados->paciente->nome}}</td>
                    <td>{{$dados->medico->name}}</td>
                    <td>{{$dados->especialidade->nome}}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
        {!! Form::label('medico_anotacoes', 'Anotações') !!}<span class="obrigatorio">*</span>
        {!! Form::textarea('medico_anotacoes', old('medico_anotacoes'), ['class' => 'form-control word', 'rows' => 8, 'placeholder' => 'Preencha...']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="#" id="add_receita">Adicionar receita <i class="fas fa-plus"></i></a>
        </div>
    </div>
    <div id="receitas" class="row">
    @if($dados->receitas->count() > 0)
        @foreach ($dados->receitas as $receita)
        <div class="form-group col-md-12">
        {!! Form::label('receita['.$receita->id.']', 'Receita') !!}<span class="obrigatorio">*</span>
        {!! Form::textarea('receita['.$receita->id.']', $receita->descricao, ['class' => 'form-control word', 'rows' => 8, 'placeholder' => 'Preencha...']) !!}
        <a href="#" class="remove_receita"><i title="Remover receita. Obs: Depois clique em 'Salvar' para confirmar remoção." data-toggle="tooltip" data-placement="bottom" class="fas fa-minus-circle fa-lg"></i></a>  
        <a class="floatRight imprimir_receita" receita="{{$receita->id}}" href="{{route('receita.imprimir',['agenda' => $dados->id ,'receita' => $receita->id])}}" target="_blank"><i title="Imprimir receita" data-toggle="tooltip" data-placement="bottom" class="fas fa-print fa-lg"></i></a>
        </div>
        @endforeach
    @endif
    </div>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {!! Form::button('Salvar', ['id' => 'salvar', 'class' => 'btn btn-primary']); !!}
        </div>
    </div>
    <input type="hidden" name="data_consulta" value="{{$dados->data}}">
    {!! Form::close() !!}
    @php $i = 0; @endphp
    <div class="row">
        <div class="col-md-12">
            @foreach ($historico as $hist)
            <div class="card">
                <div data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="true" aria-controls="collapse{{$i}}" class="card-header accordionAba" id="heading{{$i}}">
                    <h5 class="mb-0">
                        {{$hist->data}} às {{$hist->horario}}
                    </h5>
                    <h6>Dr(a): {{$hist->medico->name}} - {{$hist->especialidade->nome}}</h6>
                </div>
                <div id="collapse{{$i}}" class="collapse show" aria-labelledby="heading{{$i}}" data-parent="#accordion">
                    <div class="card-body">
                        <h6><strong>Anotações</strong></h6>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <p>{!!$hist->medico_anotacoes!!}</p>
                            </li>
                        </ul>
                        @if($hist->receitas->count() > 0)
                        <br>
                        <h6><strong>Receita(s)</strong></h6>
                        @foreach ($hist->receitas as $receita)
                        <ul class="list-group">
                            <li class="list-group-item">
                            <h6>Receita</h6>
                            <a class="floatRight imprimir_receita" receita="{{$receita->id}}" href="{{route('receita.imprimir',['agenda' => $dados->id ,'receita' => $receita->id])}}" target="_blank"><i title="Imprimir receita" data-toggle="tooltip" data-placement="bottom" class="fas fa-print fa-lg"></i></a>
                                <p>{!!$receita->descricao!!}</p>
                            </li>
                            <br>
                        </ul>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @php $i++; @endphp
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('plugin/jqueryte/jquery-te-1.4.0.min.js') }}"></script>
<script src="{{ asset('js/atendimento/edit.js') }}"></script>
@endsection