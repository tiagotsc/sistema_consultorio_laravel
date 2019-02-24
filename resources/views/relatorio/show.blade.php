<link href="/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<!-- Modal -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
    {!! Form::open(['id' => 'frm', 'method' => 'post', 'target' => '_blank', 'route' => ['relatorio.gerar', 'id' => $relatorio->id]]) !!}
        <div class="modal-header">
            <h5 class="modal-title">{{$relatorio->nome}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info" role="alert">{{$relatorio->descricao}}</div>
            <div class="row">
                @foreach ($relatorio->campos as $campos)
                @php $tamanho = (in_array($campos->tipo, array('data','mesano')))? '4': '6'; @endphp
                <div class="form-group col-md-{{$tamanho}}">
                {!! Form::label($campos->nome, $campos->pivot->nome) !!}
                <i data-toggle="tooltip" data-placement="bottom" title="{{$campos->pivot->legenda}}" class="fas fa-info-circle infoTooltip"></i>
                @if($campos->pivot->obrigatorio == 'S')
                <span class='obrigatorio'>*</span>
                @endif
                {!! Form::text($campos->nome, null, ['class' => 'form-control', 'maxlength' => '255', 'tipo' => $campos->tipo, 'mascara' => $campos->mascara, 'obrigatorio' => $campos->pivot->obrigatorio, 'placeholder' => 'Preencha...']) !!}
                </div>
                @endforeach
            </div>
            @can('relatorio.debugar')
            @endcan
            <div class="row">
                <div class="form-group col-md-12">
                    <label><input type="checkbox" name="debugar" value="debugar">Modo desenvolvedor (Debugar relatório)</label>
                </div>
            </div>
            
        </div>
        <div class="modal-footer">
            @php $cont = 0; @endphp
            @foreach ($relatorio->sumarizacao as $sumarizacao)
            {!! Form::hidden('campo['.$cont.']', $sumarizacao->campo) !!}
            {!! Form::hidden('sumarizados['.$cont.']', $sumarizacao->sumarizados) !!}
                @php $cont++; @endphp
            @endforeach
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            {!! Form::button('Gerar relatório', ['id' => 'salvar', 'class' => 'btn btn-primary']); !!}
        </div>
    {!! Form::close() !!}
    </div>
</div><!-- /js/jquery.validate.min.js -->
<script>
$.getScript('/js/relatorio/show.js');
</script>