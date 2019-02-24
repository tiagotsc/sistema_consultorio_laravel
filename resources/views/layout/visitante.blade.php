<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Consultório Online+</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/personalizado.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
        <div id="app">
                
    <!--   
        <header role="banner">
        <div style="height:43px" class="top-bar">  
        </div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div style="margin-top: 18px; margin-bottom: 18px" class="container">
            <a class="navbar-brand" href="index.html">Medi<span>+</span>  </a>
            </div>
        </nav>
        </header>
    -->
        <header role="banner">
            <div id="visitante-top-bar" class="top-bar"></div>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand" href="index.html">Consultório Online<span>+</span>  </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Logar</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrar</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <!-- END header -->

        <section class="section bg-light custom-tabs">
        <div class="container">
            <div class="row">
            @section('content')
            @show
            </div>
        </div>
        </section>
        <!-- END section -->
        <!-- END cta-link -->

        @section('footer')
        <footer id="visitante-footer" class="site-footer" role="contentinfo">
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <hr class="border-t">
            </div>
            <div class="col-md-6 col-sm-12 copyright">
                <p>&copy; {{date('Y')}} Consultório Online+. Desenvolvido por: <a target="_blank" href="https://github.com/tiagotsc">Tiago Costa</a></p>
            </div>
            <div class="col-md-6 col-sm-12 text-md-right text-sm-left">
                <!--<a href="#" class="p-2"><span class="fa fa-facebook"></span></a>
                <a href="#" class="p-2"><span class="fa fa-twitter"></span></a>
                <a href="#" class="p-2"><span class="fa fa-instagram"></span></a>-->
            </div>
            </div>
        </div>
        </footer>
        @show
    </div>
    <!-- END footer -->
    @section('footerScrits')
    <script src="{{ asset('js/app.js') }}"></script>
    <!--<script src="{{ asset('js/personalizado.js') }}"></script>-->
    @show
  </body>
</html>