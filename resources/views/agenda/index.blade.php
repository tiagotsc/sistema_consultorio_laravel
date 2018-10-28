@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Agenda {{ $tipo }} - {{ $data }}</h4>
        </div>
        <div class="col-md-6 text-right">
         <a id="modalMarcar" data-selecionada="{{ $data }}" href="#">Marcar consulta <i class="fas fa-plus"></i></a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="form-group col-md-9">
        <input type="hidden" id="todas_sequencias" value="{{$todasSequencias}}">
        <input type="hidden" id="rota_cadastra_consulta" value="{{route('agenda.create')}}">
        <input type="hidden" id="rota_edita_consulta" value="{{route('agenda.edit',['id' => 0])}}">
        <input type="hidden" id="rota_pesquisa_consulta" value="{{route('agenda.getpesq')}}">
        {!! Form::token() !!}
        {!! Form::label('input_dado', 'Pesquise paciente por:') !!}
        {!! Form::text('input_dado', '', ['class' => 'form-control', 'maxlength' => '200','placeholder' => 'Nome, CPF, RG, Telefone ou Celular']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('horario', 'Horário') !!}
        {!! Form::select('horario', $horas, null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {!! Form::button('Pesquisar', ['id' => 'pesq', 'class' => 'btn btn-primary']); !!}
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
    <!--
    <div class="row">
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th>Horário</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Situação</th>
                <th>Ação</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>07:45</td>
                <td>Carine</td>
                <td>(21)96780-5490</td>
                <td>Confirmado</td>
                <td>Editar</td>
              </tr>
              <tr>
                <td>08:00</td>
                <td>Paulo</td>
                <td>(21)94572-5230</td>
                <td>Confirmado</td>
                <td>Editar</td>
              </tr>
              <tr>
                <td>08:15</td>
                <td>Jorge</td>
                <td>(21)96678-2450</td>
                <td>Confirmado</td>
                <td>Editar</td>
              </tr>
            </tbody>
          </table>    
        </div>
    </div>
    -->
</div>
<input type="hidden" id="rota_altera_status" value="{{route('agenda.alteraStatus',['id' => 0])}}">
<!-- Modal Alterar status -->
<div class="modal fade" id="modalStatus" tabindex="-1" role="dialog" aria-labelledby="modalStatus" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalStatus">Alterar status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        {!! Form::open(['id' => 'frmAlteraStatus', 'method' => 'put', 'url' => '']) !!}
        <div class="modal-body">
          <div class="row">
              <div class="form-group col-md-12">
              {!! Form::label('altera_status_paciente', 'Paciente') !!}
              {!! Form::text('altera_status_paciente', null, ['class' => 'form-control', 'readonly'=>true]) !!}
              </div>
              <div class="form-group col-md-6">
                  {!! Form::label('altera_status_horario', 'Horário') !!}
                  {!! Form::text('altera_status_horario', null, ['class' => 'form-control', 'readonly'=>true]) !!}
                  </div>
              <div class="form-group col-md-6">
              {!! Form::label('agenda_status_id', 'Status') !!}
              {!! Form::select('agenda_status_id', array(), null, ['class' => 'form-control']) !!}
              </div>
          </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="data" value="{{ $data }}">
          <input type="hidden" id="altera_status_medico_id" name="altera_status_medico_id">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" id="bt-status-altera" class="btn btn-primary">Alterar</button>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
<div id="modalAgendaFicha" class="modal" tabindex="-1" role="dialog">
    
</div>
<input type="hidden" id="rota-deletar" value='{{route("agenda.destroy", 0)}}?data={{$data}}' >
@endsection

@section('footerScrits')
@parent
<script src="{{ asset('js/agenda/index.js') }}"></script>
@endsection
