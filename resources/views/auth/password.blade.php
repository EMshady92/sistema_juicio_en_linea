<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Recuperar Contraseña</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="">


    <!-- App css -->
    {!!Html::style('assets/css/bootstrap.min.css')!!}
    {!!Html::style('assets/css/icons.min.css')!!}
    {!!Html::style('assets/css/app.min.css')!!}


</head>

<body class="authentication-bg">

    <div class="account-pages pt-5 my-5">
        <div class="container">
            @if (Session::has('errors') )
            <div class="alert alert-warning  alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Lo sentimos!</strong> @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach

            </div>
            @elseif(Session::has('status'))
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{ Session::get('status') }}</strong>
            </div>
            @endif

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="account-card-box">
                        <div class="card mb-0">
                            <div class="card-body p-4">

                                <div class="text-center">
                                    <div class="my-3">
                                        <a href="/">
                                            <span><img src="/img/LogoTJA.png" alt="" height="28"></span>
                                        </a>
                                    </div>
                                    <div class="py-3">
                                        <h5 class="text-muted text-uppercase font-16">Reestablecer contraseña</h5>
                                        <p class="text-muted">Ingrese su dirección de correo electrónico y le enviaremos
                                            un correo electrónico con instrucciones para restablecer su contraseña.</p>
                                    </div>
                                </div>

                                <form action="/password/email" id="form" method="post" files="true"
                                    enctype="multipart/form-data" class="form-horizontal parsley-examples">
                                    {{csrf_field()}}




                                    <div class="form-group mb-3">
                                        <input class="form-control" type="email" id="email" name="email" required=""
                                            placeholder="Ingresa tu email">
                                        <div class="text-danger" id='error_email' name="error_email"></div>
                                    </div>

                                    <div class="form-group text-center mb-0">
                                        <button class="btn btn-success btn-block waves-effect waves-light" id="submit"
                                            type="submit"> Enviar Email </button>
                                    </div>

                                </form>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Regresar a <a href="/auth/login" class="text-white ml-1"><b>Log
                                        In</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="assets/js/app.min.js"></script>


</body>

</html>