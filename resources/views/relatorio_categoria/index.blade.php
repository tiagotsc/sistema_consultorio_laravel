@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Lista de categoria de relatório</h4>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{route('relatorioCategoria.create')}}" data-toggle="tooltip" data-placement="bottom" title="Adicionar">
            Cadastrar <i class="fas fa-plus"></i>
        </a>
        </div>
    </div>
    <hr>   
    <table id="frm-pesq" class="display">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Status</th>
                <th>Qtd. Relatórios</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $dado)
            <tr>
                <td>{{$dado->nome}}</td>
                <td>{{$dado->status}}</td>
                <td>{{$dado->relatorios()->count()}}</td>
                <td width="20px">
                    <a title="Editar" class="marginIcon" data-toggle="tooltip" data-placement="bottom" href="{{route('relatorioCategoria.edit',[$dado->id])}}">
                        <i class="fas fa-pencil-alt fa-lg iconeMargin"></i>
                    </a>
                    @if($dado->relatorios()->count() == 0)
                    <a href="#" class="apagar" idDel="{{$dado->id}}" titulo="{{$dado->nome}}" data-toggle="modal" data-target="#modalApagar">
                        <i class="fas fa-trash-alt fa-lg" data-toggle="tooltip" data-placement="bottom" title="Apagar"></i>
                    </a>
                    @endif
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" id="rota-deletar" value='{{route("relatorioCategoria.destroy", 0)}}' >
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('/js/relatorio_categoria/index.js') }}"></script>
@endsection