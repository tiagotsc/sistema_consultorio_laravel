@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h5>Cadastrar de clínica / cosultório</h5>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('unidade.index') }}">Voltar pesquisa</a>
        </div>
    </div>
    <hr>
    {!! Form::open(['id' => 'frm', 'route' => 'unidade.store']) !!}
    <div class="row">
        <div class="form-group col-md-6">
        {!! Form::label('nome', 'Nome') !!}<span class="obrigatorio">*</span>
        {!! Form::text('nome', null, ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-6">
        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('CEP', 'CEP') !!}<span class="obrigatorio">*</span>
        {!! Form::text('cep', null, ['class' => 'form-control cep', 'maxlength' => '9', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-9">
        {!! Form::label('endereco', 'Endereço') !!}<span class="obrigatorio">*</span>
        {!! Form::text('endereco', null, ['class' => 'form-control', 'readonly' => true, 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('numero', 'Número') !!}<span class="obrigatorio">*</span>
        {!! Form::text('numero', null, ['class' => 'form-control', 'maxlength' => '100', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('complemento', 'Complemento') !!}
        {!! Form::text('complemento', null, ['class' => 'form-control', 'maxlength' => '100', 'placeholder' => '']) !!}
        </div>
        <div class="form-group col-md-4">
        {!! Form::label('bairro', 'Bairro') !!}<span class="obrigatorio">*</span>
        {!! Form::text('bairro', null, ['class' => 'form-control', 'readonly' => true, 'maxlength' => '100', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-5">
        {!! Form::label('cidade', 'Cidade') !!}<span class="obrigatorio">*</span>
        {!! Form::text('cidade', null, ['class' => 'form-control', 'readonly' => true, 'maxlength' => '100', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('estado_id', 'Estado') !!}<span class="obrigatorio">*</span>
        {!! Form::select('estado_id', $estados, null, ['class' => 'form-control', 'readonly' => true]) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', array('A'=>'Ativo','I'=>'Inativo'), null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <a href="#" id="add_telefone" title="Adicionar telefone" data-toggle="tooltip" data-placement="bottom">Add telefone <i class="fas fa-plus"></i></a>
        </div>
    </div>
    <div id="telefones" class="row">
        
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
<script src="{{ asset('js/unidade/create.js') }}"></script>
@endsection