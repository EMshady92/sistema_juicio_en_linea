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
                        <li class="breadcrumb-item"><a href="/firmaElectronica">Firma electrónica</a></li>
                        <li class="breadcrumb-item active">Listado de firmas electrónica</li>
                    </ol>
                </div>
                <h4 class="page-title">Catálogo de firmas electronicas internas</h4>
                <a href="/firmaElectronica/create" class="button-list">
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
                            <th>Nombre del usuario</th>      
                            <th>Email</th>
                            <th>Función o puesto</th>
                            <th>Tipo de usuario</th>                                                                                                            
                            <th>Serial</th>
                            <th>Renovar</th>
                            <th>Revocar</th>  
                            <th>Estado usuario</th>                                   
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th> 
                            <th>Generada por</th>                                                                                   
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($firmas as $firma)
                        <tr>                                                
                            <td>{{$firma->name}}</td> 
                            <td>{{$firma->email}}</td> 
                            <td>{{$firma->funcion}}</td> 
                            <td>{{$firma->tipo_usuario}}</td> 
                            <td>{{$firma->serial}}</td>       
                            <td> <a href="{{URL::action('firmaElectronicaController@edit',$firma->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i class="mdi mdi-account-edit-outline"></i></a>
                            </td> 

                            <td>   <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning" onclick=inactivar('{{$firma->id}}','firmaElectronica');
                                     style="margin-right: 10px;" role="button"><i
                                        class="mdi mdi-delete"></i></a>
                            </td>  

                            @if($firma->estado == "ACTIVO")                            
                            <td ><span class="badge badge-success">{{$firma->estado}}</span></td>   
                                                
                            @else                           
                            <td ><span class="badge badge-danger">{{$firma->estado}}</span></td>  
                            @endif                                                                                                                                             
                            <td>{{$firma->created_at}}</td>
                            <td>{{$firma->updated_at}}</td>
                            <td>{{$firma->captura}}</td>
                            
                           
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