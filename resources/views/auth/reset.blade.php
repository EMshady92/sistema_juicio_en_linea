<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reestablecer Contraseña</title>
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
                                        <p class="text-muted">Por favor ingrese una nueva contraseña.</p>
                                    </div>
                                </div>

<form method="POST" action="{{url('password/reset')}}">
    {{csrf_field()}}
    <input type="hidden" name="token" value="{{$token}}" />

 
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" value="{{$email}}" />
        <div class="text-danger">{{$errors->first('email')}}</div>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" />
        <div class="text-danger">{{$errors->first('password')}}</div>
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirmar Password:</label>
        <input type="password" class="form-control" name="password_confirmation" />
    </div>
    <button type="submit" class="btn btn-primary">Resetear Password</button>
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