@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h5>Editar perfil</h5>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('roles.index') }}">Voltar pesquisa</a>
        </div>
    </div>
    <hr>
    {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'put', 'id' => 'frm', 'class' => 'form']) !!}
    <div class="row">
        <div class="form-group col-md-6">
        {!! Form::token() !!}
        {!! Form::label('name', 'Nome') !!}<span class="obrigatorio">*</span>
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'maxlength' => '200', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3">
            <label>Permission:</label>
            <br/>
            @foreach($permission as $value)
                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {!! Form::button('Salvar', ['id' => 'salvar', 'class' => 'btn btn-success']); !!}
        </div>
    </div>
    {!! Form::hidden('id', old('id')) !!}
    {!! Form::close() !!}
</div>
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('js/role/create.js') }}"></script>
@endsection