<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>REGISTRO DE USUARIOS PARA FIRMA ELECTRÓNICA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive bootstrap 4 admin template" name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->


    {!!Html::style('assets/css/bootstrap.min.css')!!}
    {!!Html::style('assets/css/icons.min.css')!!}
    {!!Html::style('assets/css/app.min.css')!!}


</head>

<body class="authentication-bg">
{!! Form::open(['route' => 'auth/register', 'class' => 'form']) !!}
<div class="container">
               @if (Session::has('errors'))
            <div class="alert alert-warning" role="alert">
            <ul>
                <strong>Oops! Something went wrong : </strong>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="account-pages pt-5 my-5">
        <div class="container">
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
                                    <h5 class="text-muted text-uppercase py-3 font-16">REGISTRO DE USUARIOS PARA FIRMA ELECTRÓNICA</h5>
                                </div>

                                <form action="#" class="mt-2">
                                    <div class="form-group mb-3">
                                        <input class="form-control" id="email" value="{{old('email')}}" name="email" type="email" required=""
                                            placeholder="Ingresa el email">
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control" type="text"  value="{{old('name')}}"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" 
                                        id="name" name="name" required=""
                                            placeholder="Ingresa el nombre completo">
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control" type="text"  value="{{old('apellido_p')}}"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" 
                                        id="apellido_p" name="apellido_p"
                                            placeholder="Ingresa el apellido paterno">
                                    </div>

                                    <div class="form-group mb-3">
                                        <input class="form-control" type="text"  value="{{old('apellido_m')}}"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" 
                                        id="apellido_m" name="apellido_m"
                                            placeholder="Ingresa el apellido materno">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="userName">Sexo<span class="text-danger">*</span></label>
                                        <select class="form-control" style="width: 100%" name="sexo"
                                            data-placeholder="Seleccione una opción ..." id="sexo" required
                                            data-toggle="select2">    
                                            <option value="" selected>Seleccione una opción </option>
                                            <option value="MASCULINO">Masculino</option>
                                            <option value="FEMENINO">Femenino</option>                                           
                                        </select>

                                    </div>

                                    <div class="form-group mb-3">
                                    <label for="userName">Contraseña de usuario para el sistema SIJEL<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password"  required="" name="password" id="password"
                                            placeholder="Ingresa la contraseña">
                                    </div>

                                    <div class="form-group mb-3">
                                    <label for="userName">Confirmar contraseña de usuario para el sistema SIJEL<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" required=""
                                            id="password_confirmation" name="password_confirmation"  onKeyUp="valida_contra();" placeholder="Repite la contraseña">
                                            <div class="text-danger" id='error_pass' name="error_pass" ></div>
                                    </div>

                                    <div class="form-group mb-3">
                                    <label for="userName">Contraseña para Firma Electrónica<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password"  required="" name="passfirma" id="passfirma"
                                            placeholder="Ingresa la contraseña">
                                            <div class="text-danger" id='infor' name="infor" >La contraseña debe contener mínimo 6 caracteres, 1 letra minúscula (a/z), 1 letra mayúscula (A/Z), 1 número (1/9) y 1 carácter especial (-@$!%*#?&_.,<>¿ñ|{}).</div>
                                    </div>

                                    <div class="form-group mb-3">
                                    <label for="userName">Confirmar contraseña para Firma Electrónica<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" required=""
                                            id="passfirma_confirmation" name="passfirma_confirmation"  onKeyUp="valida_contrafirma();" placeholder="Repite la contraseña">
                                            <div class="text-danger" id='error_passfirma' name="error_passfirma" ></div>
                                    </div>

                                    <!-- <div style='display:none' class="form-group mb-3">
                                        <label for="userName">Tipo de usuario<span class="text-danger">*</span></label>
                                        <select class="form-control" style="width: 100%" name="tipo_usuario"
                                            data-placeholder="Seleccione una opción ..." id="tipo_usuario" required
                                            data-toggle="select2">                                                                                   
                                            <option value="ADMINISTRADOR" selected>Administrador </option>
                                            <option value="INVITADO">Invitado</option>
                                            <option value="BASICO">Basico</option>                                          
                                        </select>

                                    </div> -->

                                    <div style='display:none' class="form-group mb-3">
                                        <input class="form-control" type="text"  value="BASICO"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()" 
                                        id="tipo_usuario" name="tipo_usuario" required
                                            placeholder="Ingresa el apellido materno">
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="userName">Función<span class="text-danger">*</span></label>
                                        <select class="form-control" style="width: 100%" name="funcion"
                                            data-placeholder="Seleccione una opción ..." id="funcion" required
                                            data-toggle="select2">    
                                            <option value="" selected>Seleccione una opción </option>                                                                               
                                            <option value="OFICIALIA PARTES">Oficialía de partes </option>
                                            <option value="SECRETARIO AUXILIAR">Secretario Auxiliar</option>
                                            <option value="SECRETARIA GENERAL DE ACUERDOS">Secretaria general de acuerdos</option>  
                                            <option value="PROYECTISTA">Proyectista</option> 
                                            <option value="SECRETARIO DE ESTUDIO Y CUENTA">Secretario de estudio y cuenta</option>
                                            <option value="ACTUARIO">Actuario</option> 
                                            <option value="COORDINADOR">Coordinador</option>
                                            <option value="MAGISTRADO">Magistrado</option>                                           
                                        </select>

                                    </div>



                                    <div class="form-group text-center">
                                        <button class="btn btn-success btn-block waves-effect waves-light"
                                            type="submit" id="submit3">Registrar </button>
                                    </div>

                                </form>



                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-white-50">Ya tienes una cuenta? <a href="../auth/login"
                                    class="text-white ml-1"><b>Inicia sesión</b></a></p>
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
    {!! Form::close() !!}


    {!!Html::script('assets/js/vendor.min.js')!!}
    {!!Html::script('assets/js/app.min.js')!!}
    {!!Html::script('js/script.js')!!}

</body>

</html>