@extends('./layout.master')

@section('content')
<div class="col-md-8 border-right">
    <div class="row">
        <div class="col-md-6">
         <h4>Pesquisar funcionário</h4>
        </div>
        <div class="col-md-6 text-right">
         <a class="menu-item" href="{{ route('funcionario.create') }}">Cadastrar</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            {!! Form::open() !!}
              <div class="form-group">
                {!! Form::label('nome_cpf', 'Nome ou CPF:') !!}
                {!! Form::text('nome_cpf', '', ['class' => 'form-control', 'placeholder' => 'Informe o nome ou CPF']) !!}
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
