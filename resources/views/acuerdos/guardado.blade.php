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
                        <li class="breadcrumb-item"><a href="/acuerdos">Acuerdos</a></li>
                        <li class="breadcrumb-item active">Detalles del acuerdo</li>
                    </ol>
                </div>
                <h4 class="page-title">Acuerdo generado folio:{{$acuerdo->num_folio}}</h4>
                <div class="row">
                    <div class="col-6">
                      

                        <a href="/imprimir_acuerdo/{{$acuerdo->id}}" target="_blank" class="button-list">
                            <button type="button" class="btn btn-danger waves-effect waves-light">
                                <span class="btn-label"><i class="mdi mdi-pdf-box"></i>
                                </span><abbr title="El logo y los encabezados se mostraran hasta que el acuerdo este firmado">Vista previa del acuerdo</abbr>.</button>
                        </a>

                    </div>
                   
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">{{$expediente->num_expediente}}</h4>
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card-box widget-user position-relative">
                                <img src="../img/martillo.png" class="avatar-md rounded-circle" alt="user">
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">{{$expediente_sala->name}}
                                        {{$expediente_sala->apellido_p}} {{$expediente_sala->apellido_m}}</h5>
                                    <p class="text-muted mb-0 font-13">{{$expediente_sala->email}}</p>
                                    <div class="user-position">
                                        <span class="text-warning font-weight-bold">Magistrado</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                                    <i class="ion ion-md-paper font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-success text-uppercase">Número de Sala </h6>
                                    <h3>{{$expediente_sala->num_sala}}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-7">
                        <div class="card-box tilebox-three">
                            <div class="avatar-lg rounded-circle bg-light border border float-left">
                                <i class=" mdi mdi-home-map-marker font-22 avatar-title text-muted"></i>
                            </div>
                            <div class="text-right">
                                <h6 class="text-pink text-uppercase">Ubicación</h6>
                                <h5>{{$expediente->ubicacion}}</5>
                            </div>
                        </div>
                    </div>

                    </div>
                    <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-box">
                                                    <h4 class="header-title">Información del acuerdo generado</h4>                                                  
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th>Versión</th>
                                                                    <th>N° Folio</th>
                                                                    <th>Tipo</th>
                                                                    <th>Estado</th>
                                                                    <th>Ver texto</th>
                                                                    <th>Ver acuerdo</th>
                                                                    <th>Modificado por</th>
                                                                    <th>Fecha de captura</th>
                                                                    <th>Ultima actualización</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>                                                              
                                                                @include('acuerdos.modalAcuerdo')
                                                                @include('acuerdos.modalText')
                                                                <tr>
                                                                    <td>{{$acuerdo->version}}</td>
                                                                    <td>{{$acuerdo->num_folio}}</td>
                                                                    <td>{{$acuerdo->tipo}}</td>
                                                                    <td>{{$acuerdo->estado}}</td>
                                                                    <td><button type="button"
                                                                            class="btn btn-info waves-effect waves-light "  data-toggle="modal"
                                                                            data-target="#modalText{{$acuerdo->id}}"
                                                                            data-dismiss="modal"
                                                                            role="button">
                                                                            <i class="fa fa-eye"></i></button></td>
                                                                    <td> <button type="button"
                                                                            class="btn btn-danger waves-effect waves-light"
                                                                            data-toggle="modal"
                                                                            data-target="#modalAcuerdo{{$acuerdo->id}}"
                                                                            data-dismiss="modal">
                                                                            <i class="mdi mdi-file-pdf"></i>
                                                                        </button></td>
                                                                    <td>{{$acuerdo->captura}}</td>
                                                                    <td>{{$acuerdo->created_at}}</td>
                                                                    <td>{{$acuerdo->updated_at}}</td>


                                                                </tr>
                                                            
                                                            </tbody>
                                                        </table>
                                                    </div>                                                  


                                                </div>

                                            </div>

                                        </div>

                 
                                        @include('expedientes.modal_escritoInicial')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="header-title">Historial del expediente</h4>
                                <div class="form-group" class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Tipo Expediente</th>
                                                <th>Tipo</th>
                                                <th>Folio</th>
                                                <th>Estado</th>
                                                <th>Fecha de captura</th>
                                                <th>Modificado por</th>
                                                <th>Ver</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$expediente->tipo}}</td>
                                                <td>INGRESO DE EXPEDIENTE</td>
                                                <td>{{$expediente->num_expediente}}</td>
                                                <td><span class="badge badge-danger">{{$expediente->estado}}</span>
                                                </td>
                                                <td>{{$expediente->created_at}}</td>
                                                <td>{{$expediente->captura}}</td>
                                                <td>
                                                    <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                                        class="btn waves-effect waves-light btn-info btn-sm"
                                                        role="button" target="_blank"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td>{{$expediente->tipo}}</td>
                                                <td>ESCRITO INICIAL DE DEMANDA</td>
                                                <td>{{$expediente->num_expediente}}</td>
                                                <td><span class="badge badge-danger">{{$expediente->estado}}</span>
                                                </td>
                                                <td>{{$expediente->created_detalle}}</td>
                                                <td>{{$expediente->captura}}</td>
                                                <td><button type="button"
                                                        class="btn waves-effect waves-light btn-info btn-sm"
                                                        data-toggle="modal"
                                                        data-target="#modalEscrito{{$expediente->id}}"
                                                        data-dismiss="modal" role="button">
                                                        <i class="mdi mdi-eye"></i></button></td>
                                            </tr>
                                            @foreach($amparos as $amparo)
                                            <tr>
                                                <td></td>
                                                <td>{{$amparo->tipo}}</td>
                                                <td>{{$amparo->folio}}</td>
                                                <td><span class="badge badge-danger">{{$amparo->estado}}</span>
                                                </td>
                                                <td>{{$amparo->created_at}}</td>
                                                <td>{{$amparo->captura}}</td>
                                                <td><a href='/ver_amparo/{{$amparo->id}}'
                                                        class="btn waves-effect waves-light btn-info btn-sm"
                                                        role="button" target="_blank">
                                                        <i class="mdi mdi-eye"></i></a></td>
                                            </tr>
                                            @endforeach
                                            @foreach($acuerdos as $acuerdo)
                                            <tr>
                                                <td></td>
                                                <td>ACUERDO</td>
                                                <td>{{$acuerdo->num_folio}}</td>
                                                <td><span class="badge badge-danger">{{$acuerdo->estado}}</span>
                                                </td>
                                                <td>{{$acuerdo->created_at}}</td>
                                                <td>{{$acuerdo->captura}}</td>
                                                <td> <a href="{{URL::action('acuerdosController@show',$acuerdo->id)}}"
                                                        class="btn waves-effect waves-light btn-info btn-sm"
                                                        role="button" target="_blank"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>



                            </div>

                        </div>

                    </div>
                    <!--FIN ROW HISTORIAL-->


                </div>
            </div>
        </div>
        <!-- end row -->
    </form>

</div> <!-- end container-fluid -->

@stop