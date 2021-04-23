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
                        <li class="breadcrumb-item"><a href="/expedientes">Expedientes</a></li>
                        <li class="breadcrumb-item active">Listado de expedientes</li>
                    </ol>
                        
                    <a style='margin-left:200px;' data-toggle="tooltip" title="Video tutorial Oficialía de Partes">
                    <button type="button" onclick='iniciamodal();' class="btn btn-info waves-effect waves-light">
                        <span><i class="mdi mdi-help-circle"></i>
                        </span></button>
                    </a>

                  
                </div>
                <h4 class="page-title">Listado de expedientes</h4>
                <a href="/expedientes/create" class="button-list">
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
                            <th>Tipo de expediente</th>
                            <th>Número de expediente</th>
                            <th>Tipo de Juicio</th>
                            <th>Fecha</th>                        
                            <th>Ver datos completos</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                            <th>Estado</th>
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
                            <td>{{$expediente->tipos}}</td>                             
                            <td><strong>{{$expediente->fecha}}<strong></td>                                               
                            
                          
                            <td>
                               
                                <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-info"  target="_blank" role="button"><i
                                        class="mdi mdi-eye"></i></a> 
                            </td>
                            
                            @if($funcion->funcion == "OFICIALIA PARTES" || $funcion->funcion == "ADMINISTRADOR")
                                @if($expediente->estado != "VALIDADO" || $expediente->estado != "ACUERDO_GENERADO")
                                        <td> <a href="{{URL::action('ExpedientesController@edit',$expediente->id)}}"
                                                class="btn waves-effect waves-light btn-primary" role="button"><i
                                                    class="mdi mdi-account-edit-outline"></i></a>
                                        </td>
                                    @else
                                        <td>No disponible</td>
                                @endif
                            @endif


                            @if($expediente->estado == "ACTIVO")
                            <td> <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                                <a class="btn waves-effect waves-light btn-warning"
                                onclick=inactivar('{{$expediente->id}}','expedientes'); style="margin-right: 10px;"
                                    role="button"><i class="mdi mdi-delete"></i></a>
                            </td>
                            <td><span class="badge badge-success">{{$expediente->estado}}</span></td>

                            @else
                            <td>No aplica</td>
                            <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                            @endif

                            <td>{{$expediente->created_at}}</td>
                            <td>{{$expediente->updated_at}}</td>                            
                            <td>{{$expediente->captura}}</td>

                        </tr>
                        @endforeach
                        @include('expedientes.modal_video')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- end container-fluid -->
<script type="text/javascript">
		window.onload=function() {
			//iniciamodal();
           

		}

	

	
		</script>
@stop