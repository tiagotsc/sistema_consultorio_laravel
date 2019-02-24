@extends('./layout.master')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
         <h4>Gerenciar relatórios</h4>
        </div>
        <div class="col-md-6 text-right">
        @can('perfil-criar')
        @endcan
         <a href="{{ route('relatorios.create') }}">Cadastrar <i class="fas fa-plus"></i></a>
        </div>
    </div>
    <hr>
    <table class="table display" id="frm-pesq" width="100%">
        <thead>
            <tr>
                <th>Categoria</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Banco conexão</th>
                <th>Qtd. perfis</th>
                <th>Qtd. usuários</th>
                <th>Status</th>
                <th width="70px">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $dado)
            <tr>
                <td>{{$dado->categoria->nome}}</td>
                <td>{{$dado->nome}}</td>
                <td>{{$dado->descricao}}</td>
                <td>{{$dado->banco_conexao}}</td>
                <td>{{$dado->permissao->roles->count()}}</td>
                <td>{{$dado->permissao->users->count()}}</td>
                <td>{{$dado->status == 'A'? 'Ativo': 'Inativo'}}</td>
                <td>
                    @can('relatorio.editar')
                    @endcan
                    <a title="Editar" data-toggle="tooltip" class="marginIcon" data-placement="bottom" href="{{route('relatorios.edit',[$dado->id])}}">
                        <i class="fas fa-pencil-alt fa-lg iconeMargin"></i>
                    </a>
                    
                    @can('relatorio.excluir')
                    @endcan
                    @if($dado->permissao->roles->count() == 0 and $dado->permissao->users->count() == 0)
                    <a href="#" class="apagar" idDel="{{$dado->id}}" titulo="{{$dado->nome}}" data-toggle="modal" data-target="#modalApagar">
                        <i title="Apagar" data-toggle="tooltip" data-placement="bottom" class="fas fa-trash-alt fa-lg"></i>
                    </a>
                    @endif
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" id="rota-deletar" value='{{route("relatorios.destroy", 0)}}' >
@endsection

@section('calendar')
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('js/relatorio/gerenciar.js') }}"></script>
@endsection