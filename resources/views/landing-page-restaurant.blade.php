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

        <!--First container-->
        <div class="container">
            <!--Section: About-->
            <section id="about" class="about mt-3 mb-5">
                <!--Secion heading-->
                <div class="row mt-5 mb-4">
                    <div class="col-md-12">
                        <div class="divider-new">
                        <h3 class="text-center text-uppercase font-weight-bold mr-3 ml-3 wow fadeIn" data-wow-delay="0.2s">about us</h3>
                        </div>
                    </div>
                    <!--First row-->
                    <div class="row mt-4">

                        <!--First column-->
                        <div class="col-lg-5 col-md-12 mb-3 wow fadeIn" data-wow-delay="0.4s">

                        <!--Image-->
                        <img src="https://mdbootstrap.com/img/Others/food2.jpg" alt="" class="z-depth-0 img-fluid">

                        </div>
                        <!--/First column-->

                        <!--Second column-->
                        <div class="col-lg-6 offset-lg-1 col-md-12 wow fadeIn" data-wow-delay="0.4s">

                        <!--Title-->
                        <h4 class="text-center mb-4">We make good food and friendly atmosphere</h4>

                        <!--Description-->
                        <p class="grey-text mb-6 mr-3  ml-3" align="justify">Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Nemo animi soluta ratione quisquam,
                            dicta ab cupiditate iure eaque? Repellendus voluptatum, magni impedit eaque delectus, beatae
                            maxime temporibus maiores quibusdam quasi.Rem magnam ad perferendis iusto sint tempora ea
                            voluptatibus iure, animi excepturi modi aut possimus in hic molestias repellendus illo ullam
                            odit quia velit.</p>

                        </div>
                        <!--/Second column-->

                    </div>
                    <!--/First row-->
                </div>
            </section>
            <!--/Section: About-->
        </div>
        <!--/First container-->

        <!--Streak-->
        <div class="streak streak-photo streak-md" style="background-image: url('https://mdbootstrap.com/img/Others/food31.jpg');">
            <div class="flex-center mask rgba-black-strong">
                <div class="text-center white-text">
                <h2 class="h2-responsive mb-5">
                    <i class="fas fa-quote-left" aria-hidden="true"></i> Food for the body is not enough. There must be food
                    for the soul.
                    <i class="fas fa-quote-right" aria-hidden="true"></i>
                </h2>
                <h5 class="text-center font-italic">~ Dorothy Day</h5>
                </div>
            </div>
        </div>
        <!--/Streak-->

        <!--Second container-->
        <div class="container">
            <!--Section: Menu intro-->
            <section id="intro" class="mt-3 mb-4">

                <!--Section heading-->
                <div class="row mt-5 mb-4">
                    <div class="col-md-12 mb-3">
                        <div class="divider-new">
                        <h3 class="text-center text-uppercase font-weight-bold mr-3 ml-3 wow fadeIn" data-wow-delay="0.2s">Discover
                            our delights</h3>
                        </div>
                    </div>
                </div>

                <!--First row-->
                <div class="row smooth-scroll">

                    <!--First column-->
                    <div class="col-lg-6 col-md-12 wow fadeIn" data-wow-delay="0.4s">

                        <!--Title-->
                        <h4 class="mb-4 text-center">All European cuisine in one place</h4>

                        <!--Description-->
                        <p class="grey-text mb-4" align="justify">At vero eos et accusamus et iusto odio dignissimos ducimus qui
                        blanditiis praesentium voluptatum
                        deleniti atque corrupti quos dolores et quas molstias excepturi sint occaecati cupiditate non
                        provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum
                        fuga.
                        </p>

                        <!--Menu button-->
                        <div class="text-center mb-2 mt-2">
                        <a href="#menu" data-offset="100" class="btn btn btn-outline-grey btn-rounded waves-effect">
                            <strong>See full menu</strong>
                        </a>
                        </div>

                    </div>
                    <!--/First column-->

                    <!--Second column-->
                    <div class="col-lg-5 ml-auto col-md-12 mb-5 wow fadeIn" data-wow-delay="0.4s">

                        <!--Image-->
                        <img src="https://mdbootstrap.com/img/Others/food.jpg" alt="" class="z-depth-0 img-fluid">

                    </div>
                    <!--/Second column-->

                </div>
                <!--/First row-->

            </section>
            <!--/Section: Menu intro-->
        </div>

        <hr>

        <!--Section: Products-->
        <div class="container">

        <section id="specials">

            <!--Secion heading-->
            <div class="row mt-5 mb-4">
            <div class="col-md-12">
                <div class="divider-new">
                <h3 class="text-center text-uppercase font-weight-bold mr-3 ml-3 wow fadeIn" data-wow-delay="0.2s">our
                    specials</h3>
                </div>
            </div>

            <p class="grey-text text-center ml-3 mr-3 mt-1 mb-5">At vero eos et accusamus et iusto odio dignissimos
                ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident,
                similique.
            </p>

            <!--First row-->
            <div class="row text-center mr-2 ml-2 mt-3">

                <!--First column-->
                <div class="col-lg-4 col-md-12 mb-4 wow fadeIn" data-wow-delay="0.4s">

                <!--Card-->
                <div class="card card-cascade wider">

                    <!--Card image-->
                    <div class="view view-cascade overlay zoom">
                    <img src="https://mdbootstrap.com/img/Others/food6.jpg" class="img-fluid">
                    <a href="#!">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                    </div>
                    <!--/Card image-->

                    <!--Card content-->
                    <div class="card-body card-body-cascade text-center">
                    <!--Title-->
                    <h4 class="card-title">
                        <strong>Breakfast</strong>
                    </h4>

                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

                </div>
                <!--/First column-->

                <!--Second column-->
                <div class="col-lg-4 col-md-6 mb-4 wow fadeIn" data-wow-delay="0.4s">

                <!--Card-->
                <div class="card card-cascade wider">

                    <!--Card image-->
                    <div class="view view-cascade overlay zoom">
                    <img src="https://mdbootstrap.com/img/Photos/Horizontal/Food/4-col/img%20(53).jpg" class="img-fluid">
                    <a href="#!">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                    </div>
                    <!--/Card image-->

                    <!--Card content-->
                    <div class="card-body card-body-cascade text-center">
                    <!--Title-->
                    <h4 class="card-title">
                        <strong>Launches</strong>
                    </h4>

                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

                </div>
                <!--/Second column-->

                <!--Third column-->
                <div class="col-lg-4 col-md-6 mb-4 wow fadeIn" data-wow-delay="0.4s">

                <!--Card-->
                <div class="card card-cascade wider">

                    <!--Card image-->
                    <div class="view view-cascade overlay zoom">
                    <img src="https://mdbootstrap.com/img/Others/food7.jpg" class="img-fluid">
                    <a href="#!">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                    </div>
                    <!--/Card image-->

                    <!--Card content-->
                    <div class="card-body card-body-cascade text-center">
                    <!--Title-->
                    <h4 class="card-title">
                        <strong>Desserts</strong>
                    </h4>

                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->

                </div>
                <!--/Third column-->

            </div>
            <!--/First row-->

            </div>

        </section>

        </div>
        <!--/Section: Products-->

        <!--Streak-->
        <div class="streak streak-photo streak-long-2" style="background-image:url('https://mdbootstrap.com/img/Others/food5.jpg')">
        <div class="mask flex-center rgba-black-strong">
            <div class="container">

            <h2 class="text-center text-white mb-5 text-uppercase font-weight-bold wow fadeIn" data-wow-delay="0.2s">Great
                people trusted our services</h2>

            <!--First row-->
            <div class="row text-white text-center wow fadeIn" data-wow-delay="0.2s">

                <!--First column-->
                <div class="col-md-3 mb-2">
                <h1 class="green-text mb-1 font-weight-bold py-3">+950</h1>
                <p class="mb-3">Happy clients</p>
                </div>
                <!--/First column-->

                <!--Second column-->
                <div class="col-md-3 mb-2">
                <h1 class="green-text mb-1 font-weight-bold py-3">+150</h1>
                <p class="mb-3">Projects completed</p>
                </div>
                <!--/Second column-->

                <!--Third column-->
                <div class="col-md-3 mb-2">
                <h1 class="green-text mb-1 font-weight-bold py-3">+85</h1>
                <p class="mb-3">Winning awards</p>
                </div>
                <!--/Third column-->

                <!--Fourth column-->
                <div class="col-md-3">
                <h1 class="green-text mb-1 font-weight-bold py-3">+246</h1>
                <p class="mb-3">Cups of coffee</p>

                </div>
                <!--/Fourth column-->

            </div>
            <!--/First row-->
            </div>
        </div>
        </div>
        <!--/Streak-->

        <!--Section: Menu-->
        <div class="container">

        <section class="my-4" id="products">

            <!--Secion heading-->
            <div class="row mt-5 mb-4">
            <div class="col-md-12">
                <div class="divider-new">
                <h3 class="text-center text-uppercase font-weight-bold mr-3 ml-3 wow fadeIn" data-wow-delay="0.2s">The
                    menu</h3>
                </div>
            </div>
            </div>

            <!--Section description-->
            <p class="text-center grey-text w-responsive mx-auto mb-5 wow fadeIn" data-wow-delay="0.2s">Lorem ipsum dolor
            sit amet, consectetur adipisicing elit. Fugit, error amet numquam iure provident voluptate
            esse quasi, veritatis totam voluptas nostrum quisquam eum porro a pariatur accusamus veniam.
            </p>

            <!--First row-->
            <div class="row wow fadeIn flex-center" data-wow-delay="0.4s">
            <!--First column-->
            <div class="col-lg-8 col-md-10">

                <!--Menu-->
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr class="table-success">
                        <th>#</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Tomato soup</td>
                        <td>400 ml</td>
                        <td>5 $</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Caesar salad</td>
                        <td>150 g</td>
                        <td>10 $</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Beef steak</td>
                        <td>200 g</td>
                        <td>15 $</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>Dumplings</td>
                        <td>6 pieces</td>
                        <td>8 $</td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>Apple cake</td>
                        <td>80 g</td>
                        <td>6 $</td>
                    </tr>
                    </tbody>
                </table>
                </div>
                <!--Menu-->

            </div>
            <!--/First column-->
            </div>
            <!--/First row-->

        </section>

        </div>
        <!--/Section: Menu-->

        <!--Gallery-->
        <div class="container-fluid mt-5">

        <!--Section: Main portfolio-->
        <section id="portfolio">

            <!--First row-->
            <div class="row wow fadeIn" data-wow-delay="0.4s">

            <!--First column-->
            <div class="col-md-12">

                <div id="mdb-lightbox-ui"></div>

                <!--Full width lightbox-->
                <div class="mdb-lightbox">

                <figure class="col-md-4">
                    <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(40).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(40).jpg" class="img-fluid z-depth-1-half">
                    </a>
                </figure>

                <figure class="col-md-4">
                    <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(48).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(48).jpg" class="img-fluid z-depth-1-half">
                    </a>
                </figure>

                <figure class="col-md-4">
                    <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(42).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(42).jpg" class="img-fluid z-depth-1-half">
                    </a>

                </figure>
                <figure class="col-md-4">
                    <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(44).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(44).jpg" class="img-fluid z-depth-1-half">
                    </a>
                </figure>

                <figure class="col-md-4">
                    <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(41).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(41).jpg" class="img-fluid z-depth-1-half">
                    </a>
                </figure>

                <figure class="col-md-4">
                    <a href="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(47).jpg" data-size="1600x1067">
                    <img src="https://mdbootstrap.com/img/Photos/Lightbox/Original/img%20(47).jpg" class="img-fluid z-depth-1-half">
                    </a>
                </figure>

                </div>
                <!--/Full width lightbox-->

            </div>
            <!--/First column-->

            </div>
            <!--/First row-->

        </section>
        <!--/Section: Main portfolio-->

        </div>
        <!--/Gallery-->

        <div class="container">

        <!--Section: Testimonials v.3-->
        <section id="testimonials" class="team-section mt-2 mb-5">

            <!--Secion heading-->
            <div class="row mt-5 mb-4">
                <div class="col-md-12">
                <div class="divider-new">
                    <h3 class="text-center text-uppercase font-weight-bold mr-3 ml-3 wow fadeIn" data-wow-delay="0.2s">Our
                    Guests opinions</h3>
                </div>
                </div>
                <!--/Secion heading-->

                <!--Section description-->
                <p class="text-center grey-text w-responsive mx-auto mb-5 wow fadeIn" data-wow-delay="0.2s">Lorem ipsum dolor
                sit amet, consectetur adipisicing elit. Fugit, error amet numquam iure provident voluptate
                esse quasi, veritatis totam voluptas nostrum quisquam eum porro a pariatur accusamus veniam.
                </p>

                <!--First row-->
                <div class="row text-center">

                <!--First column-->
                <div class="col-md-4 mb-4 wow fadeIn" data-wow-delay="0.4s">

                    <div class="testimonial">
                    <!--Avatar-->
                    <div class="avatar mx-auto mb-4">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%285%29.jpg" class="rounded-circle img-fluid z-depth-1-half">
                    </div>

                    <!--Content-->
                    <h4 class="font-weight-bold">Anna Deynah</h4>
                    <p>
                        <i class="fas fa-quote-left "></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos
                        id officiis hic
                        tenetur quae quaerat ad velit ab.
                    </p>

                    <!--Review-->
                    <div class="green-text">
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star-half-alt"> </i>
                    </div>
                    </div>
                </div>
                <!--/First column-->

                <!--Second column-->
                <div class="col-md-4 mb-4 wow fadeIn" data-wow-delay="0.4s">
                    <div class="testimonial">
                    <!--Avatar-->
                    <div class="avatar mx-auto mb-4">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%289%29.jpg" class="rounded-circle img-fluid z-depth-1-half">
                    </div>

                    <!--Content-->
                    <h4 class="font-weight-bold">John Doe</h4>
                    <p>
                        <i class="fas fa-quote-left"></i> Ut enim ad minima veniam, quis nostrum exercitationem ullam
                        corporis suscipit laboriosam,
                        nisi ut aliquid ex ea commodi.</p>

                    <!--Review-->
                    <div class="green-text">
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                    </div>
                    </div>
                </div>
                <!--/Second column-->

                <!--Third column-->
                <div class="col-md-4 mb-4 wow fadeIn" data-wow-delay="0.4s">
                    <div class="testimonial">
                    <!--Avatar-->
                    <div class="avatar mx-auto mb-4">
                        <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%288%29.jpg" class="rounded-circle img-fluid z-depth-1-half">
                    </div>
                    <!--Content-->
                    <h4 class="font-weight-bold">Tom Smith</h4>
                    <p>
                        <i class="fas fa-quote-left"></i> At vero eos et accusamus et iusto odio dignissimos ducimus qui
                        blanditiis praesentium
                        voluptatum deleniti atque corrupti.</p>

                    <!--Review-->
                    <div class="green-text">
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="fas fa-star"> </i>
                        <i class="far fa-star"> </i>
                    </div>

                    </div>
                </div>
                <!--/Third column-->

                </div>
                <!--/First row-->
            </div>

        </section>
        <!--/Section: Testimonials v.3-->

        </div>

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


