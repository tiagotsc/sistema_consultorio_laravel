@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Pesquisar paciente</h4>
        </div>
        <div class="col-md-6 text-right">
        @can('paciente-criar')
         <a class="menu-item" href="{{ route('paciente.create') }}">Cadastrar</a>
         @endcan
        </div>
    </div>
    <hr>
    <div class="row marginBotton">
        <div class="col-md-12">
              <div class="form-group">
                {!! Form::token() !!}
                {!! Form::label('nome_cpf_rg', 'Nome ou CPF ou RG:') !!}
                {!! Form::text('nome_cpf_rg', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome ou CPF ou RG']) !!}
              </div>
              <button id="pesq" type="button" class="btn btn-primary floatRight">Pesquisar</button>
        </div>
    </div>
   
    <table id="frm-pesq" class="display">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Nome</th>
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
    </table>
</div>
<input type="hidden" id="rota-deletar" value='{{route("paciente.destroy", 0)}}' >
@endsection
@section('footerScrits')
@parent
<script src="{{ asset('js/paciente/index.js') }}"></script>
@endsection