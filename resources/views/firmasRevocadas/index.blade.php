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
                        <li class="breadcrumb-item active">Listado de documentos cancelados</li>
                    </ol>
                </div>
                <h4 class="page-title">Catálogo de documentos cancelados</h4>
                <a href="/revocarDocumentos/create" class="button-list">
                    <button type="button" class="btn btn-success waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                        </span>Cancelar nuevo documento</button>
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
                            <th>Tipo de documento</th>      
                            <th>Tipo de expediente</th>
                            <th>Tipo de juicio</th>
                            <th>Número de expediente</th>                                                                                                            
                            <th>Clave alfanumerica</th>
                            <th>Propietario del documento</th>
                            <th>Ver documento</th>  
                            <th>Fecha de cancelación</th>                                   
                            <th>Modificar</th>
                            <th>Cancelado por</th>
                                                                                                            
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($firmas_rev as $firma)
                        <tr>                                                
                            <td>{{$firma->tipo_documento}}</td> 
                            <td>{{$firma->tipo_expediente}}</td> 
                            <td>{{$firma->tipo_juicio}}</td> 
                            <td>{{$firma->num_expediente}}</td> 
                            <td>{{$firma->clave_alfanumerica_doc}}</td>     
                            <td>{{$firma->name}} {{$firma->apellido_p}} {{$firma->apellido_m}}</td>       
                            <td> <a href="{{URL::action('documentosRevocadosController@show',$firma->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i class="mdi mdi-eye"></i></a>
                            </td> 

                                                                                                                                                       
                            <td>{{$firma->fecha_rev}}</td>
                            <td>{{$firma->updated_at}}</td>
                            <td>{{$firma->captura_rev}}</td>
                            
                           
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