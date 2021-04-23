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
                        <li class="breadcrumb-item"><a href="/email_users">Correos Usuarios</a></li>
                        <li class="breadcrumb-item active">Registro de Correos</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo Correo</h4>
                @include('email_users.modal_personas')
            </div>
        </div>
    </div>
    <!-- end page title -->



    <div class="row">
        <div class="col-12">
            <div class="card-box">

                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <h4 class="header-title">Formulario de registro</h4>
                            <p class="sub-header">
                                Formulario para registrar nuevos Correos.
                            </p>




                            <form action="{{route('email_users.index')}}"  id="formulario_personas" class="form-horizontal parsley-examples">
                           

                                <a class="button-list" data-toggle="modal"
                                data-target="#modal" data-dismiss="modal">
                                    <button type="button" class="btn btn-success waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                                        </span>Registrar correos</button>
                                </a>
            
                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-lg-7">

                                        <label for="userName" class="col-sm-3 control-label">Email<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2-multiple" name="emails[]"
                                            id="emails" data-toggle="select2" multiple="multiple" disabled="true"
                                             style="width: 100%"
                                            required>
                                            @foreach($emails as $email)
                                            <option value="{{$email->email}}">{{$email->email}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                            </div>

                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1"  id="submit"  type="submit">
                                        Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">
                                        Cancelar
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>   
             </div>

        </div>
    </div> <!-- end row -->   

    
                





</div> <!-- end container-fluid -->
            @stop
@section('javascript')
<script type="text/javascript">
//Valida emails users
function valida_email_users(sr) {
    var dataString = $('#formulario').serialize(); // carga todos 
    $.ajax({
        type: "get",
        method: 'get',
        url: "/valida_email_users",
        data: dataString,
        success: function (data) {
            if (data.user) {
                if (sr != data.user.email) {

                    document.getElementById("error_email").innerHTML =
                        "El email que ingreso ya se encuentra registrado en el sistema SIJEL.";
                    document.getElementById("error_email_users").value = "1";
                    document.getElementById('submit').disabled = true;

                } else {
                    document.getElementById("error_email_users").innerHTML = "";
                    document.getElementById("error_email_users").value = "0";
                    document.getElementById('submit').disabled = false;
                }

            } else {
                document.getElementById("error_email_users").innerHTML = "";
                document.getElementById("error_email_users").value = "0";
                document.getElementById('submit').disabled = false;
            }


        }
    });

}

//MODAL PARA GUARDAR LOS DATOS DE UN ABOGADO NUEVO EN LA VISTA DE NUEVOS INGRESOS
function modal_personas() {
    var dataString = $('#formulario_personas').serialize(); // carga todos 
    $.ajax({
        type: "POST",
        method: 'post',
        url: "/emailsCrear",
        data: dataString,
        success: function (data) {

            var x = $('#emails');
            option = new Option(data.email, data.id, true, true);
            x.append(option).trigger('change');
            x.trigger({
                type: 'select2:select',
                params: {
                    data: data.email
                }
            });
            $("#modal_personas.close").click();
            $('.modal_personas.in').modal('hide');


        }
    });
}


</script>
@endsection