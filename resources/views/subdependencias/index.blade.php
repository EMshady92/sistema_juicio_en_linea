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
                        <li class="breadcrumb-item"><a href="/personas">Sub Dependencias</a></li>
                        <li class="breadcrumb-item active">Listado de Sub Dependencias</li>
                    </ol>
                </div>
                <h4 class="page-title">Catálogo de Sub Dependencias</h4>
                <a href="/subdependencias/create" class="button-list">
                    <button type="button" class="btn btn-success waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                        </span>Registrar</button>
                </a>
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
                            
                            <th>Nombre</th>
                            <th>Autoridad</th>
                            <th>Email</th>
                            <th>Teléfono</th> 
                            <th>Editar</th>
                            <th>Borrar</th>
                            <th>Estado</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>                          
                            <th>Modificado por</th>
                           
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($subdependencias as $subdependencia)
                        <tr>
                               
                            <td>{{$subdependencia->nombre}}</td>
                            <td>{{$subdependencia->nombre_dependencia}}</td>                                                                                                                      
                            <td>{{$subdependencia->email}}</td>
                            <td>{{$subdependencia->telefono}}</td>
                            <td> <a href="{{URL::action('SubDependenciasController@edit',$subdependencia->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i class="mdi mdi-account-edit-outline"></i></a>
                            </td>     
                            @if($subdependencia->estado == "ACTIVO")
                            <td>   <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning" onclick=inactivar('{{$subdependencia->id}}','subdependencias');
                                     style="margin-right: 10px;" role="button"><i
                                        class="mdi mdi-delete"></i></a>
                            </td>  
                            <td><span class="badge badge-success">{{$subdependencia->estado}}</span></td> 
                                                
                            @else
                            <td>No aplica</td>
                            <td><span class="badge badge-danger">{{$subdependencia->estado}}</span></td>
                            @endif      
                                                            
                            <td>{{$subdependencia->created_at}}</td>
                            <td>{{$subdependencia->updated_at}}</td>                           
                            <td>{{$subdependencia->captura}}</td>
                           
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