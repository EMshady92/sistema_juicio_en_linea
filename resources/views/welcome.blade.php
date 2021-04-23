<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Integral de Manejo de Expedientes</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="TecnoRed" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="Lading/images/favicon.ico">


    {!!Html::style('Landing/css/bootstrap.min.css')!!}
    {!!Html::style('Landing/css/materialdesignicons.min.css')!!}
    {!!Html::style('Landing/css/owl.carousel.min.css')!!}
    {!!Html::style('Landing/css/style.min.css')!!}

</head>

<body>

    <!--Navbar Start-->
    <nav class="navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark">
        <div class="container-fluid">
            <!-- LOGO -->
            <a class="logo text-uppercase" href="index.html">
                <img src="images/logo-light.png" alt="" class="logo-light" height="22" />
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="mdi mdi-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto navbar-center" id="mySidenav">
                    <li class="nav-item active">
                        <a href="/" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Acerca de nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>
                @if (Auth::guest())
                <div class="btn-group mr-1 mt-1">
                    <button type="button" class="btn btn-secondary dropdown-toggle waves-effect waves-light"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Inicia sesión <i class="mdi mdi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="/auth/login">Iniciar Sesión</a>
                        <a class="dropdown-item" href="/auth/register">Registrarse</a>
                    </div>
                </div>


                @else
                <div class="btn-group mr-1 mt-1">
                    <button type="button" class="btn btn-secondary dropdown-toggle waves-effect waves-light"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                    @if(Auth::user()->funcion == "MAGISTRADO" || Auth::user()->funcion == "COORDINADOR" || Auth::user()->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || Auth::user()->funcion == "SECRETARIO AUXILIAR" || Auth::user()->funcion == "PROYECTISTA" || Auth::user()->funcion == "ADMINISTRADOR")
                        <a class="dropdown-item" href="/magistradoExpedientes">Salas</a>
                    @endif

                    @if(Auth::user()->funcion == "OFICIALIA PARTES" || Auth::user()->funcion == "ADMINISTRADOR")
                        <a class="dropdown-item" href="/expedientes">Expedientes</a>
                    @endif

                     @if(Auth::user()->funcion == "ACTUARIO" || Auth::user()->funcion == "ADMINISTRADOR")
                        <a class="dropdown-item" href="#">Actuarios</a>
                    @endif      
                
                        <a class="dropdown-item" href="/auth/logout">Salir</a>
                    </div>
                </div>

                @endif


            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero section Start -->
    <section class="hero-section bg-dark" id="home">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="hero-wrapper text-center pt-2 pb-2">
                        <h1 class="text-white mb-4">Sistema Integral de Manejo de Expedientes</h1>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div allign="center">
                        <div class="hero-wrapper text-center pt-2 pb-2">
                            <img src="/img/marca_agua_tja.png" alt="" allign="center" width="400" height="450"
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero section End -->







    <!-- Faq start -->
    <section class="section bg-light" id="faqs">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center mb-5">
                        <h3>Bienvenido al Sistema Integral de Manejo de Expedientes</h3>
                        <p class="text-muted">Consulta nuestros servicios.</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="question-box p-3">
                        <h5 class="font-16"><i
                                class="mdi mdi-numeric-1-circle-outline mr-2 font-18 align-middle text-success"></i>
                            Servicio 1</h5>
                        <div class="float-left">
                            <i class="mdi mdi-arrow-right mr-3"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p>Texto 1 .</p>
                        </div>
                    </div>

                    <div class="question-box p-3">
                        <h5 class="font-16"><i
                                class="mdi mdi-numeric-2-circle-outline mr-2 font-18 align-middle text-success"></i>
                            Servicio 2</h5>
                        <div class="float-left">
                            <i class="mdi mdi-arrow-right mr-3"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p>Texto 2 .</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="question-box p-3">
                        <h5 class="font-16"><i
                                class="mdi mdi-numeric-3-circle-outline mr-2 font-18 align-middle text-success"></i>
                            Servicio 3</h5>
                        <div class="float-left">
                            <i class="mdi mdi-arrow-right mr-3"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p>Texto 3 .</p>
                        </div>
                    </div>

                    <div class="question-box p-3">
                        <h5 class="font-16"><i
                                class="mdi mdi-numeric-4-circle-outline mr-2 font-18 align-middle text-success"></i>
                            Servicio 4</h5>
                        <div class="float-left">
                            <i class="mdi mdi-arrow-right mr-3"></i>
                        </div>
                        <div class="overflow-hidden">
                            <p>Texto 4 .</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-4">
                        <a href="#" class="btn btn-primary">Ver más <i class="mdi mdi-arrow-right ml-2"></i></a>
                    </div>
                </div>
            </div>
            <!-- end -->
        </div>
        <!-- end container-fluid -->
    </section>
    <!-- Faq end -->

    <!-- Footer start -->
    <footer class="bg-dark footer pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-sm-6">
                    <div>
                        <div class="mb-3">
                            <img src="img/LogoTJA.png" alt="" height="20">
                        </div>
                        <p class="pt-1 text-white-50">Sistema Integral de Manejo de Expedientesa.</p>

                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="mt-3 mt-sm-0">
                        <h5 class="footer-title text-white font-16 mb-3">Acerca de</h5>
                        <ul class="list-unstyled footer-list">
                            <li><a href="/">Inicio</a></li>
                            <li><a href="">Acerca de nosotros</a></li>
                            <li><a href="">Servicios</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6">
                    <div class="mt-3 mt-sm-0">
                        <h5 class="footer-title text-white font-16 mb-3">Soporte</h5>
                        <ul class="list-unstyled footer-list">
                            <li><a href="">Ayuda y Soporte</a></li>
                            <li><a href="">Politica de privacidad</a></li>
                            <li><a href="">Terminos & Condiciones</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="mt-3 mt-sm-0">
                        <h5 class="footer-title text-white font-16 mb-3">Contacto</h5>
                        <div>
                            <p class="text-white-50 mb-2"><i
                                    class="mdi mdi-map-marker-outline text-white font-18 mr-2 align-middle"></i>Avenida
                                Pedro Coronel No. 120 A.
                                Fraccionamiento Los Geranios. C.P. 98619</p>
                            <p class="text-white-50 mb-2"><i
                                    class="mdi mdi-phone text-white font-18 mr-2 align-middle"></i> (492) 922 9327 y
                                (492) 922 2927</p>
                            <p class="text-white-50"><i
                                    class="mdi mdi-email-outline text-white font-18 mr-2 align-middle"></i>presidencia@trijazac.gob.mx
                                transparencia@trijazac.gob.mx</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->

        <div class="footer-alt py-3 mt-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="text-white-50 mb-md-0 float-md-left">2021 Tribunal de Justicia Administrativa del
                                Estado de Zacatecas <a href="http://www.trijazac.gob.mx/" target="_blank"
                                    class="text-white">(c)</a> </p>
                            <ul class="list-inline social-links float-md-right mb-0">
                                <li class="list-inline-item"><a href="https://www.facebook.com/Trijazac"><i
                                            class="mdi mdi-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="https://twitter.com/TribunaldeJust1"><i
                                            class="mdi mdi-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="https://www.instagram.com/trijazac/"><i
                                            class="mdi mdi-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer end -->

    <!-- Back to top -->
    <a href="#" class="back-to-top" id="back-to-top"> <i class="mdi mdi-chevron-up"> </i> </a>

    <!-- Javascript -->
    {!!Html::script('Landing/js/jquery.min.js')!!}
    {!!Html::script('Landing/js/bootstrap.bundle.min.js')!!}
    {!!Html::script('Landing/js/jquery.easing.min.js')!!}
    {!!Html::script('Landing/js/scrollspy.min.js')!!}
    {!!Html::script('Landing/js/owl.carousel.min.js')!!}
    {!!Html::script('Landing/js/app.js')!!}



</body>

</html>