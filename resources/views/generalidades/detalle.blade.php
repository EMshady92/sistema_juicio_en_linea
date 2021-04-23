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
                        <li class="breadcrumb-item"><a href="/generalidades">Generalidades</a></li>
                        <li class="breadcrumb-item active">Detalles del expediente</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles del expediente</h4>
                <div class="row">
                    <div class="col-6">
                        <?php 
                                $id= Crypt::encrypt($expediente->id);
                                 ?>

                        <a href="/acuse_ingreso/{{$id}}" target="_blank" class="button-list">
                            <button type="button" class="btn btn-danger waves-effect waves-light">
                                <span class="btn-label"><i class="mdi mdi-pdf-box"></i>
                                </span>Imprimir acuse</button>
                        </a>

                    </div>
                    <div class="col-6 float-right">
                        <a href="/expedientes/create" class="button-list float-right">
                            <button type="button" class="btn btn-success waves-effect waves-light">
                                <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                                </span>Registrar otro expediente</button>
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
                                            <th>Número de anexos: </th>
                                            <td id="hojas_anexo"><select class="form-control " style="width: 100%"
                                                    data-toggle="select2" name="hojas_anexo[]" id="hojas_anexo"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$DetalleExp->id}}" selected>
                                                        {{$DetalleExp->num_anexos}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Hojas de escrito: </th>
                                            <td id="hojas_escrito"><select class="form-control " style="width: 100%"
                                                    name="hojas_escrito[]" id="hojas_escrito" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$DetalleExp->id}}" selected>
                                                        {{$DetalleExp->hojas_escrito}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Hojas de traslados: </th>
                                            <td id="hojas_traslados"><select class="form-control " style="width: 100%"
                                                    name="hojas_traslados[]" id="hojas_traslados" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$DetalleExp->id}}" selected>
                                                        {{$DetalleExp->hojas_traslados}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Escaneo anexos: </th>
                                            <td id="hojas_anexos">
                                                @foreach($escaneos as $escaneo)
                                                <div class="mb-2">
                                                    <a href="../OFICIALIA/archivos/ingresos/{{$escaneo->escaneo_anexos}}"
                                                        class="btn waves-effect waves-light btn-info btn-sm"
                                                        target="_blank" role="button">
                                                        <i class="fas fa-file-pdf"> Anexo n°
                                                            {{$escaneo->num_anexo}}</i>
                                                    </a> {{$escaneo->num_hojas}} hojas.
                                                </div>
                                                @endforeach
                                            </td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Escaneo escrito: </th>
                                            <td id="hojas_traslados">
                                                <a href='../OFICIALIA/archivos/ingresos/{{$DetalleExp->escaneo_escrito}}'
                                                    target="_blank" class="btn waves-effect waves-light btn-info btn-sm"
                                                    role="button">
                                                    <i class="fas fa-file-pdf"></i></a>
                                            </td>
                                        </tr>


                                    </table>
                                </div>
                            </div>
                        </div>
                        <!--Fin de la columna de datos 2 -->
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