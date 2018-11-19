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
         <a class="menu-item" href="{{ route('agenda.index') }}">Voltar pesquisa</a>
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

    </div>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {!! Form::button('Salvar', ['id' => 'salvar', 'class' => 'btn btn-primary']); !!}
        </div>
    </div>
    <input type="hidden" name="data_consulta" value="{{$dados->data}}">
    {!! Form::close() !!}
</div>
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('plugin/jqueryte/jquery-te-1.4.0.min.js') }}"></script>
<script src="{{ asset('js/atendimento/edit.js') }}"></script>
@endsection