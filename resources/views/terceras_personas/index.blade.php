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
                        <li class="breadcrumb-item"><a href="/terceras_personas">Terceros interesados</a></li>
                        <li class="breadcrumb-item active">Listado de terceros interesados</li>
                    </ol>
                </div>
                <h4 class="page-title">Catálogo de terceros interesados</h4>
                <a href="/terceras_personas/create" class="button-list">
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
                            <th>Apellido paterno</th>
                            <th>Apellido materno</th>
                            <th>Sexo</th>
                            <th>Razón social</th>
                            
                            <th>Ver</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                            <th>Estado</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>
                            <th>Correo</th>
                            <th>Modificado por</th>
                           
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($terceras_personas as $tercera_persona)
                        <tr>
                            <td>{{$tercera_persona->tipo_persona}}</td>
                            @if($tercera_persona->tipo_persona == "FISICA")                            
                            <td>{{$tercera_persona->nombre}}</td>
                            <td>{{$tercera_persona->apellido_paterno}}</td>
                            <td>{{$tercera_persona->apellido_materno}}</td>
                            <td>{{$tercera_persona->sexo}}</td>
                            <td><strong>No aplica<strong></td>                                                                                   
                            @else                            
                            <td><strong>No aplica<strong></td>
                            <td><strong>"<strong></td>
                            <td><strong>" <strong></td>
                            <td>{{$tercera_persona->razon_social}}</td>                                                                                                                              
                            @endif
                            <td >
                            <a href="{{URL::action('TerceraPersonaController@show',$tercera_persona->id)}}" class="btn waves-effect waves-light btn-info" role="button"><i class="mdi mdi-eye"></i></a>    </td>
                            <td> <a href="{{URL::action('TerceraPersonaController@edit',$tercera_persona->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i class="mdi mdi-account-edit-outline"></i></a>
                            </td>     
                            @if($tercera_persona->estado == "ACTIVO")
                            <td>   <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning" onclick=inactivar('{{$tercera_persona->id}}','terceras_personas');
                                     style="margin-right: 10px;" role="button"><i
                                        class="mdi mdi-delete"></i></a>
                            </td>  
                            <td><span class="badge badge-success">{{$tercera_persona->estado}}</span></td> 
                                                
                            @else
                            <td>No aplica</td>
                            <td><span class="badge badge-danger">{{$tercera_persona->estado}}</span></td>
                            @endif      
                                                            
                            <td>{{$tercera_persona->created_at}}</td>
                            <td>{{$tercera_persona->updated_at}}</td>
                            <td>{{$tercera_persona->email}}</td>
                            <td>{{$tercera_persona->captura}}</td>
                           
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