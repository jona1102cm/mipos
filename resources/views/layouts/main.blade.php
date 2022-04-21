<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ setting('site.title') }}</title>
  <link rel="icon" type="image/x-icon" href="{{ setting('admin.url').'storage/'.setting('site.logo') }}">

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link href="{{ asset('mdb/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('mdb/css/mdb.min.css') }}" rel="stylesheet">
  <meta name="theme-color" content="{{ setting('site.color') }}">

  <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="{{ setting('site.title') }}">
    <link rel="icon" sizes="512x512" href="{{ setting('admin.url').'storage/'.setting('site.logo') }}">


  <style type="text/css">
    html,
    body,
    header,
    .view.jarallax {
      height: 100%;
      min-height: 100%;
    }
  </style>
</head>

<body class="restaurant-lp">

    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light scrolling-navbar white">
        <div class="container">
            <a class="navbar-brand" href="#">
            <strong>{{ setting('site.title') }}</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!--Links-->
            <ul class="navbar-nav mr-auto smooth-scroll">
                <li class="nav-item">
                <a class="nav-link" href="#home">Home
                    <span class="sr-only">(current)</span>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#about" data-offset="100">About</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#intro" data-offset="100">Intro</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#specials" data-offset="100">Specials</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#menu" data-offset="100">Menu</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#testimonials" data-offset="100">Opinions</a>
                </li>
            </ul>

            <!--Social Icons-->
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                <a class="nav-link">
                    <i class="fab fa-facebook-f light-green-text"></i>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link">
                    <i class="fab fa-twitter light-green-text"></i>
                </a>
                </li>
                <li class="nav-item">
                <a class="nav-link">
                    <i class="fab fa-instagram light-green-text"></i>
                </a>
                </li>
            </ul>
            </div>
        </div>
        </nav>
        <!--/Navbar-->

        <!-- Intro Section -->
        @php
            $intro = json_decode(setting('site.intro_section'));
        @endphp
        <div id="home" class="view jarallax" data-jarallax='{"speed": 0.9}' style="background-image: url({{ setting('admin.url').'storage/'.$intro->image }}); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="mask rgba-black-slight">
            <div class="container h-100 d-flex justify-content-center align-items-center">
            <div class="row smooth-scroll">
                <div class="col-md-12 dark-grey-text text-center">
                <div class="wow fadeInDown" data-wow-delay="0.9s">
                    <h2 class="display-3 font-weight-bold mb-2 mt-5 mt-xl-2">{{ $intro->title }}</h2>
                    <hr class="hr-dark">
                    {{-- <h4 class="subtext-header mt-2 mb-3">{{ $intro->descripcion}}</h4> --}}
                    <h4 class="mb-5 clearfix d-none d-md-inline-block">{{ $intro->descripcion}}</h4>
                </div>
                <a href="{{ route('pages', 'catalogo') }}" class="btn btn-deep-orange btn-rounded wow fadeInUp" data-wow-delay="0.9s">
                    <i class="far fa-calendar-alt mr-2"></i>
                    <span>Ver Catalgo</span>
                </a>
                </div>
            </div>
            </div>
        </div>
        </div>

    </header>

    <main>
        @yield('content')
    </main>

    <footer class="page-footer text-center text-md-left pt-4">

        <!--Footer Links-->
        <div class="container mb-4">

        <!--First row-->
        <div class="row">

            <!--First column-->
            <div class="col-lg-4 pt-1 pb-3 wow fadeIn" data-wow-delay="0.3s">
            <!--About-->
            <h5 class="title mb-4">
                <strong>ABOUT RESTAURANT</strong>
            </h5>

            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti.</p>

            <p class="mb-1-half"> Blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas
                molestias excepturi sint.</p>
            <!--/About -->

            <div class="footer-socials">

                <!--Facebook-->
                <a type="button" class="btn-floating green">
                <i class="fab fa-facebook-f"></i>
                </a>
                <!--Dribbble-->
                <a type="button" class="btn-floating green">
                <i class="fab fa-dribbble"></i>
                </a>
                <!--Twitter-->
                <a type="button" class="btn-floating green">
                <i class="fab fa-twitter"></i>
                </a>
                <!--Google +-->
                <a type="button" class="btn-floating green">
                <i class="fab fa-google-plus-g"></i>
                </a>
                <!--Linkedin-->

            </div>
            </div>
            <!--/First column-->

            <hr class="w-100 clearfix d-md-none">

            <!--Second column-->
            <div class="col-lg-4 pt-1 pb-1 col-md-6 wow fadeIn" data-wow-delay="0.3s">
            <!--Search-->
            <h5 class="text-uppercase mb-4">
                <strong>Search something</strong>
            </h5>

            <ul class="footer-search list-unstyled">
                <li>
                <form class="search-form" role="search">
                    <div class="md-form">
                    <input type="text" class="form-control text-white" placeholder="Search">
                    </div>
                </form>
                </li>
            </ul>

            <!--Info-->
            <p>
                <i class="fas fa-home mr-3"></i> New York, NY 10012, US</p>
            <p>
                <i class="fas fa-envelope mr-3"></i> info@example.com</p>
            <p>
                <i class="fas fa-phone mr-3"></i> + 01 234 567 88</p>
            <p>
                <i class="fas fa-print mr-3"></i> + 01 234 567 89</p>

            </div>
            <!--/Second column-->

            <hr class="w-100 clearfix d-md-none">

            <!--First column-->
            <div class="col-lg-4 pt-1 pb-1 col-md-6 wow fadeIn text-center" data-wow-delay="0.3s">

            <!--Title-->
            <h5 class="title mb-4 text-uppercase">
                <strong>Opening hours</strong>
            </h5>

            <!--Opening hours table-->
            <table class="table text-white">
                <tbody>
                <tr>
                    <td>Mon - Thu:</td>
                    <td>8am - 9pm</td>
                </tr>
                <tr>
                    <td>Fri - Sat:</td>
                    <td>8am - 1am</td>
                </tr>
                <tr>
                    <td>Sunday:</td>
                    <td>9am - 10pm</td>
                </tr>
                </tbody>
            </table>

            </div>
            <!--/First column-->

        </div>
        <!--/First row-->

        </div>
        <!--/Footer Links-->

        <!--Copyright-->
        <div class="footer-copyright py-3 text-center" data-wow-delay="0.3s">
        <div class="container-fluid">
            © 2019 Copyright: <a href="https://mdbootstrap.com/education/bootstrap/" target="_blank"> MDBootstrap.com </a>
        </div>
        </div>
        <!--/Copyright-->

    </footer>
    <script type="text/javascript" src="{{ asset('mdb/js/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb/js/mdb.min.js') }}"></script>

    <script>
        //Animation init
        new WOW().init();

        //Modal
        $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
        })

        // Material Select Initialization
        $(document).ready(function () {
        $('.mdb-select').material_select();
        });

        // MDB Lightbox Init
        $(function () {
        $("#mdb-lightbox-ui").load("{{ asset('mdb/mdb-addons/mdb-lightbox-ui.html') }}");
        });

    </script>

</body>

</html>
