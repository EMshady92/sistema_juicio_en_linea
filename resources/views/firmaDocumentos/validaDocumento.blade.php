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

    {!! Html::style('assets/libs/datatables/dataTables.bootstrap4.min.css') !!}

    {!!Html::style('assets/libs/datatables/buttons.bootstrap4.min.css')!!}
    {!!Html::style('assets/libs/datatables/responsive.bootstrap4.min.css')!!}
    {!!Html::style('assets/libs/datatables/select.bootstrap4.min.css')!!}


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
                        @if(Auth::user()->funcion == "MAGISTRADO" || Auth::user()->funcion == "COORDINADOR" ||
                        Auth::user()->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || Auth::user()->funcion ==
                        "SECRETARIO AUXILIAR" || Auth::user()->funcion == "PROYECTISTA" || Auth::user()->funcion ==
                        "ADMINISTRADOR")
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

    <form id="basic-form" action="{{ url('validadoc') }}" method="post" files="true" enctype="multipart/form-data">

        {{csrf_field()}}

        <section class="section bg-light" id="faqs">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center mb-5">
                            <h3>Detalles del documento consultado</h3>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="userName">Ingrese la clave alfanumérica del documento</label>
                            <input class="form-control" type="text" value="{{$base64}}" name="clave_alfa"
                                id="clave_alfa" placeholder="Ingresa una clave alfanumerica">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="userName">&nbsp;</label><br>
                            <button class="mdi mdi-file-search-outline btn btn-primary waves-effect waves-light mr-1"
                                id="submit" type="submit">
                                Buscar
                            </button>
                        </div>
                    </div>



                </div>

                <div class="row">
                    <div class="col-lg-12">

                        @if($revocado)
                        <div class="alert alert-warning  alert-dismissible fade show mt-4 bt-4" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>


                                <strong>El documento que ha ingresado ya no es valido, fue revocado por {{$revocado->captura}} el dia {{$revocado->created_at}}.</strong>


                            </div>
                        @else
                        @if($doc)
                        <h4 class="header-title">Datos del expediente</h4>
                        <table id="key-table" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        </table>
                        <h4 class="header-title">Datos del documento</h4>
                        <table id="key-table2" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> </table>
                        <h4 class="header-title">Datos de la firma electronica</h4>
                        <table id="key-table3" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;"> </table>


                        @else
                        @if($base64 <> null)
                            <div class="alert alert-warning  alert-dismissible fade show mt-4 bt-4" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>


                                <strong>No existe ningún expediente correspondiente a la clave ingresada.</strong>


                            </div>
                            @endif
                            @endif
                            @endif


                    </div>


                </div>
                <!-- end row -->

                <!-- end -->
            </div>
            <!-- end container-fluid -->
        </section>
    </form>

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

    {!!Html::script('assets/libs/datatables/jquery.dataTables.min.js')!!}
    {!!Html::script('assets/libs/datatables/dataTables.bootstrap4.min.js')!!}

    {!!Html::script('assets/libs/datatables/dataTables.responsive.min.js')!!}
    {!!Html::script('assets/libs/datatables/responsive.bootstrap4.min.js')!!}

    {!!Html::script('assets/libs/datatables/dataTables.buttons.min.js')!!}
    {!!Html::script('assets/libs/datatables/buttons.bootstrap4.min.js')!!}



</body>

</html>

<script type="text/javascript">
$(document).ready(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            myFunction(this);
        }
    };
    xmlhttp.open("GET", '../FIRMASEMITIDAS/XML/{{$doc}}', true);
    xmlhttp.send();
});

function myFunction(xml) {

    var i;
    var xmlDoc = xml.responseXML;
    var table =
        "<tr><th>Número de expediente</th><th>Tipo de juicio</th><th>Tipo</th><th>Fecha del expediente</th><th>Fecha de captura</th><th>Ultima actualización</th></tr>";
    var x = xmlDoc.getElementsByTagName("expediente");
    for (i = 0; i < x.length; i++) {
        table += "<tr><td>" +
            x[i].getElementsByTagName("num_expediente")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("tipo_juicio")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("tipo")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("fecha_expediente")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("fecha_captura")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("ultima_actualizacion")[0].childNodes[0].nodeValue +
            "</td></tr>";
    }
    document.getElementById("key-table").innerHTML = table;

    var y = xmlDoc.getElementsByTagName("datos_documento");
    var table2 =
        "<tr><th>Tipo de documento</th><th>Folio del documento</th><th>Fecha de captura</th><th>Ultima actualización</th></tr>";
    for (i = 0; i < y.length; i++) {
        table2 += "<tr><td>" +
            y[i].getElementsByTagName("tipo_documento")[0].childNodes[0].nodeValue +
            "</td><td>" +
            y[i].getElementsByTagName("folio_documento")[0].childNodes[0].nodeValue +
            "</td><td>" +
            y[i].getElementsByTagName("fecha_captura")[0].childNodes[0].nodeValue +
            "</td><td>" +
            y[i].getElementsByTagName("ultima_actualizacion")[0].childNodes[0].nodeValue +
            "</td></tr>";
    }
    document.getElementById("key-table2").innerHTML = table2;

    var z = xmlDoc.getElementsByTagName("datos_firmante");
    var table3 =
        "<tr><th>Fecha de la firma</th><th>Hora de la firma</th><th>Firmante</th><th>Función o Puesto</th><th>Email</th><th>Folio de la firma</th></tr>";
    for (i = 0; i < x.length; i++) {
        table3 += "<tr><td>" +
            z[i].getElementsByTagName("fecha_firma")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("hora_firma")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("firmante")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("funcion_firmante")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("email_firmante")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("num_firma")[0].childNodes[0].nodeValue +
            "</td></tr>";
    }
    document.getElementById("key-table3").innerHTML = table3;

}
</script>