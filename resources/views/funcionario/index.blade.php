@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Pesquisar funcionário</h4>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('funcionario.create') }}">Cadastrar</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            {!! Form::open() !!}
              <div class="form-group">
                {!! Form::token() !!}
                {!! Form::label('nome_cpf', 'Nome ou CPF:') !!}
                {!! Form::text('nome_cpf', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome ou CPF']) !!}
              </div>
              <button id="pesq" type="button" class="btn btn-primary">Pesquisar</button>
            {!! Form::close() !!}
        </div>
    </div>
   
        <table class="table" id="frm-pesq">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th>Perfil</th>
                    <th>Ação</th>
                </tr>
            </thead>
        </table>
   
</div>
@endsection
@section('footerScrits')
@parent
<script src="{{ asset('js/funcionario/index.js') }}"></script>
@endsection