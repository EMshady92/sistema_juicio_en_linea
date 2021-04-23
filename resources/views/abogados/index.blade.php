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
                        <li class="breadcrumb-item"><a href="/abogados">Abogados</a></li>
                        <li class="breadcrumb-item active">Listado de abogados</li>
                    </ol>
                </div>
                <h4 class="page-title">Catálogo de abogados</h4>
                <a href="/abogados/create" class="button-list">
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
                            <th>Apellido paterno</th>
                            <th>Apellido materno</th> 
                            <th>Número Cédula</th>
                            <th>Cédula</th>                                                        
                            <th>Sexo</th>
                            <th>Ver</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                            <th>Estado</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>  
                            <th>Mofificado por</th>                                                                                   
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($abogados as $abogado)
                        <tr>                                                
                            <td>{{$abogado->nombre}}</td>
                            <td>{{$abogado->apellido_paterno}}</td>
                            <td>{{$abogado->apellido_materno}}</td>
                            <td>{{$abogado->num_cedula}}</td>
                            
                                        
                            <td id="cedula">
                                <a href='../OFICIALIA/archivos/cedulas/{{$abogado->cedula}}'
                                     target="_blank" class="btn waves-effect waves-light btn-info btn-sm"
                                     role="button">
                                     <i class="fas fa-file-pdf"></i></a>
                             </td>
                            

                            <td>{{$abogado->sexo}}</td>
                            <td >
                            <a href="{{URL::action('AbogadoController@show',$abogado->id)}}" class="btn waves-effect waves-light btn-info" role="button"><i class="mdi mdi-eye"></i></a>    </td>
                            <td> <a href="{{URL::action('AbogadoController@edit',$abogado->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i class="mdi mdi-account-edit-outline"></i></a>
                            </td>     
                            @if($abogado->estado == "ACTIVO")
                            <td>   <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning" onclick=inactivar('{{$abogado->id}}','abogados');
                                     style="margin-right: 10px;" role="button"><i
                                        class="mdi mdi-delete"></i></a>
                            </td>  
                            <td><span class="badge badge-success">{{$abogado->estado}}</span></td>
                                                
                            @else
                            <td>No aplica</td>
                            <td><span class="badge badge-danger">{{$abogado->estado}}</span></td>
                            @endif                                                              
                            <td>{{$abogado->created_at}}</td>
                            <td>{{$abogado->updated_at}}</td>
                            <td>{{$abogado->captura}}</td>
                            
                           
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