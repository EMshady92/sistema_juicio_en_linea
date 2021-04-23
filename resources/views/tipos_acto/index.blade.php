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
                        <li class="breadcrumb-item"><a href="/tipos_juicios">Tipos de Actos</a></li>
                        <li class="breadcrumb-item active">Listado de Tipos Actos</li>
                    </ol>
                </div>
                <h4 class="page-title">Catálogo de Actos</h4>
                <a href="/tipos_actos/create" class="button-list">
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
                            <th>Tipo de Acto</th>
                           
                            <th>Editar</th>
                            <th>Borrar</th>
                            <th>Estado</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>
                            <th>Modificado por</th>
                           
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($actos as $acto)
                        <tr>
                            <td>{{$acto->tipo_acto}}</td>
                            
                           
                            
                            <td> <a href="{{URL::action('TiposActosController@edit',$acto->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i class="mdi mdi-account-edit-outline"></i></a>
                            </td>     
                            @if($acto->estado == "ACTIVO")
                            <td>   <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning" onclick=inactivar('{{$acto->id}}','tipos_actos');
                                     style="margin-right: 10px;" role="button"><i
                                        class="mdi mdi-delete"></i></a>
                            </td>  
                            <td><span class="badge badge-success">{{$acto->estado}}</span></td> 
                                                
                            @else
                            <td>No aplica</td>
                            <td><span class="badge badge-danger">{{$acto->estado}}</span></td>
                            @endif      
                                                            
                            <td>{{$acto->created_at}}</td>
                            <td>{{$acto->updated_at}}</td>
                            <td>{{$acto->captura}}</td>
                           
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