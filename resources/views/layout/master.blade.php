<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Colorlib Medi+</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--<link href="{{ asset('css/font.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('calendario/css/responsive-calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">-->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/datatable/DataTables/datatables.min.css') }}">
  </head>
  <body>
    
    <header role="banner">
      <div class="top-bar">
        <div class="container">
          <div class="row">
            <div class="col-md-6 col-sm-6 col-5">
              <ul class="social list-unstyled">
                <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                <li><a href="#"><span class="fa fa-instagram"></span></a></li>
              </ul>
            </div>
            <div class="col-md-6 col-sm-6 col-7 text-right">
                @auth
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Olá! {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a id="logout_link" class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                Sair
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
                @endauth
            </div>
          </div>
        </div>
      </div>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand" href="index.html">Medi<span>+</span>  </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          {!! $MenuTopo->asUl(['class'=>'navbar-nav ml-auto']) !!}
          <div class="collapse navbar-collapse" id="navbarsExample05">
          @section('menu')
            <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="services.html" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Agenda</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                  <a class="dropdown-item menu-item" href="#">Secretária</a>
                  <a class="dropdown-item menu-item" href="#">Médico</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link menu-item" href="{{ route('funcionario.index') }}">Funcionário</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="doctors.html" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administrador</a>
                <div class="dropdown-menu" aria-labelledby="dropdown05">
                  <a class="dropdown-item" href="doctors.html">Roles</a>
                  <a class="dropdown-item" href="#">Permissions</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="news.html">News</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="about.html">About</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.html">Contact</a>
              </li>
            </ul>
          @show
          </div>
        </div>
      </nav>
    </header>
    <!-- END header -->

    <section class="section bg-light custom-tabs">
      <div class="container">
        @if (session('alertMessage'))
            @php
                $alert = explode('|',session('alertMessage'));
            @endphp
            <div class="alert {{ $alert[0] }} alert-dismissible fade show" role="alert">
                {{ $alert[1] }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endisset
        @foreach ($errors->all() as $message)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
        <div class="row">
        @section('content')
            <div class="col-md-8 border-right">
                <div class="row">
                    <div class="col-md-3">
                    Conteúdo
                    </div>
                    <div class="col-md-3">
                    Conteúdo
                    </div>
                    <div class="col-md-3">
                    Conteúdo
                    </div>
                    <div class="col-md-3">
                    Conteúdo
                    </div>
                </div>
            </div>
        @show
        @section('calendar')
          	<div class="col-md-4">
				<!-- Responsive calendar - START -->
				<div class="responsive-calendar">
                    <div class="controls">
                        <a style="float:left" class="pull-left floatLeft" data-go="prev"><div class="btn btn-primary">Anterior</div></a>
                        <h4><span id="calendario-ano" data-head-year></span> <span id="calendario-mes" data-head-month></span></h4>
                        <a class="pull-right floatRight" data-go="next"><div class="btn btn-primary">Próximo</div></a>
                    </div><hr/>
                    <div class="day-headers">
                        <div class="day header">Dom</div>
                        <div class="day header">Seg</div>
                        <div class="day header">Ter</div>
                        <div class="day header">Qua</div>
                        <div class="day header">Qui</div>
                        <div class="day header">Sex</div>
                        <div class="day header">Sab</div>
                    </div>
                    <div class="days" data-group="days">
                        <!-- the place where days will be generated -->
                    </div>
				</div>
				<!-- Responsive calendar - END -->
          	</div>
        @show
        </div>
      </div>
    </section>
    <!-- END section -->

    <a href="#" class="cta-link" data-toggle="modal" data-target="#modalDefault">
      <span class="sub-heading">Ready to Visit?</span>
      <span class="heading">Make an Appointment</span>
    </a>
    <!-- END cta-link -->
    
    @section('footer')
    <footer class="site-footer" role="contentinfo">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <hr class="border-t">
          </div>
          <div class="col-md-6 col-sm-12 copyright">
            <p>&copy; 2018 Colorlib Medi+. Designed &amp; Developed by <a href="https://colorlib.com/">Colorlib</a></p>
          </div>
          <div class="col-md-6 col-sm-12 text-md-right text-sm-left">
            <a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
            <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
            <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>
          </div>
        </div>
      </div>
    </footer>
    @show
    <!-- END footer -->


    <!-- Modal -->
    @section('modalDefault')
    <div id="modalDefault" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><input type="text"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    @show
    <input type="hidden" id="base_url" value="{{ url('/') }}">
    @section('footerScrits')
    <!--<script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.pt-BR.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
	<script src="{{ asset('calendario/js/responsive-calendar.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/util.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatable/DataTables/datatables.min.js') }}"></script>
    @show
  </body>
</html>