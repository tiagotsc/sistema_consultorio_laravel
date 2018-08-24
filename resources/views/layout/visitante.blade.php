<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>Colorlib Medi+</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}">
  </head>
  <body>
    
    <header role="banner">
      <div style="height:43px" class="top-bar">  
      </div>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div style="margin-top: 18px; margin-bottom: 18px" class="container">
          <a class="navbar-brand" href="index.html">Medi<span>+</span>  </a>
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
    <footer style="position: absolute; bottom: 0px; width: 100%" class="site-footer" role="contentinfo">
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
    @section('footerScrits')
    <script src="{{ asset('js/app.js') }}"></script>
    @show
  </body>
</html>