@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h5>Agenda - configuração</h5>
        </div>
    </div>
    <hr>
    {!! Form::model($agendaConfig, ['route' => ['agendaconfig.update', $agendaConfig->id], 'method' => 'put', 'id' => 'frm', 'class' => 'form']) !!}
    {!! Form::token() !!}
    <div class="row">
        <div class="form-group col-md-4">
            {!! Form::label('inicio', 'Início') !!}<span class="obrigatorio">*</span>
            <div class="input-group mb-3">
                {!! Form::text('inicio', old('inicio'), ['class' => 'form-control', 'maxlength' => '2']) !!}
                <div class="input-group-append">
                    <span class="input-group-text"> :00</span>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('fim', 'Fim') !!}<span class="obrigatorio">*</span>
            <div class="input-group mb-3">
                {!! Form::text('fim', old('fim'), ['class' => 'form-control', 'maxlength' => '2']) !!}
                <div class="input-group-append">
                    <span class="input-group-text"> :00</span>
                </div>
            </div>
        </div>
        <div class="form-group col-md-4">
            {!! Form::label('intervalo', 'Intervalo') !!}<span class="obrigatorio">*</span>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">00: </span>
                </div>
                {!! Form::text('intervalo', old('intervalo'), ['class' => 'form-control', 'maxlength' => '2']) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {!! Form::button('Salvar', ['id' => 'salvar', 'class' => 'btn btn-primary']); !!}
        </div>
    </div>
    {!! Form::hidden('id', old('id')) !!}
    {!! Form::close() !!}
</div>
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('js/agenda_config/create.js') }}"></script>
@endsection