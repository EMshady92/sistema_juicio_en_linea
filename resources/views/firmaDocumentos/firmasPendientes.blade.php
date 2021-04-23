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
                        <li class="breadcrumb-item"><a href="/misFirmas">Mis firmas electrónicas</a></li>
                        <li class="breadcrumb-item active">Listado de firmas electrónica pendientes</li>
                    </ol>
                </div>
                <h4 class="page-title">Mis firmas electronicas pendientes</h4>               
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
                            <th>Número de expediente</th>      
                            <th>Solicitante de la firma</th>
                            <th>Tipo de documento</th>
                            <th>Firmar</th>  
                            <th>Estado</th>  
                            <th>Fecha de captura</th>
                            <th>Ultima actualización</th>
                            <th>Modificado por</th>
                        </tr>
                    </thead>


                    <tbody>
                        @foreach($firmas_int as $firmas_int)
                        <tr>                                                
                            <td>{{$firmas_int->num_expediente}}</td> 
                            <td>{{$firmas_int->name}} {{$firmas_int->apellido_p}} {{$firmas_int->apellido_m}}</td> 
                            <td>{{$firmas_int->tipo_documento}}</td> 
                            <td>
                            <a href="firmarAsignacion/{{$firmas_int->id}}"
                                class="btn waves-effect waves-light btn-info" role="button"><i
                                    class="ion ion-md-key"></i></a>
                            </td>    
                            <td><span class="badge badge-danger">{{$firmas_int->estado}}</span></td>  
                            <td>{{$firmas_int->created_at}}</td> 
                            <td>{{$firmas_int->updated_at}}</td> 
                            <td>{{$firmas_int->captura}}</td> 
                        </tr>                       
                        @endforeach
                        @foreach($firmas_ext as $firmas_ext)
                        <tr>                                                
                            <td>{{$firmas_ext->num_expediente}}</td> 
                            <td>{{$firmas_ext->name}} {{$firmas_ext->apellido_p}} {{$firmas_ext->apellido_m}}</td> 
                            <td>{{$firmas_ext->tipo_documento}}</td> 
                             <td>
                            <a href="firmarAsignacion/{{$firmas_ext->id}}"
                                class="btn waves-effect waves-light btn-info" role="button"><i
                                    class="ion ion-md-key"></i></a>
                            </td>  
                            <td ><span class="badge badge-danger">{{$firmas_ext->estado}}</span></td>  
                            <td>{{$firmas_ext->created_at}}</td> 
                            <td>{{$firmas_ext->updated_at}}</td> 
                            <td>{{$firmas_ext->captura}}</td> 
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