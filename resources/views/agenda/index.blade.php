@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Agenta {{ $tipo }} - {{ $data }}</h4>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="#" data-toggle="modal" data-target="#modalDefault">Marcar consulta <i class="fas fa-plus"></i></a>
        </div>
    </div>
    <hr>
    {!! Form::open() !!}
    <div class="row">
        <div class="form-group col-md-9">
        {!! Form::label('nome', 'Nome paciente') !!}
        {!! Form::text('nome', '', ['class' => 'form-control', 'maxlength' => '200']) !!}
        </div>
        <div class="form-group col-md-3">
        {!! Form::label('horario', 'Horário') !!}
        {!! Form::select('horario', array('07:30'=>'07:30','07:45'=>'07:45'), null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12 text-right">
            {!! Form::button('Salvar', ['id' => 'salvar', 'class' => 'btn btn-success']); !!}
        </div>
    </div>
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
    {!! Form::close() !!}
</div>
@endsection
