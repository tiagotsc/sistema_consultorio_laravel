@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h5>Cadastrar paciente</h5>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('paciente.index') }}">Voltar pesquisa</a>
        </div>
    </div>
    <hr>
    {!! Form::open(['id' => 'frm', 'route' => 'paciente.store']) !!}
    <div class="row">
        <div class="form-group col-md-3">
        {!! Form::token() !!}
        {!! Form::label('matricula', 'Matrícula') !!}
        {!! Form::text('matricula',null, ['class' => 'form-control', 'readonly' => true]) !!}
        </div>
        <div class="form-group col-md-6">
        {!! Form::label('nome', 'Nome') !!}<span class="obrigatorio">*</span>
        {!! Form::text('nome', null, ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('dataNasc', 'Data nascimento') !!}
        {!! Form::text('dataNasc', null, ['class' => 'form-control data', 'maxlength' => '10', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('cpf', 'CPF') !!}
        {!! Form::text('cpf', null, ['class' => 'cpf form-control', 'maxlength' => '15', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('rg', 'RG') !!}
        {!! Form::text('rg', null, ['class' => 'form-control', 'maxlength' => '15', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-6">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('telefone', 'Telefone fixo') !!}
        {!! Form::text('telefone', null, ['class' => 'form-control telefone', 'maxlength' => '14', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('celular', 'Celular') !!}
        {!! Form::text('celular', null, ['class' => 'form-control celular', 'maxlength' => '15', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('CEP', 'CEP') !!}
        {!! Form::text('cep', null, ['class' => 'form-control cep', 'maxlength' => '9', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-9">
        {!! Form::label('endereco', 'Endereço') !!}
        {!! Form::text('endereco', null, ['class' => 'form-control', 'readonly' => true, 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('endNumero', 'Número') !!}
        {!! Form::text('endNumero', null, ['class' => 'form-control', 'maxlength' => '50', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-4">
        {!! Form::label('bairro', 'Bairro') !!}
        {!! Form::text('bairro', null, ['class' => 'form-control', 'readonly' => true, 'maxlength' => '100', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-4">
        {!! Form::label('cidade', 'Cidade') !!}
        {!! Form::text('cidade', null, ['class' => 'form-control', 'readonly' => true, 'maxlength' => '100', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('estado_id', 'Estado') !!}
        {!! Form::select('estado_id', $estados, null, ['class' => 'form-control', 'readonly' => true]) !!}
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
    {!! Form::close() !!}
</div>
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('js/paciente/create.js') }}"></script>
@endsection