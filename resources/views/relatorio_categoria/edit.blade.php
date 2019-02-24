@extends('layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
            <h5>Edição de categoria de relatório</h5>
        </div>
        <div class="col-md-6 text-right">
            @can('relatorio_categoria.listar')
            <a class="menu-item" href="{{route('relatorioCategoria.index')}}" data-toggle="tooltip" data-placement="bottom" title="Voltar para pesquisa">Voltar pesquisa</a>
            @endcan
        </div>
    </div>
    <hr>
    {!! Form::model($dados,['id' => 'frm', 'method' => 'put', 'route' => ['relatorioCategoria.update','id'=>$dados->id]]) !!}
    <div class="row">
        <div class="form-group col-md-8">
        {!! Form::label('nome', 'Nome') !!}<span class="obrigatorio">*</span>
        {!! Form::text('nome', null, ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-4">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', array('A'=>'Ativo', 'I'=>'Inativo'), null, ['class' => 'form-control', 'readonly' => false]) !!}
        </div>
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
<script src="{{ asset('js/relatorio_categoria/create.js') }}"></script>
@endsection