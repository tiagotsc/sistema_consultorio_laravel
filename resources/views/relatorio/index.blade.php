@extends('layout.master')

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
         <h5>Relatórios disponíveis</h5>
        </div>
        <div class="col-md-6 text-right">
        @can('relatorio.cadastrar')
        @endcan
         <a class="menu-item" href="{{ route('relatorios.create') }}">Voltar pesquisa</a>
        
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" id="rota_relatorio_show" value="{{route('relatorios.show',[0])}}">
            <div id="accordion">
                @php $i = 0; @endphp
                @foreach ($categorias as $categoria)
                <div class="card">
                    <div data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="true" aria-controls="collapse{{$i}}" class="card-header accordionAba" id="heading{{$i}}">
                        <h5 class="mb-0">
                            {{$categoria->nome}}
                        </h5>
                    </div>
                
                    <div id="collapse{{$i}}" class="collapse show" aria-labelledby="heading{{$i}}" data-parent="#accordion">
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($categoria->relatorios()->where('status','A')->whereIn('permission_id',$permissioesUsuario)->orderBy('nome')->get() as $relatorio)
                                <li class="list-group-item">
                                    <a title="Clique aqui para gerar o relatório" data-toggle="tooltip" data-placement="bottom" href="#" id="{{$relatorio->id}}" class="relatorio_selecionado iconeMargin">{{$relatorio->nome}}</a>
                                    @can('relatorio.editar')
                                    @endcan
                                    <a title="Editar" data-toggle="tooltip" data-placement="bottom" href="{{route('relatorios.edit',[$relatorio->id])}}">
                                        <i class="fas fa-pencil-alt iconeMargin"></i>
                                    </a>
                                    
                                    <p>{{$relatorio->descricao}}</p>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @php $i++; @endphp
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('calendar')
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('/js/relatorio/index.js') }}"></script>
@endsection