@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Pesquisar role</h4>
        </div>
        <div class="col-md-6 text-right">
        @can('perfil-criar')
         <a class="menu-item" href="{{ route('roles.create') }}">Cadastrar</a>
        @endcan
        </div>
    </div>
    <hr>
    <div class="row marginBotton">
        <div class="col-md-12">
              <div class="form-group">
              <input type="text" id="permissoes" value="{{$permissoes}}">
                {!! Form::token() !!}
                {!! Form::label('nome', 'Nome:') !!}
                {!! Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome']) !!}
              </div>
              <button id="pesq" type="button" class="btn btn-primary floatRight">Pesquisar</button>
        </div>
    </div>
   <input type="hidden" id="rota_ajax" value="{{route('roles.getpesq')}}" >
    <table id="frm-pesq" class="display">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ação</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
@section('footerScrits')
@parent
<script src="{{ asset('js/role/index.js') }}"></script>
@endsection