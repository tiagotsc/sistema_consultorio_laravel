@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h5>Cadastro perfil</h5>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('roles.index') }}">Voltar pesquisa</a>
        </div>
    </div>
    <hr>
    {!! Form::open(['id' => 'frm', 'route' => 'roles.store']) !!}
    <div class="row">
        <div class="form-group col-md-6">
        {!! Form::label('name', 'Nome') !!}<span class="obrigatorio">*</span>
        {!! Form::text('name', '', ['class' => 'form-control', 'maxlength' => '200', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-6">
        {!! Form::label('permissoes_grupo', 'Filtrar permissões por') !!}
        {!! Form::select('permissoes_grupo', $permissoesGrupo, null, ['class' => 'form-control', 'readonly' => false]) !!}
        </div>
        <div class="form-group col-md-6">
            <label>Permissões:</label>
            <ul class="list-group">
                <li class="list-group-item">
                    <label>
                        {{ Form::checkbox('todos', null, false, array('id' => 'todos')) }} <b>Marcar / Desmarcar todos</b>
                    </label>
                </li>
                @foreach($permission as $value)
                <li class="list-group-item permissao_item {{$value->grupo}}">
                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'marcado '.$value->grupo.'_checkbox')) }}
                    {{ $value->name }}
                    </label>
                </li>
                @endforeach
            </ul>
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
<script src="{{ asset('js/role/create.js') }}"></script>
@endsection