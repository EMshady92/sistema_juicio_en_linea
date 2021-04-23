<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Iniciar sesión | Sistema integral de juicio en linea</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Responsive bootstrap 4 admin template" name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">


        {!!Html::style('assets/css/bootstrap.min.css')!!}
        {!!Html::style('assets/css/icons.min.css')!!}
        {!!Html::style('assets/css/app.min.css')!!}

    </head>

    <body class="authentication-bg">

        <div class="account-pages pt-5 my-5">
            <div class="container">
            @if (Session::has('errors'))
            <div class="alert alert-warning  alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

                <strong>Lo sentimos!</strong> @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach

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
                                                <span><img src="../img/LogoTJA.png" alt="" height="28"></span>
                                            </a>
                                        </div>
                                        <h5 class="text-muted text-uppercase py-3 font-16">Iniciar Sesión</h5>
                                    </div>
    
                                  
                                    {!! Form::open(['route' => 'auth/login', 'class' => 'form']) !!}
    
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="text"  onkeypress="return caracteres(event)" required="" type="email" name="email" id="email" placeholder="Ingresar el email">
                                        </div>
    
                                        <div class="form-group mb-3">
                                            <input class="form-control" type="password" required="" id="password" name="password"  placeholder="Ingresar la contraseña">
                                        </div>
    
                                      <!--   <div class="form-group mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked>
                                                <label class="custom-control-label" for="checkbox-signin">Recordar</label>
                                            </div>
                                        </div> -->
    
                                        <div class="form-group text-center">
                                            <button class="btn btn-success btn-block waves-effect waves-light" type="submit">Ingresar </button>
                                        </div>

                                        <a href="/password/email" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Olvidaste tu contaseña?</a>
    
                                        {!! Form::close() !!}

                                   
    
                                </div> <!-- end card-body -->
                            </div>
                            <!-- end card -->
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">No tienes una cuenta? <a href="../auth/register" class="text-white ml-1"><b>Registrar</b></a></p>
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

        {!!Html::script('js/script.js')!!}
        {!!Html::script('assets/js/vendor.min.js')!!}
        {!!Html::script('assets/js/app.min.js')!!}
    </body>
</html>