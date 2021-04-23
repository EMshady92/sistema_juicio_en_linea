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
                        <li class="breadcrumb-item"><a href="/expedientes">Listado general de expedientes</a></li>
                        <li class="breadcrumb-item active">Mis expedientes</li>
                    </ol>
                </div>
                @if($verifica_sala == 1)
                <h4 class="page-title">Expedientes de la Sala: {{$sala->num_sala}}</h4>
                @else
                <h4 class="page-title">Expedientes de la Sala:</h4>
                @endif
            </div>           
        </div>
        @include('magistradoExpedientes.modal_validar')
        @include('magistradoExpedientes.modalAsignar')
        @include('magistradoExpedientes.modalAcuerdo')
        @if($verifica_sala == 1)
        <div class="col-xl-3 col-md-6">
                <div class="card-box tilebox-two">
                    <i class="icon-chart float-right text-muted"></i>
                    @if($expedientes_pedientes > 0 )
                    <a href="#" class="btn btn-sm btn-primary waves-effect waves-light float-right" data-toggle="modal"
                                    data-target="#modalAsignar" data-dismiss="modal">Ver</a>
                     @endif               
                    <h6 class="text-success text-uppercase">Expedientes pendientes por asignar</h6>
                    <h3><span data-plugin="counterup">{{$expedientes_pedientes}}</span></h3>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card-box tilebox-two">
                    <i class="icon-layers float-right text-muted"></i>
                    @if($expedientes_validar > 0 )
                    <a href="#" class="btn btn-sm btn-primary waves-effect waves-light float-right" data-toggle="modal"
                                    data-target="#modalValidar" data-dismiss="modal">Ver</a>
                    @endif                
                    <h6 class="text-primary text-uppercase">Expedientes pendientes por validar</h6>
                    <h3><span data-plugin="counterup">{{$expedientes_validar}}</span></h3>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card-box tilebox-two">                
                    <i class="icon-chart float-right text-muted"></i>     
                    @if($acuerdos_generar > 0 )              
                    <a href="#" class="btn btn-sm btn-primary waves-effect waves-light float-right" data-toggle="modal"
                                    data-target="#modalAcuerdo" data-dismiss="modal">Ver</a>
                    @endif                  
                    <h6 class="text-pink text-uppercase">Acuerdos pendientes por generar</h6>
                    <h3><span data-plugin="counterup">{{$acuerdos_generar}}</span></h3>
                    
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card-box tilebox-two">
                    <i class="icon-layers float-right text-muted"></i>
                    @if($acuerdos_revisar > 0 )         
                    <a href="#" class="btn btn-sm btn-primary waves-effect waves-light float-right" data-toggle="modal"
                                    data-target="#modalValidar" data-dismiss="modal">Ver</a>
                    @endif                
                    <h6 class="text-blue text-uppercase">Acuerdos pendientes por revisar</h6>
                    <h3><span data-plugin="counterup">{{$acuerdos_revisar}}</span></h3>
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
                            <th>Magistrado</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            @if($funcion->funcion == "MAGISTRADO" || $funcion->funcion == "COORDINADOR")
                            <th>Editar</th>
                            @endif
                            <th>Ver expediente</th>
                            <th>Validar</th>
                            <th>Asignar</th>
                            <th>Borrar</th>
                          
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>
                            <th>Modificado por</th>

                        </tr>
                    </thead>


                    <tbody>                   
                        @foreach($expedientes as $expediente)
                        @include('magistradoExpedientes.modal')
                        <tr>
                            <td>{{$expediente->tipo}}</td>
                            <td>{{$expediente->num_expediente}}</td>
                            <td>{{$expediente->num_sala}}</td>
                            <td>{{$expediente->name}} {{$expediente->apellido_p}} {{$expediente->apellido_m}}</td> 
                            @if($expediente->estado == "ACTIVO")                           
                            <td><span class="badge badge-success">{{$expediente->estado}}</span></td>
                            @else                            
                            <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                            @endif
                            <td><strong>{{$expediente->fecha}}<strong></td>
                            @if($funcion->funcion == "MAGISTRADO" || $funcion->funcion == "COORDINADOR" || $funcion->funcion == "ADMINISTRADOR")
                            <td> <a href="{{URL::action('ExpedientesController@edit',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i
                                        class="mdi mdi-account-edit-outline"></i></a>
                            </td>
                            @endif
                            <td>
                                <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-info" role="button"><i
                                        class="mdi mdi-eye"></i></a>
                            </td>
                            @if($expediente->estado == "POR_VALIDAR")
                            <td>
                            <a data-target="#modal-{{$expediente->id}}" data-toggle="modal"
                                    class="btn waves-effect waves-light btn-success" role="button"><i
                                        class="ion ion-md-checkmark-circle"></i></a>
                            </td>
                            <td><span class="badge badge-danger">No aplica</span></td>

                            @elseif($expediente->estado == "POR_ASIGNAR")
                            <td><span class="badge badge-danger">No aplica</span></td>
                            @if($funcion->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || $funcion->funcion == "MAGISTRADO" || $funcion->funcion == "COORDINADOR" || $funcion->funcion == "ADMINISTRADOR")
                                    <td> 
                                        <a class="btn waves-effect waves-light btn-primary" data-toggle="modal"
                                            data-target="#modal{{$expediente->id_expediente_sala}}" data-dismiss="modal"><i
                                                class="mdi mdi-account-edit-outline"></i></a>
                                    </td>
                                    @else
                                    <td><span class="badge badge-danger">No disponible</span></td>
                               
                                @endif
                            @else
                            <td><span class="badge badge-danger">No aplica</span></td>
                            <td><span class="badge badge-danger">No aplica</span></td>

                            @endif
                           

                            @if($expediente->estado == "ACTIVO")       
                            <td> 
                                <a class="btn waves-effect waves-light btn-warning"
                                    onclick=inactivar('{{$expediente->id}}','expedientes'); style="margin-right: 10px;"
                                    role="button"><i class="mdi mdi-delete"></i></a>
                            </td>
                            @else
                            <td><span class="badge badge-danger">No aplica</span></td>                           
                            @endif
                          
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
    @else
                    <div class="alert alert-danger" role="alert">
                                            <strong>Aún no has sido asignado a ninguna sala, contactarse con un administrador!</strong>.
                                        </div>
    @endif
    <!-- end row -->

</div> <!-- end container-fluid -->
@stop