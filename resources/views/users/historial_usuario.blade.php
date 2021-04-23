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
                        <li class="breadcrumb-item active">Historial del expediente</li>
                    </ol>
                </div>
                <h4 class="page-title">Historial del usuario</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">{{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}</h4>
                    
                    <div class="row">
                        @if($sala)
                        <div class="col-xl-3 col-md-6">
                            <div class="card-box widget-user position-relative">
                                <img src="../img/martillo.png" class="avatar-md rounded-circle" alt="user">
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">{{$sala->funcion}}
                                        </h5>
                                    <p class="text-muted mb-0 font-13">Desde: {{$expediente_sala->created_at}}</p>
                                    <div class="user-position">
                                        <span class="text-warning font-weight-bold">Función en la sala</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                                    <i class="ion ion-md-paper font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-success text-uppercase">Número de Sala </h6>
                                    <h3>{{$sala->num_sala}}</h3>
                                </div>
                            </div>
                        </div>
                        @else
                             <div class="card-box widget-user position-relative">
                                <img src="../img/martillo.png" class="avatar-md rounded-circle" alt="user">
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">
                                        Este usuario no se encuentra asignado a ninguna sala</h5>
                                    <p class="text-muted mb-0 font-13"></p>
                                </div>
                            </div>
                      
                        
                        @endif


                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card-box">
                                <h4 class="header-title">Información del usuario</h4>

                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">

                                        <tr class="bg-light text-dark">
                                            <th scope="row">Nombre completo : </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="num_expediente[]" id="num_expediente"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Tipo:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="tipo_aux[]" id="tipo_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Tipo de juicio:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="tipo_juicio[]" id="tipo_juicio"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                        
                                      

                                        <tr class="bg-light text-dark">
                                            <th>Fecha: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="fecha_aux[]" id="fecha_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--Fin de la columna de datos 1 -->

                        <div class="col-lg-5">
                            <div class="card-box">
                                <h4 class="header-title">Datos</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">


                                        <tr class="bg-white text-dark">
                                            <th>Ultima actualización:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="ultima_ac[]" id="ultima_ac"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-light text-dark">
                                            <th scope="row">Fecha de captura : </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="fecha_captura[]" id="fecha_captura"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                        </tr>
                                        <tr class="bg-white text-dark">
                                            <th>Modificado por: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="modificado[]" id="modificado"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Observaciónes: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="observaciones_aux[]" id="observaciones_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>








                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--Fin de la columna de datos 2 -->
                       

                    </div>
                    <!--Fin del row -->



                  





                </div>
            </div>
        </div>
        <!-- end row -->
    </form>

</div> <!-- end container-fluid -->

@stop