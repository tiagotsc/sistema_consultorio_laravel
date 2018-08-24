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
    <div class="row marginBotton">
        <div class="col-md-12">
              <div class="form-group">
                {!! Form::label('nome_cpf', 'Nome ou CPF:') !!}
                {!! Form::text('nome_cpf', null, ['class' => 'form-control', 'placeholder' => 'Informe o nome ou CPF']) !!}
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
                <th>Perfil</th>
                <th>Ação</th>
            </tr>
        </thead>
    </table>
</div>
<div id="modalApagar" class="modal" tabindex="-1" role="dialog">
    {!! Form::open(['id' => 'frm-deletar', 'route' => ['funcionario.destroy', 0]]) !!}
    <input type="hidden" name="_method" value="DELETE">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Deseja excluir o funcionário?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p><input id="del-nome" class="form-control" type="text" readonly></p>
        </div>
        <div class="modal-footer">
            <input id="del-id" type="hidden">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <input id="apagar" type="submit" class="btn btn-primary" value="Apagar">
        </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<input type="hidden" id="rota-deletar" value='{{route("funcionario.destroy", 0)}}' >
@endsection
@section('footerScrits')
@parent
<script src="{{ asset('js/funcionario/index.js') }}"></script>
@endsection