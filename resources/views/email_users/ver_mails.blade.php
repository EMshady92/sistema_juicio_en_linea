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
                        <li class="breadcrumb-item"><a href="/email_users">Ver Correos Usuarios</a></li>
                        <li class="breadcrumb-item active">Ver Registro de Correos</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo Correo</h4>
                {{-- @include('email_users.modal_personas') --}}
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
                           
                                <h2>Nombre: <b>{{$personas->nombre}}</b></h2><br>
                                <a href="/email_users/create" class="button-list">
                                    <button type="button" class="btn btn-success waves-effect waves-light">
                                        <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                                        </span>Registrar Correo </button>
                                </a>
            
                            
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card-box">                         
                                                <table id="responsive-datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                                    style="border-collapse: collapse; border-spacing: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th>Correos registrados</th>
                                                                                                                                       
                                                        </tr>
                                                    </thead>
                    
                    
                                                    <tbody>
                                                        @foreach($emails as $email)             
                                                                                     
                                                        <tr>
                                                            <td>{{$email->email}}</td>
                                                                                                                       
                    
                                                        </tr>
                                                       
                                                        @endforeach
                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end row -->
                    
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

window.onload = function() {
    id = '{{ $personas->id }}';

    traer_emails(id);
};

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
            $("#modal.close").click();
            $('.modal.in').modal('hide');


        }
    });
}

function traer_emails(value) {
var route = ruta_global + "/traer_emails/" + value;
        var token = $("#token").val();
        $.ajax({
            type: "get",
            headers: { 'X-CSRF-TOKEN': token },
            method: 'get',
            url: route,
            data: value,
            success: function (data) {
                 //FOR EACH PARA AGREGAR LOS ACTORES AL EXPEDIENTE SELECCIONADO
                 data.emails.forEach(function (email, index) {
                    var x = $('#emails');
                        option = new Option(email.email, true, true);
                    x.append(option).trigger('change');
                    x.trigger({
                        type: 'select2:select',
                        params: {
                            data: data.email
                        }
                    });
                });//END FOREACH ACTORES
            } 
        }); 
}


</script>
@endsection