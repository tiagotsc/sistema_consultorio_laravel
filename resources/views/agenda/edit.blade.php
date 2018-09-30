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
            <div class="form-group col-md-2">
            {!! Form::token() !!}
            {!! Form::label('primeira_vez', 'Primeira vez?') !!}<span class="obrigatorio">*</span>
            {!! Form::select('primeira_vez', array('' => '', 'S'=>'Sim','N'=>'Não'), null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-2">
            {!! Form::label('data_marcar', 'Data') !!}<span class="obrigatorio">*</span>
            {!! Form::text('data_marcar', $dataSelecionada, ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            </div>
            <div class="form-group col-md-2">
            {!! Form::label('plano', 'Plano saúde') !!}<span class="obrigatorio">*</span>
            {!! Form::select('plano', array('' => '', 'S'=>'Sim','N'=>'Não'), null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-3">
            {!! Form::label('especialidade', 'Especialidade') !!}<span class="obrigatorio">*</span>
            {!! Form::select('especialidade', $especialidades, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-md-3">
            {!! Form::label('medico', 'Medico') !!}<span class="obrigatorio">*</span>
            {!! Form::select('medico', array(), null, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div id="buscaPacientes" class="row">
            <div class="form-group col-md-12">
            {!! Form::label('localizar', 'Localizar Paciente') !!}
            {!! Form::text('localizar', null, ['class' => 'form-control', 'placeholder' => 'Busque por: Nome, CPF, fixo ou celular']) !!}
            </div>
        </div>
        <div id="pacientesEncontrados" class="row">
            <div class="form-group col-md-12">
                <table id="encontrados" class="table">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Fixo</th>
                        <th>Celular</th>
                        <th>Ação</th>
                    </tr>
                    <tr>
                        <td>Paulo Nogueira</td>
                        <td>122.145.957-10</td>
                        <td>(21) 3986-8948</td>
                        <td>(21) 98584-3423</td>
                        <td><a href="#">Selecionar</a></td>
                    </tr>
                </table>
            </div>
        </div>
        <div id="dadosPaciente" class="row">
            <div class="form-group col-md-6">
            {!! Form::label('nome_paciente', 'Nome') !!}<span class="obrigatorio">*</span>
            {!! Form::text('nome_paciente', '', ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            </div>
            <div class="form-group col-md-2">
            {!! Form::label('telefone', 'Telefone') !!}
            {!! Form::text('telefone', '', ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            </div>
            <div class="form-group col-md-2">
            {!! Form::label('celular', 'Celular') !!}
            {!! Form::text('celular', '', ['class' => 'form-control', 'placeholder' => 'Preencha...']) !!}
            <input type="hidden" id="paciente_id" name="paciente_id">
            </div>
        </div>
        <div id="horarios" class="row">
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="rota_medico_espec" value="{{route('agenda.getMedicos')}}">
        <input type="hidden" id="rota_horarios_disponiveis" value="{{route('agenda.getHorariosDisponiveis')}}">
        <input type="hidden" id="rota_paciente_busca" value="{{route('agenda.pacienteBusca')}}">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" id="salvarConsultar" class="btn btn-primary">Salvar</button>
      </div>
      {!! Form::close() !!}
    </div>
</div>
  <!--<script src="{{ asset('js/agenda/marcar.js') }}"></script>-->
  <script>
//var url = "/scripts/script.js";
$.getScript($("#base_url").val()+'/js/agenda/create.js');
</script>