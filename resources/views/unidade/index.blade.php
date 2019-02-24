@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Pesquisar clínica / consultório</h4>
        </div>
        <div class="col-md-6 text-right">
        @can('paciente-criar')
         <a class="menu-item" href="{{ route('unidade.create') }}">Cadastrar <i class="fas fa-plus"></i></a>
         @endcan
        </div>
    </div>
    <hr>   
    <table id="frm-pesq" class="display">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Bairro</th>
                <th>Cidade</th>
                <!--<th>Estado</th>-->
                <th>Status</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados as $dado)
            <tr>
                <td>{{$dado->nome}}</td>
                <td>{{$dado->bairro}}</td>
                <td>{{$dado->cidade}}</td>
                <!--<td>{{$dado->estado->nome}}</td>-->
                <td>{{$dado->status == 'A'? 'Ativo': 'Inativo'}}</td>
                <td>
                    <a title="Editar" data-toggle="tooltip" data-placement="bottom" href="{{route('unidade.edit',[$dado->id])}}" idEdit="'+data+'" class="editar marginIcon"><i class="fas fa-edit fa-lg"></i></a>
                    <a idDel="{{$dado->id}}" titulo="{{$dado->nome}}" href="#" data-toggle="modal" data-target="#modalApagar" class="apagar"><i title="Apagar" data-toggle="tooltip" data-placement="bottom" class="fas fa-trash-alt fa-lg"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<input type="hidden" id="rota-deletar" value='{{route("unidade.destroy", 0)}}' >
@endsection
@section('footerScrits')
@parent
<script src="{{ asset('js/unidade/index.js') }}"></script>
@endsection