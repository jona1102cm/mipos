<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ setting('site.title') }}</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link href="{{ asset('mdb2/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('mdb2/css/mdb.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    @yield('css')
</head>

<body class="homepage-v2 hidden-sn white-skin animated">
    <header>
        <ul id="slide-out" class="side-nav custom-scrollbar">
        <li>
            <div class="logo-wrapper waves-light">
            <a href="#"><img src="{{ setting('admin.url').'storage/'.setting('site.banner') }}" class="img-fluid flex-center"></a>
            </div>
        </li>
        <li>
            <ul class="collapsible collapsible-accordion">
            @php
                $menus =  DB::table('menu_items')->where('menu_id', setting('site.menu_movil'))->orderBy('order','asc')->get();
            @endphp
            @foreach ($menus as $item)
                <li>
                <a href="{{ route('pages', $item->url) }}" class="collapsible-header waves-effect"><i class="fas fa-plus"></i>
                {{ $item->title }}</a>
                </li>
            @endforeach
            </ul>
        </li>
        <div class="sidenav-bg mask-strong"></div>
        </ul>
        <nav class="navbar fixed-top navbar-expand-lg  navbar-light scrolling-navbar white">
            <div class="container-fluid">
                <!-- SideNav slide-out button -->
                <div class="float-left mr-2">
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="fas fa-bars"></i></a>
                </div>
                <a class="navbar-brand font-weight-bold" href="/"><strong>{{ $page->name }}</strong></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4"
                aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                </button>
                <div class="float-rigth mr-2">
                <a href="#" data-activates="slide-out" class="button-collapse">
                    <i class="fas fa-shopping-cart"><span class="badge rounded-pill badge-notification bg-danger"><div id="micount"></div></span></i>
                </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                </div>
            </div>
        </nav>
    </header>

    @yield('content')

    <footer class="page-footer text-center text-md-left stylish-color-dark pt-0">
        <div class="footer-copyright py-3 text-center">
        <div class="container-fluid">
            ©2022 <a href="https://loginweb.dev" target="_blank">LoginWeb - Diseño y Desarrollo de Software</a>
        </div>
        </div>
    </footer>

    <script type="text/javascript" src="{{ asset('mdb2/js/jquery-3.4.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb2/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb2/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('mdb2/js/mdb.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

    <script type="text/javascript">
        new WOW().init();
        $(function () {
        $('[data-toggle="tooltip"]').tooltip()
        })
        $(document).ready(function () {

        $('.mdb-select').material_select();
        });
        $(".button-collapse").sideNav();
    </script>

@yield('javascript')
</body>
</html>
