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
                        <li class="breadcrumb-item active">Listado de movimientos en el sistema</li>
                    </ol>
                </div>
                <h4 class="page-title">Registro de movimientos de usuarios en el sistema</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->



    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="header-title">Descarga</h4>


                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Nombre del usuario</th>
                            <th>Tipo de movimiento</th>
                            <th>Observación</th>
                            <th>Fecha del movimiento</th>
                            <th>Ver registros alterados</th>
                            <th>Historial completo del usuario</th>
                            <th>Sexo</th>
                            <th>Email</th>
                            <th>Función</th>

                            <th>Estado del usuario</th>
                            <th>Registrado en el sistema desde</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($historial as $user)
                        <tr>
                            <td>{{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}</td>
                            <td>{{$user->tipo_movimiento}}</td>
                            <td>{{$user->observaciones}}</td>
                            <td>{{$user->created_at}}</td>
                            <td> <a class="btn waves-effect waves-light btn-info" role="button"
                                    data-target="#modal-delete-{{$user->id}}" data-toggle="modal"><i
                                        class="mdi mdi-eye"></i></a> </td>
                            <td> <a href="{{URL::action('userController@historial_usuario',$user->id_user)}}"
                                    class="btn waves-effect waves-light btn-info" role="button"><i
                                        class="mdi mdi-eye"></i></a> </td>
                            <td>{{$user->sexo}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->funcion}}</td>
                            <td>{{$user->estado_user}}</td>
                            <td>{{$user->fecha_registro}}</td>


                        </tr>

                        @include('users.modal_historial')
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- end container-fluid -->
@stop