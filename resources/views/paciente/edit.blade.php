@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h5>Editar paciente</h5>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('paciente.index') }}">Voltar pesquisa</a>
        </div>
    </div>
    <hr>
    {!! Form::model($paciente, ['route' => ['paciente.update', $paciente->id], 'method' => 'put', 'id' => 'frm', 'class' => 'form']) !!}
    <div class="row">
        <div class="form-group col-md-3">
        {!! Form::token() !!}
        {!! Form::label('matricula', 'Matrícula') !!}
        {!! Form::text('matricula',old('matricula'), ['class' => 'form-control', 'readonly' => true]) !!}
        </div>
        <div class="form-group col-md-6">
        {!! Form::label('nome', 'Nome') !!}<span class="obrigatorio">*</span>
        {!! Form::text('nome', old('nome'), ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('dataNasc', 'Data nascimento') !!}
        {!! Form::text('dataNasc', old('dataNasc'), ['class' => 'form-control data', 'maxlength' => '10', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('cpf', 'CPF') !!}
        {!! Form::text('cpf', old('cpf'), ['class' => 'cpf form-control', 'maxlength' => '20', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('rg', 'RG') !!}
        {!! Form::text('rg', old('rg'), ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-6">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', old('email'), ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('telefone', 'Telefone fixo') !!}
        {!! Form::text('telefone', old('telefone'), ['class' => 'form-control telefone', 'maxlength' => '14', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('celular', 'Celular') !!}
        {!! Form::text('celular', old('celular'), ['class' => 'form-control celular', 'maxlength' => '15', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('CEP', 'CEP') !!}
        {!! Form::text('cep', old('cep'), ['class' => 'form-control cep', 'maxlength' => '9', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-9">
        {!! Form::label('endereco', 'Endereço') !!}
        {!! Form::text('endereco', old('endereco'), ['class' => 'form-control', 'readonly' => true, 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('endNumero', 'Número') !!}
        {!! Form::text('endNumero', old('endNumero'), ['class' => 'form-control', 'maxlength' => '50', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-4">
        {!! Form::label('bairro', 'Bairro') !!}
        {!! Form::text('bairro', old('bairro'), ['class' => 'form-control', 'readonly' => true, 'maxlength' => '100', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-4">
        {!! Form::label('cidade', 'Cidade') !!}
        {!! Form::text('cidade', old('cidade'), ['class' => 'form-control', 'readonly' => true, 'maxlength' => '100', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('estado_id', 'Estado') !!}
        {!! Form::select('estado_id', $estados, old('estado_id'), ['class' => 'form-control', 'readonly' => true]) !!}
        </div>
        <!--
        <div class="form-group col-md-4">
        {!! Form::label('password', 'Senha') !!}
        {!! Form::password('password', ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        -->
    </div>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {!! Form::button('Salvar', ['id' => 'salvar', 'class' => 'btn btn-primary']); !!}
        </div>
    </div>
    {!! Form::hidden('redirect', $redirect) !!}
    {!! Form::hidden('novoPaciente', 'N') !!}
    {!! Form::hidden('id', old('id')) !!}
    {!! Form::close() !!}
</div>
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('js/paciente/create.js') }}"></script>
@endsection