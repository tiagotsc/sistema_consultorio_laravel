@extends('./layout.master')

@section('headerCss')
@parent
<link rel="stylesheet" href="{{ asset('css/relatorio.css') }}">
@endsection

@section('content')
<div class="col-md-12">
    <div class="row">
        <div class="col-md-6">
            <h5>Criar relatório</h5>
        </div>
        <div class="col-md-6 text-right">
            @can('relatorio-visualizar')
            <a class="menu-item" href="{{route('relatorios.index')}}" data-toggle="tooltip" data-placement="bottom" title="Listar relatórios">Listar relatórios</a>
            @endcan
        </div>
    </div>
    <hr>
    {!! Form::open(['id' => 'frm', 'route' => 'relatorios.store']) !!}
    <div class="row">
        <div class="form-group col-md-2 semPadding">
        {!! Form::label('relatorio_categoria_id', 'Categoria') !!}<span class="obrigatorio">*</span>
        {!! Form::select('relatorio_categoria_id', $categorias, null, ['class' => 'form-control', 'readonly' => false]) !!}
        </div>
        <div class="form-group col-md-3 semPadding">
        {!! Form::label('nome', 'Nome') !!}<span class="obrigatorio">*</span>
        {!! Form::text('nome', '', ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-3 semPadding">
        {!! Form::label('descricao', 'Descrição') !!}<span class="obrigatorio">*</span>
        {!! Form::text('descricao', '', ['class' => 'form-control', 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}
        </div>
        <div class="form-group col-md-2 semPadding">
        {!! Form::label('banco_conexao', 'Banco conexão') !!}<span class="obrigatorio">*</span>
        {!! Form::select('banco_conexao', $bancosDeDados, 'mysql', ['class' => 'form-control', 'readonly' => false]) !!}
        </div>
        <div class="form-group col-md-2 semPadding">
        {!! Form::label('status', 'Status') !!}
        {!! Form::select('status', array('A'=>'Ativo','I'=>'Inativo'), null, ['class' => 'form-control', 'readonly' => false]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 divOverFlowPequena">
            <h5>
                Lista de campos para preenchimento
                <i data-toggle="tooltip", data-placement="bottom" title="Parâmetros que deverão ser preenchidos ou não, de acordo com a obrigatoriedade, para a geração do relatório." class="fas fa-info-circle infoTooltip"></i>
            </h5>
            <div>
            <table id="tabelaRelatorioCampos" class="table">
                <thead >
                    <tr>
                        <th class="tableSemPadding" width="5px"></th>
                        <th class="tableSemPadding" width="40px">
                            Campo
                            <i data-toggle="tooltip", data-placement="bottom" title="Variável que deverá ser atribuida na condição da query." class="fas fa-info-circle infoTooltip"></i>
                        </th>
                        <th class="tableSemPadding">
                            Nome
                            <i data-toggle="tooltip", data-placement="bottom" title="Nome dado ao input que aparecerá para o usuário." class="fas fa-info-circle infoTooltip"></i>
                        </th>
                        <th class="tableSemPadding">
                            Legenda
                            <i data-toggle="tooltip", data-placement="bottom" title="Uma breve descrição para o usuário sobre o input e como preenche lo." class="fas fa-info-circle infoTooltip"></i>
                        </th>
                        <th class="tableSemPadding" width="120px">
                            Obrigatorio
                            <i data-toggle="tooltip", data-placement="bottom" title="Obrigatoriedade de preenchimento do input pelo usuário antes de gerar o relatório." class="fas fa-info-circle infoTooltip"></i>
                        </th>
                        <th class="tableSemPadding" width="90px">
                            Ordem
                            <i data-toggle="tooltip", data-placement="bottom" title="Ordena a exposição dos parâmetros de preenchimento." class="fas fa-info-circle infoTooltip"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php $cont = 0; @endphp
                    @foreach($campos as $campo)
                    <tr>
                        <td class="tableSemPadding">
                            <label class="labelSemNegrito">
                                {{ Form::checkbox('campo['.$cont.']', $campo->id, false, array('class' => 'marcado','identcampo'=>$cont)) }} 
                            </label>
                        </td>
                        <td class="tableSemPadding"><a data-toggle="tooltip" data-placement="bottom" title="{{ $campo->legenda }}" href="#">{{ $campo->nome }}</a></td>
                        <td class="tableSemPadding form-group">{!! Form::text('campo_nome['.$cont.']', '', ['class' => 'form-control campos campo_nome','cont' => $cont, 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}</td>
                        <td class="tableSemPadding form-group">{!! Form::text('campo_legenda['.$cont.']', '', ['class' => 'form-control campos campo_legenda'.$cont, 'maxlength' => '255', 'placeholder' => 'Preencha...']) !!}</td>
                        <td class="tableSemPadding">{!! Form::select('campo_obrigatorio['.$cont.']', array('S'=>'Sim','N'=>'Não'), null, ['class' => 'form-control campos campo_obrigatorio'.$cont, 'readonly' => false]) !!}</td>
                        <td class="tableSemPadding">{!! Form::text('campo_ordem['.$cont.']', '', ['class' => 'form-control ordem_mask campos campo_ordem'.$cont, 'maxlength' => '1']) !!}</td>
                    </tr>
                        @php $cont++; @endphp
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="col-md-4">
            <a id="add_sumarizar" href="#">Adicionar sumarização de campos <i class="fas fa-plus"></i></a>
            <div id="campos_sumarizacao">
                <table id="tabelaRelatorioCamposSumarizados" class="table">
                    <thead>
                        <tr>
                            <th width="130px" class="tableSemPadding">
                                Campo
                                <i data-toggle="tooltip", data-placement="bottom" title="Campo que será observado para classificar a sumarização. Obs: Informe um único campo de observação por linha adicinada!" class="fas fa-info-circle infoTooltip"></i>
                            </th>
                            <th class="tableSemPadding">
                                Campos sumarizados
                                <i data-toggle="tooltip" data-placement="bottom" title="Campo que serão sumarizados de acordo com o classificador de sumarização. Obs: Pode informar vários campos para sumarização, sem espaço entre eles, separando cada um por vírgula! Exemplo: hora,hora_custo" class="fas fa-info-circle infoTooltip"></i>
                            </th>
                            <th width="10px" class="tableSemPadding"></th>
                        </tr>
                    </thead>
                    <tbody id="sumarizacao_adicionada">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 divOverFlowMedia">
            <label>Perfis que acessarão:</label>
            <ul class="list-group">
                <li class="list-group-item">
                    <label>
                        {{ Form::checkbox('todos', null, false, array('id' => 'todos')) }} Marcar / Desmarcar todos
                    </label>
                </li>
                @foreach($perfis as $value)
                    <li class="list-group-item">
                        <label class="labelSemNegrito" data-toggle="tooltip" data-placement="bottom" title="{{$value->label}}">
                            {{ Form::checkbox('perfis[]', $value->id, false, array('class' => 'perfil_checkbox '.$value->grupo.'_checkbox')) }} 
                            {{ $value->name }}
                        </label>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-8 form-group">
                {!! Form::label('query', 'Query') !!}<span class="obrigatorio">*</span>
                {!! Form::textarea('query', '', ['class' => 'form-control', 'rows'=>30, 'placeholder' => 'Cole a query aqui...']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <br>
            {!! Form::button('Salvar', ['id' => 'salvar', 'class' => 'btn btn-primary']); !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('calendar')
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('/js/relatorio/create.js') }}"></script>
@endsection