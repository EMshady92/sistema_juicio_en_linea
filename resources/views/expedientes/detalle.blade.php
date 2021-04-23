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
                        <li class="breadcrumb-item active">Detalles del expediente</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles del expediente</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->
    @include('expedientes.modalAsignacion')
    <form action="" id="form"   method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">{{$expediente->num_expediente}}</h4>
                    
                    <div class="row">
                        @if($expediente_sala)
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
                        @else
                             <div class="card-box widget-user position-relative">
                                <img src="../img/martillo.png" class="avatar-md rounded-circle" alt="user">
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">
                                        No hay magistrados asignados a su sala</h5>
                                    <p class="text-muted mb-0 font-13"></p>
                                </div>
                            </div>
                      
                        
                        @endif

                        <div class="col-xl-3 col-md-7">
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

                        @if($expediente->id_recibe == Auth::user()->id)                      
                        <div class="col-xl-3 col-md-7">
                        <a href="javascript:traer_coordinadores({{$expediente->id}});">
                        <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                              <i class="mdi mdi-send-check font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-blue text-uppercase">Enviar expediente</h6>
                                    <p class="text-muted mb-0 font-13">Enviar el expediente en forma física al coordinador de la sala  @if($expediente_sala) {{$expediente_sala->num_sala}} @endif</p>
                                </div>
                            </div>
                            </a>
                        </div>                      
                        @endif



                    </div>

                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card-box">
                                <h4 class="header-title">Información del expediente</h4>

                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">

                                        <tr class="bg-light text-dark">
                                            <th scope="row">Número de expediente : </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="num_expediente[]" id="num_expediente"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Tipo:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="tipo_aux[]" id="tipo_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Tipo de juicio:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="tipo_juicio[]" id="tipo_juicio"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                        @if($expediente->tipo == "RAG" || $expediente->tipo == "GENERALIDAD")
                                        <tr class="bg-white text-dark">
                                            <th>Tipo de falta:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="tipo_falta[]" id="tipo_falta"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>


                                        <tr class="bg-light text-dark">
                                            <th>Presunto responsable: </th>
                                            <td id="num_exp"> <select class="form-control select2-multiple "
                                                    style="width: 100%" name="presunto_resp_aux[]" id="presunto_resp_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-white text-dark">
                                            <th>Autoridad Investigadora: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="autoridad_inv_aux[]" id="autoridad_inv_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-light text-dark">
                                            <th>Autoridad Sustanciadora: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="autoridad_sust_aux[]" id="autoridad_sust_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr lass="bg-white text-dark">
                                            <th>Denunciante: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="denunciante_aux[]" id="denunciante_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                        <tr lass="bg-white text-dark">
                                            <th>Particular vinculado con faltas administrativas graves: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="particular_aux[]" id="particular_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        @elseif($expediente->tipo == "NULIDAD" || $expediente->tipo == "GENERALIDAD")
                                        <tr class="bg-light text-dark">
                                            <th>Actores: </th>
                                            <td id="num_exp"> <select class="form-control select2-multiple "
                                                    style="width: 100%" name="actor_aux[]" id="actor_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-white text-dark">
                                            <th>Demandados: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="demandados_aux[]" id="demandados_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-light text-dark">
                                            <th>Abogados: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="abogados_aux[]" id="abogados_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr lass="bg-white text-dark">
                                            <th>Terceros Interesados: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="terceros_aux[]" id="terceros_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        @endif

                                      

                                        <tr class="bg-light text-dark">
                                            <th>Fecha: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="fecha_aux[]" id="fecha_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--Fin de la columna de datos 1 -->

                        <div class="col-lg-5">
                            <div class="card-box">
                                <h4 class="header-title">Datos</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">


                                        <tr class="bg-white text-dark">
                                            <th>Ultima actualización:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="ultima_ac[]" id="ultima_ac"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-light text-dark">
                                            <th scope="row">Fecha de captura : </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="fecha_captura[]" id="fecha_captura"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                        </tr>
                                        <tr class="bg-white text-dark">
                                            <th>Modificado por: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="modificado[]" id="modificado"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Observaciónes: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="observaciones_aux[]" id="observaciones_aux"
                                                    data-toggle="select2" multiple="multiple" disabled>

                                                </select></td>
                                        </tr>








                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--Fin de la columna de datos 2 -->
                        <div class="col-lg-2">
                            <div class="card-box">
                                <h4 class="header-title">Generar portada folder</h4>
                                <div class="table-responsive">
                                    

                                            <a href="{{URL::action('ExpedientesController@portada',$expediente->id)}}" target="_blank" id="invoice"
                                                class="btn waves-effect waves-light btn-primary" role="button"><i
                                                    class="mdi mdi-printer"></i></a>
                                        
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--Fin del row -->



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
<script>
window.onload = function() {
    id = '{{ $expediente->id }}';

    traerExpediente(id, 'detalle');
};
</script>
@stop