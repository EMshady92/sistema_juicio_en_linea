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
                        <li class="breadcrumb-item"><a href="/amparos_promociones">Amparos</a></li>
                        <li class="breadcrumb-item active">Detalles del expediente</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles @if($amparo->tipo=="AMPARO") del {{$amparo->tipo}} @else de la
                    {{$amparo->tipo}} @endif </h4>
              

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
                    <h4 class="header-title">N° de expediante relacionado: {{$expediente->num_expediente}}</h4>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-box">
                                <h4 class="header-title">Información @if($amparo->tipo=="AMPARO") del {{$amparo->tipo}}
                                    @else de la {{$amparo->tipo}} @endif</h4>

                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">

                                        <tr class="bg-light text-dark">
                                            <th>Tipo : </th>
                                            <td id="tipo_amparo_div"><select class="form-control" style="width: 100%"
                                                    name="tipo_amparo[]" id="tipo_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option value="{$amparo->id}}" selected>
                                                        {{$amparo->tipo}}
                                                    </option>
                                                </select></td>

                                        </tr>




                                        <tr class="bg-white text-dark">
                                            <th>Número de expediente:</th>
                                            <td id="num_exp2"><select class="form-control " style="width: 100%"
                                                    name="num_exp2[]" id="num_exp2" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$expediente->num_expediente}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Número de anexos: </th>
                                            <td id="hojas_anexo_amp"> <select class="form-control s "
                                                    style="width: 100%" name="hojas_anexo_amp[]" id="hojas_anexo_amp"
                                                    data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$amparo->num_anexos}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Hojas de escrito: </th>
                                            <td id="hojas_escrito_amp"> <select class="form-control s "
                                                    style="width: 100%" name="hojas_escrito_amp[]"
                                                    id="hojas_escrito_amp" data-toggle="select2" multiple="multiple"
                                                    disabled>
                                                    <option selected>
                                                        {{$amparo->hojas_escrito}}
                                                    </option>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-white text-dark">
                                            <th>Fecha: </th>
                                            <td id="fecha_amparo"><select class="form-control " style="width: 100%"
                                                    name="fecha_amparo[]" id="fecha_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$amparo->fecha}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card-box">
                                <h4 class="header-title">Datos</h4>

                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">

                                        <tr class="bg-light text-dark">
                                            <th>Modificado por : </th>
                                            <td><select class="form-control" style="width: 100%"
                                                    name="captura_amparo[]" id="captura_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option value="{$amparo->captura}}" selected>
                                                        {{$amparo->captura}}
                                                    </option>
                                                </select></td>

                                        </tr>




                                        <tr class="bg-white text-dark">
                                            <th>Fecha de captura:</th>
                                            <td id="num_exp2"><select class="form-control " style="width: 100%"
                                                    name="created_amparo[]" id="created_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$amparo->created_at}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Ultima actualización: </th>
                                            <td> <select class="form-control s "
                                                    style="width: 100%" name="updated_amparo[]" id="updated_amparo"
                                                    data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$amparo->updated_at}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Escaneo anexos: </th>
                                            <td id="hojas_anexos">
                                            @if($escaneos)
                                            @foreach($escaneos as $escaneos_amp) 
                                            <div class="mb-2">                                         
                                                <a href="../OFICIALIA/archivos/amparos_promociones/{{$escaneos_amp->escaneo_anexos}}" class="btn btn-danger waves-effect waves-light btn-sm" 
                                                target="_blank" role="button">
                                                <i class="fas fa-file-pdf"> Anexo n° {{$escaneos_amp->num_anexo}}</i>
                                                </a>  {{$escaneos_amp->num_hojas}} hojas.
                                                </div>                                                                                            
                                            @endforeach
                                            @endif
                                            </td>                                            
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Escaneo escrito: </th>
                                            <td id="hojas_traslados">
                                                <a href='../OFICIALIA/archivos/amparos_promociones/{{$amparo->escaneo_escrito}}'
                                                    target="_blank" class="btn btn-danger waves-effect waves-light btn-sm"
                                                    role="button">
                                                    <i class="fas fa-file-pdf"></i></a>
                                            </td>
                                        </tr>

                                    </table>
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
                    <!--Fin del row -->





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