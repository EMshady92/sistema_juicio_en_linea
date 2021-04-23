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
                        <li class="breadcrumb-item"><a href="/expedientes">Salas/Magistrados</a></li>
                        <li class="breadcrumb-item active">Detalles de la sala</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles de la sala seleccionada</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}
        @if($personal_sala)
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">Número de sala: {{$personal_sala[0]->num_sala}}</h4>
                    <div class="row">
                        @foreach($personal_sala as $personal)
                        @if($personal->funcion == "MAGISTRADO")
                        <div class="col-xl-3 col-md-6">
                            <div class="card-box widget-user position-relative">
                                <img src="../img/martillo.png" class="avatar-md rounded-circle" alt="user">
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">{{$personal->name}}
                                        {{$personal->apellido_p}} {{$personal->apellido_m}}</h5>
                                    <p class="text-muted mb-0 font-13">{{$personal->email}}</p>
                                    <div class="user-position">
                                        <span class="text-warning font-weight-bold">Magistrado</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach

                        <div class="col-xl-3 col-md-6">
                            <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                                    <i class="ion ion-md-paper font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-success text-uppercase">Número de Sala </h6>
                                    <h3>{{$personal_sala[0]->num_sala}}</h3>
                                </div>
                            </div>
                        </div>



                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="header-title">Información de la sala</h4>

                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Funcion</th>
                                                <th>Nombre</th>
                                                <th>Apellido paterno</th>
                                                <th>Apellido materno</th>
                                                <th>Email</th>
                                                <th>Estado</th>
                                                <th>Ver historial</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($personal_sala as $personal)
                                            <tr>
                                                <td>{{$personal->funcion}}</td>
                                                <td>{{$personal->name}}</td>
                                                <td>{{$personal->apellido_p}}</td>
                                                <td>{{$personal->apellido_m}}</td>
                                                <td>{{$personal->email}}</td>
                                                <td>{{$personal->estado}}</td>
                                                <td><a href='/verHistorialUsuario/{{$personal->id_user}}'
                                                        class="btn waves-effect waves-light btn-info btn-sm"
                                                        role="button">
                                                        <i class="mdi mdi-eye"></i></a></td>
                                            </tr>
                                            <tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>



                            </div>

                        </div>

                    </div>
                    <!--FIN ROW PROMOCIONES Y AMPAROS-->




                </div>
            </div>
        </div>
        <!-- end row -->
        @else
        <div class="alert alert-warning" role="alert">
                                    <strong>Lo sentimos!</strong> No hay personal registrado en esta
                                    sala.
         </div>
        @endif
    </form>

</div> <!-- end container-fluid -->

@stop