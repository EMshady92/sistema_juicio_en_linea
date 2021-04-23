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
                        <li class="breadcrumb-item"><a href="/asignaciones">Listado general de expedientes</a></li>
                        <li class="breadcrumb-item active">Asignaciones de expedientes</li>
                    </ol>
                </div>
                <h4 class="page-title">Listado general de asignaciones</h4>
                @if($num > 0)
                <div class="col-xl-3 col-md-6">
                    <div class="card-box tilebox-two">
                        <a href="misAsignaciones"
                            class="btn btn-sm btn-primary waves-effect waves-light float-right">Ver</a>
                        <h6 class="text-muted text-uppercase mt-0">Mis asignaciones</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$num}}</h3>
                        <div class="progress progress-md">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                @endif
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
                            <th>Re asignar</th>  
                            <th>Ver expediente</th>                         
                            <th>Fecha</th>                            
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>
                            <th>Modificado por</th>

                        </tr>
                    </thead>


                    <tbody>
                        @foreach($expedientes as $expediente)
                        @include('magistradoExpedientes.modaleditasig')
                        <tr>
                            <td>{{$expediente->tipo}}</td>
                            <td>{{$expediente->num_expediente}}</td>
                            <td>{{$expediente->num_sala}}</td>
                            <td>{{$expediente->name_asig}} {{$expediente->apellido_pasig}} {{$expediente->apellido_masig}}</td>                                                       
                            @if($funcion->funcion == "MAGISTRADO" || $funcion->funcion == "COORDINADOR" || $funcion->funcion == "ADMINISTRADOR")
                                    <td> 
                                        <a class="btn waves-effect waves-light btn-primary" data-toggle="modal"
                                            data-target="#modal{{$expediente->id_expediente_sala}}" data-dismiss="modal"><i
                                                class="mdi mdi-account-edit-outline"></i></a>
                                    </td>
                                    @else
                                    <td><span class="badge badge-danger">No disponible</span></td>
                               
                             @endif
                            
                            <td>
                                <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-info" role="button"><i
                                        class="mdi mdi-eye"></i></a>
                            </td>
                            <td><strong>{{$expediente->fecha}}<strong></td>

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
                        @endforeach
                      
                    
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
    <!-- end row -->

</div> <!-- end container-fluid -->
@stop