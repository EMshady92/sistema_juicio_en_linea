@extends('layouts.principal')
@section('contenido')


<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/asignaciones">Listado general de expedientes</a></li>
                        <li class="breadcrumb-item active">Asignaciónes de expedientes</li>
                    </ol>
                </div>
                <h4 class="page-title">Listado general de asignaciónes</h4>
                @include('magistradoExpedientes.modalPendientes')
                @include('magistradoExpedientes.modalCorreciones')
                @include('magistradoExpedientes.modalCorrectos')
             

            </div>
        </div> 

        <div class="col-xl-3 col-md-6">
                <div class="card-box tilebox-two">
                    <i class=" ion ion-md-grid float-right text-muted"></i>                                
                    <h6 class="text-success text-uppercase">Mis asignaciónes de expedientes</h6>
                    <h3><span data-plugin="counterup">{{$num}}</span></h3>
                </div>
            </div>

        <?php $aux=count($acuerdos_pendientes); ?>
        <div class="col-xl-3 col-md-6">
            <div class="card-box tilebox-two">
                <i class="icon-layers float-right text-muted"></i>
                @if($aux > 0 )
                <a href="#" class="btn btn-sm btn-primary waves-effect waves-light float-right" data-toggle="modal"
                    data-target="#modalPendientes" data-dismiss="modal">Ver</a>
                @endif
                <h6 class="text-primary text-uppercase">Acuerdos pendientes por generar</h6>
                <h3><span data-plugin="counterup">{{$aux}}</span></h3>
            </div>
        </div>

        <?php $aux=count($acuerdos_correciones); ?>

        <div class="col-xl-3 col-md-6">
            <div class="card-box tilebox-two">
                <i class=" ion ion-md-alert float-right text-muted"></i>
                @if($aux > 0 )
                <a href="#" class="btn btn-sm btn-primary waves-effect waves-light float-right" data-toggle="modal"
                    data-target="#modalCorreciones" data-dismiss="modal">Ver</a>
                @endif
                <h6 class="text-success text-uppercase">Acuerdos generados con correciónes</h6>
                <h3><span data-plugin="counterup">{{$aux}}</span></h3>
            </div>
        </div>

        <?php $aux=count($acuerdos_correctos); ?>
        <div class="col-xl-3 col-md-6">
            <div class="card-box tilebox-two">
                <i class="mdi mdi-bookmark-check float-right text-muted"></i>
                @if($aux > 0 )
                <a href="#" class="btn btn-sm btn-primary waves-effect waves-light float-right" data-toggle="modal"
                    data-target="#modalCorrectos" data-dismiss="modal">Ver</a>
                @endif
                <h6 class="text-primary text-uppercase">Acuerdos generados correctamente</h6>
                <h3><span data-plugin="counterup">{{$aux}}</span></h3>
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
                            <th>Tipo de expediente</th>
                            <th>Número de expediente</th>
                            <th>Sala</th>
                            <th>Asignado</th>
                            <th>Validar</th>
                            <th>Generar acuerdo</th>
                            <th>Editar</th>
                            <th>Fecha</th>
                            <th>Ver expediente</th>
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>
                            <th>Modificado por</th>

                        </tr>
                    </thead>


                    <tbody>
                        @foreach($expedientes as $expediente)
                        <tr>
                            <td>{{$expediente->tipo}}</td>
                            <td>{{$expediente->num_expediente}}</td>
                            <td>{{$expediente->num_sala}}</td>
                            <td>{{$expediente->name_asig}} {{$expediente->apellido_pasig}}
                                {{$expediente->apellido_masig}}</td>

                            @if($expediente->estado == "POR_VALIDAR")
                            <td>
                                <a data-target="#modal-{{$expediente->id}}" data-toggle="modal"
                                    class="btn waves-effect waves-light btn-success" role="button"><i
                                        class="ion ion-md-checkmark-circle"></i></a>
                            </td>
                            <td><span class="badge badge-danger">Falta validar expediente</span></td>

                            @else
                            <td><span class="badge badge-danger">Validado</span></td>
                            <td>
                                <a href="{{URL::action('acuerdosController@create',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-secondary" role="button"><i
                                        class="mdi mdi-account-edit-outline"></i></a>
                            </td>

                            @endif
                            @if($expediente->estado == "POR_VALIDAR")
                            <td> <a href="{{URL::action('ExpedientesController@edit',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i
                                        class="mdi mdi-account-edit-outline"></i></a>
                            </td>
                            @else
                            <td><strong>No disponible<strong></td>
                            @endif
                            <td><strong>{{$expediente->fecha}}<strong></td>

                            <td>
                                <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-info" role="button"><i
                                        class="mdi mdi-eye"></i></a>
                            </td>

                            @if($expediente->estado == "ACTIVO")
                            <td><span class="badge badge-success">{{$expediente->estado}}</span></td>
                            @else
                            <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                            @endif
                            <td><span class="badge badge-info">{{$expediente->ubicacion}}</span></td>
                            <td>{{$expediente->created_at}}</td>
                            <td>{{$expediente->updated_at}}</td>
                            <td>{{$expediente->captura}}</td>

                        </tr>
                        @include('magistradoExpedientes.modalasigns')
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- end container-fluid -->
@stop