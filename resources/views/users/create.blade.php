@extends('layouts.principal')
@section('contenido')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                        <li class="breadcrumb-item active">Registro de usuarios</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo usuario</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <form action="{{route('users.store')}}" method="post" class="form-horizontal parsley-examples">
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="row">

                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <div>
                                <h4 class="header-title">Formulario de registro para nuevos usuarios</h4><br>


                                <div class="form-group">
                                    <label for="userName">Nombre del usuario<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="nombre"
                                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" maxlength="30" minlength="1"
                                        parsley-trigger="change" value="{{old('nombre')}}" placeholder="Ingresar el nombre" required
                                        class="form-control" id="nombre">
                                </div>

                                <div class="form-group">
                                    <label for="userName">Apellido paterno<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="apellido_p"
                                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" maxlength="30" minlength="1"
                                        parsley-trigger="change" value="{{old('apellido_p')}}" placeholder="Ingresar el apellido paterno" required
                                        class="form-control" id="apellido_p">
                                </div>

                                <div class="form-group">
                                    <label for="userName">Apellido materno<span
                                            class="text-danger"></span></label>
                                    <input type="text" name="apellido_m"
                                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" maxlength="30" minlength="1"
                                        parsley-trigger="change" value="{{old('apellido_m')}}" placeholder="Ingresar el apellido materno" 
                                        class="form-control" id="apellido_m">
                                </div>
                            
                                <div class="form-group mb-3">
                                <label for="userName">Sexo<span class="text-danger">*</span></label>
                                <select class="form-control" style="width: 100%" name="sexo"
                                    data-placeholder="Seleccione una opción ..." id="sexo" required
                                    data-toggle="select2">
                                    <option value="" selected>Seleccione una opción</option>                                                                                   
                                    <option value="MASCULINO">MASCULINO</option>
                                    <option value="FEMENINO">FEMENINO</option>                                           
                                </select>

                            </div>

                                <div class="form-group">
                                    <label for="emailAddress">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" parsley-trigger="change" required
                                        placeholder="Ingresar el email" class="form-control" id="email">
                                    <div class="text-danger" value="{{old('email')}}" id='error_email' name="error_email"></div>
                                </div>

                               



                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
                                        Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">
                                        Cancelar
                                    </button>
                                </div>


                            </div>

                        </div>

                        <div class="col-lg-6">
                            <div>
                                <h4 class="header-title">&nbsp;</h4><br>


                                <div class="form-group">
                                    <label for="userName">Tipo de usuario<span class="text-danger">*</span></label>
                                    <select class="form-control" style="width: 100%" name="tipo_usuario"
                                        data-placeholder="Seleccione una opción ..." id="tipo_usuario" required
                                        data-toggle="select2">
                                        @foreach($tiposUsuario as $tiposUsuario)
                                        <option value="{{$tiposUsuario}}" selected>{{$tiposUsuario}} </option>
                                        @endforeach
                                        <option value="" selected>Selecciona una opción... </option>
                                    </select>

                                </div>

                              
                                <div class="form-group mb-3">
                                        <label for="userName">Función<span class="text-danger">*</span></label>
                                        <select class="form-control" style="width: 100%" name="funcion"
                                            data-placeholder="Seleccione una opción ..." id="funcion" required
                                            data-toggle="select2">
                                            <option value="" selected>Seleccione una opción</option>                                                                                   
                                            <option value="OFICIALIA PARTES">Oficialía de partes </option>
                                            <option value="SECRETARIO AUXILIAR">Secretario Auxiliar</option> 
                                            <option value="PROYECTISTA">Proyectista</option> 
                                            <option value="SECRETARIO DE ESTUDIO Y CUENTA">Secretario de estudio y cuenta</option>
                                            <option value="ACTUARIO">Actuario</option> 
                                            <option value="COORDINADOR">Coordinador</option>
                                            <option value="MAGISTRADO">Magistrado</option>                                           
                                        </select>

                                    </div>


                                <div class="form-group">
                                    <label for="userName">Contraseña<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" value="{{old('password')}}" required="" name="password" id="password"
                                        placeholder="Ingresa una contraseña">
                                </div>

                                <div class="form-group">
                                    <label for="userName">Confirma tu contraseña<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="text" value="{{old('password')}}" required="" id="password_confirmation"
                                        name="password_confirmation" onKeyUp="valida_contra();"
                                        placeholder="Repite la contraseña">
                                    <div class="text-danger" id='error_pass' name="error_pass"></div>
                                </div>

                                <div class="form-group">
                                <label for="userName">Si desea puede generar una contraseña automática, de click en el botón.</label>
                                    <a href="javascript:generatePasswordRand(8,'alf');" class="btn waves-effect waves-light btn-primary" role="button"><i
                                            class="fas fa-key"></i>Generar contraseña</a>
                                </div>


                            </div>

                        </div>

                    </div>


                </div>

            </div>


        </div> <!-- end row -->
    </form>








</div> <!-- end container-fluid -->
<script>
function generatePasswordRand(length,type) {
    switch(type){
        case 'num':
            characters = "0123456789";
            break;
        case 'alf':
            characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
            break;
        case 'rand':
            //FOR ↓
            break;
        default:
            characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            break;
    }
    var pass = "";
    for (i=0; i < length; i++){
        if(type == 'rand'){
            pass += String.fromCharCode((Math.floor((Math.random() * 100)) % 94) + 33);
        }else{
            pass += characters.charAt(Math.floor(Math.random()*characters.length));   
        }
    }
    document.getElementById('password').value=pass;
    document.getElementById('password_confirmation').value=pass;
    //return pass;
}
</script>
@stop