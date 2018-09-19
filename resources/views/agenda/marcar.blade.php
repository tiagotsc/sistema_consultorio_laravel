<style>
.modal-full {
    min-width: 100%;
    margin: 0;
}
</style>
<div class="modal-dialog modal-full" role="document" style="width: 100%">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Marcar consulta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      {!! Form::open(['id' => 'frmMarcar', 'route' => 'agenda.store']) !!}
      <div class="modal-body">
        <div class="row">
            <div class="form-group col-md-3">
            {!! Form::token() !!}
            {!! Form::label('primeira_vez', 'Primeira vez?') !!}<span class="obrigatorio">*</span>
            {!! Form::select('primeira_vez', array('' => '', 'S'=>'Sim','N'=>'Não'), null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-3">
            {!! Form::label('data_marcar', 'Data') !!}<span class="obrigatorio">*</span>
            {!! Form::text('data_marcar', $dataSelecionada, ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            </div>
            <div class="form-group col-md-3">
            {!! Form::label('especialidade', 'Especialidade') !!}<span class="obrigatorio">*</span>
            {!! Form::select('especialidade', array('' => '', '1'=>'Otorrino','2'=>'Oftalmologista'), null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-3">
            {!! Form::label('medico', 'Medico') !!}<span class="obrigatorio">*</span>
            {!! Form::select('medico', array('' => '', '1'=>'Marco Afonso','2'=>'Rodrigo Pena'), null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
            {!! Form::label('nome', 'Nome') !!}<span class="obrigatorio">*</span>
            {!! Form::text('nome', '', ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            </div>
            <div class="form-group col-md-2">
            {!! Form::label('telefone', 'Telefone') !!}
            {!! Form::text('telefone', '', ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            </div>
            <div class="form-group col-md-2">
            {!! Form::label('celular', 'Celular') !!}
            {!! Form::text('celular', '', ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            </div>
            <div class="form-group col-md-2">
            {!! Form::label('plano', 'Plano saúde') !!}<span class="obrigatorio">*</span>
            {!! Form::select('plano', array('' => '', 'S'=>'Sim','N'=>'Não'), null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="row">
            @foreach ($horas as $hora)
            <div class="form-group col-md-1">
                <label>{!! Form::radio('hora_marcada', $hora, false) !!} {{$hora}}</label>
            </div>
            @endforeach
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" id="salvarConsultar" class="btn btn-primary">Salvar</button>
      </div>
      {!! Form::close() !!}
    </div>
</div>
  <!--<script src="{{ asset('js/agenda/marcar.js') }}"></script>-->
  <script>
//var url = "/scripts/script.js";
$.getScript($("#base_url").val()+'/js/agenda/marcar.js');
</script>