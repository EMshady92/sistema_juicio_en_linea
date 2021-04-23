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
                        <li class="breadcrumb-item"><a href="/personas">Actores,Autoridades,Abogados...</a></li>
                        <li class="breadcrumb-item active">Listado de Actores,Autoridades,Abogados...s</li>
                    </ol>
                </div>
                <h4 class="page-title">Catálogo de Actores,Autoridades,Abogados...</h4>
               
                <a href="/personas/create" class="button-list">
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
                            <th>Tipo de persona</th>
                            <th>Nombre</th>
                            <th>Ver correos</th>                                             
                            <th>Ver</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                            <th>Estado</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>                          
                            <th>Modificado por</th>
                           
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($actores as $actor)
                        <tr>
                            <td>{{$actor->tipo}}</td>
                            @if($actor->tipo == "FISICA" || $actor->tipo == "AUTORIDAD")                            
                            <td>{{$actor->nombre}} {{$actor->apellido_paterno}} {{$actor->apellido_materno}}</td>                                                                                                                      
                            @else                                                      
                            <td>{{$actor->razon_social}}</td>                                                                                                                              
                            @endif
                            
                            <td>
                                <a href="{{URL::action('EmailUsersController@ver_emails',$actor->id)}}" class="btn waves-effect waves-light btn-info" role="button">
                                    <i class="mdi mdi-email"></i></a> 
                                  {{--   <a href="#" class="btn btn-sm btn-primary waves-effect waves-light" data-toggle="modal"
                                    data-target="#modalMail-{{$actor->id}}" data-dismiss="modal">Ver</a> --}}

                            </td>

                            <td>
                            <a href="{{URL::action('PersonasController@show',$actor->id)}}" class="btn waves-effect waves-light btn-info" role="button">
                                <i class="mdi mdi-eye"></i></a>    
                            </td>

                            <td> <a href="{{URL::action('PersonasController@edit',$actor->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i class="mdi mdi-account-edit-outline"></i></a>
                            </td>     
                            @if($actor->estado == "ACTIVO")
                            <td>   <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning" onclick=inactivar('{{$actor->id}}','personas');
                                     style="margin-right: 10px;" role="button"><i
                                        class="mdi mdi-delete"></i></a>
                            </td>  
                            <td><span class="badge badge-success">{{$actor->estado}}</span></td> 
                                                
                            @else
                            <td>No aplica</td>
                            <td><span class="badge badge-danger">{{$actor->estado}}</span></td>
                            @endif      
                                                            
                            <td>{{$actor->created_at}}</td>
                            <td>{{$actor->updated_at}}</td>                           
                            <td>{{$actor->captura}}</td>
                           
                        </tr>    
                        {{-- @include('personas.modalMail') --}}           
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- end container-fluid -->
@stop