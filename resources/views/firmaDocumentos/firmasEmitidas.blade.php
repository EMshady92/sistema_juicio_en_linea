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
                <h4 class="page-title">Firmas electronicas emitidas</h4>               
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
                            <th>Número de firma</th>      
                            <th>Fecha de firma</th>
                            <th>Estado</th>
                            <th>Modificada por</th>                                                                                                            
                            <th>PDF</th>
                            <th>XML</th>
                            <th>Ver firma</th>  
                            <th>Clave alfanumérica </th>                                                                                                                                  
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($firmas as $firma)
                        <tr>                                                
                            <td>{{$firma->num_firma}}</td> 
                            <td>{{$firma->created_at}}</td> 
                            @if($firma->estado == "ACTIVO")                            
                            <td ><span class="badge badge-success">{{$firma->estado}}</span></td>   
                                                
                            @else                           
                            <td ><span class="badge badge-danger">{{$firma->estado}}</span></td>  
                            @endif         
                            <td>{{$firma->captura}}</td>                             
                            <td>
                            <a  href='../FIRMASEMITIDAS/PDF/{{$firma->pdf}}'
                                class="btn waves-effect waves-light btn-danger" target="_blank" role="button"><i
                                    class="mdi mdi-file-pdf-outline"></i></a>
                        </td>               
                        <td>
                            <a  href='../FIRMASEMITIDAS/XML/{{$firma->xml}}'
                                class="btn waves-effect waves-light btn-danger" target="_blank" role="button"><i
                                    class="mdi mdi-xml"></i></a>
                        </td>               
                        <td>
                            <a href="{{URL::action('firmaElectronicaController@show',$firma->id)}}"
                                class="btn waves-effect waves-light btn-info" role="button"><i
                                    class="mdi mdi-eye"></i></a>
                        </td>               
                        <td>{{$firma->clave_alfanumerica}}</td>      
              
                           
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