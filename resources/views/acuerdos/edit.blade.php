@extends('layouts.principal')
@section('contenido')

<div class="wrapper">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/acuerdos">Acuerdos</a></li>
                            <li class="breadcrumb-item active">Editar acuerdos</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Modificar acuerdo folio:{{$acuerdo->num_folio}} para el expediente:
                        {{$expediente->num_expediente}}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @include('users.modalPassword')
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="header-title">Formulario para modificar acuerdos</h4>


                            <form id="basic-form" name="formulario"
                                onsubmit="return valida_envio_firma();recorre_tabla();"
                                action="{{ url('acuerdos',[$acuerdo->id]) }}" method="post" files="true"
                                enctype="multipart/form-data">

                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="PUT">

                                <div>
                                    <h3>Historial del expediente</h3>
                                    <section>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <div class="card-box">
                                                        <h4 class="header-title">Información del expediente</h4>

                                                        <div class="table-responsive">
                                                            <table class="table table-borderless mb-0">

                                                                <tr class="bg-light text-dark">
                                                                    <th scope="row">Número de expediente : </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="num_expediente[]"
                                                                            id="num_expediente" multiple="multiple"
                                                                            disabled>

                                                                </tr>

                                                                <tr class="bg-white text-dark">
                                                                    <th>Tipo:</th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="tipo_aux[]"
                                                                            id="tipo_aux" multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>

                                                                <tr class="bg-white text-dark">
                                                                    <th>Tipo de juicio:</th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="tipo_juicio[]"
                                                                            id="tipo_juicio" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>

                                                                @if($expediente->tipo == "RAG" || $expediente->tipo ==
                                                                "GENERALIDAD")
                                                                <tr class="bg-white text-dark">
                                                                    <th>Tipo de falta:</th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="tipo_falta[]"
                                                                            id="tipo_falta" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>


                                                                <tr class="bg-light text-dark">
                                                                    <th>Presunto responsable: </th>
                                                                    <td id="num_exp"> <select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="presunto_resp_aux[]"
                                                                            id="presunto_resp_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-white text-dark">
                                                                    <th>Autoridad Investigadora: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="autoridad_inv_aux[]"
                                                                            id="autoridad_inv_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th>Autoridad Sustanciadora: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="autoridad_sust_aux[]"
                                                                            id="autoridad_sust_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr lass="bg-white text-dark">
                                                                    <th>Denunciante: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="denunciante_aux[]"
                                                                            id="denunciante_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>

                                                                <tr lass="bg-white text-dark">
                                                                    <th>Particular vinculado con faltas administrativas
                                                                        graves: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="particular_aux[]"
                                                                            id="particular_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                @elseif($expediente->tipo == "NULIDAD" ||
                                                                $expediente->tipo
                                                                == "GENERALIDAD")
                                                                <tr class="bg-light text-dark">
                                                                    <th>Actores: </th>
                                                                    <td id="num_exp"> <select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="actor_aux[]"
                                                                            id="actor_aux" multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-white text-dark">
                                                                    <th>Demandados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="demandados_aux[]"
                                                                            id="demandados_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th>Abogados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="abogados_aux[]"
                                                                            id="abogados_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr lass="bg-white text-dark">
                                                                    <th>Terceros Interesados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="terceros_aux[]"
                                                                            id="terceros_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                @endif



                                                                <tr class="bg-light text-dark">
                                                                    <th>Fecha: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="fecha_aux[]"
                                                                            id="fecha_aux" multiple="multiple" disabled>

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
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="ultima_ac[]"
                                                                            id="ultima_ac" multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th scope="row">Fecha de captura : </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="fecha_captura[]"
                                                                            id="fecha_captura" multiple="multiple"
                                                                            disabled>

                                                                </tr>
                                                                <tr class="bg-white text-dark">
                                                                    <th>Modificado por: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="modificado[]"
                                                                            id="modificado" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>

                                                                <tr class="bg-white text-dark">
                                                                    <th>Observaciónes: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="observaciones_aux[]"
                                                                            id="observaciones_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>








                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Fin de la columna de datos 2 -->


                                            </div>
                                            <!--Fin del row -->

                                            <!--Fin de la columna de datos 1 -->


                                            <!--Fin de la columna de datos 2 -->
                                        </div>
                                        <!--Fin del row -->
                                        <!-- end row -->
                                        @include('expedientes.modal_escritoInicial')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-box">
                                                    <h4 class="header-title">Historial del expediente</h4>
                                                    <div class="form-group" class="table-responsive">
                                                        <table id="datatable"
                                                            class="table table-bordered dt-responsive nowrap"
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
                                                                    <td><span
                                                                            class="badge badge-danger">{{$expediente->estado}}</span>
                                                                    </td>
                                                                    <td>{{$expediente->created_at}}</td>
                                                                    <td>{{$expediente->captura}}</td>
                                                                    <td>
                                                                        <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                                                            class="btn waves-effect waves-light btn-info btn-sm"
                                                                            role="button" target="_blank"><i
                                                                                class="mdi mdi-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>

                                                                    <td>{{$expediente->tipo}}</td>
                                                                    <td>ESCRITO INICIAL DE DEMANDA</td>
                                                                    <td>{{$expediente->num_expediente}}</td>
                                                                    <td><span
                                                                            class="badge badge-danger">{{$expediente->estado}}</span>
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
                                                                    <td><span
                                                                            class="badge badge-danger">{{$amparo->estado}}</span>
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
                                                                    <td><span
                                                                            class="badge badge-danger">{{$acuerdo->estado}}</span>
                                                                    </td>
                                                                    <td>{{$acuerdo->created_at}}</td>
                                                                    <td>{{$acuerdo->captura}}</td>
                                                                    <td> <a href="{{URL::action('acuerdosController@show',$acuerdo->id)}}"
                                                                            class="btn waves-effect waves-light btn-info btn-sm"
                                                                            role="button" target="_blank"><i
                                                                                class="mdi mdi-eye"></i></a></td>
                                                                </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>



                                                </div>

                                            </div>

                                        </div>
                                        <!--FIN ROW ANEXOS-->




                                    </section>

                                    <h3>Corregir acuerdo</h3>
                                    <section>

                                        <div class="row" id="padre">


                                            <div class="col-3 mr-auto mr-4 mb-4">
                                                <div class="form-group">
                                                    <label for="userName">Tipo de acuerdo<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%" name="tipoAcuerdo"
                                                        id="tipoAcuerdo" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="" selected>Seleccione una opción</option>
                                                        @foreach($tipos as $tipo)
                                                        @if($tipo->id == $acuerdo->id_tipo_acuerdo)
                                                        <option value="{{$tipo->id}}" selected>
                                                            {{$tipo->tipo}}
                                                        </option>
                                                        @else <option value="{{$tipo->id}}">
                                                            {{$tipo->tipo}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>

                                                </div>
                                            </div>



                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="contestacion">Tiempo de contestación<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="tiempo_contestacion"
                                                        parsley-trigger="change" min='1' max="99" value="15" required
                                                        placeholder="Ingrese el tiempo de contestación en número de días"
                                                        class="form-control" id="tiempo_contestacion">
                                                    <div class="text-danger" id='error_dias' name="error_dias"></div>

                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="contestacion">Desea relacionarlo a una promoción<span
                                                            class="text-danger">* </span></label>
                                                    <div class="form-group">
                                                        @if($acuerdo->id_promocion <> null)
                                                            <div class="radio radio-info form-check-inline">
                                                                <input type="radio"
                                                                    onclick="cambia_display_acuerdo(this.value);"
                                                                    id="radioInline" value="SI" name="radioInline"
                                                                    checked>
                                                                <label for="inlineRadio1">Si </label>
                                                            </div>
                                                            <div class="radio form-check-inline">
                                                                <input type="radio"
                                                                    onclick="cambia_display_acuerdo(this.value);"
                                                                    id="radioInline" value="NO" name="radioInline">
                                                                <label for="inlineRadio2">No </label>
                                                            </div>
                                                            @else
                                                            <div class="radio radio-info form-check-inline">
                                                                <input type="radio"
                                                                    onclick="cambia_display_acuerdo(this.value);"
                                                                    id="radioInline" value="SI" name="radioInline">
                                                                <label for="inlineRadio1">Si </label>
                                                            </div>
                                                            <div class="radio form-check-inline">
                                                                <input type="radio"
                                                                    onclick="cambia_display_acuerdo(this.value);"
                                                                    id="radioInline" value="NO" name="radioInline"
                                                                    checked>
                                                                <label for="inlineRadio2">No </label>
                                                            </div>
                                                            @endif
                                                    </div>
                                                </div>
                                            </div>


                                            @if($acuerdo->id_promocion <> null)
                                                <div class="col-3 mr-auto mr-4 mb-4">
                                                    <div class="form-group" id='display_promocion' style='width: 100%'>
                                                        <div class="form-group">
                                                            <label for="userName">Seleccione promocion<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="form-control" style="width: 100%"
                                                                name="promocion" id="promocion"
                                                                data-placeholder="Seleccione una opción ...">
                                                                <option value="" selected>Seleccione una opción</option>
                                                                @foreach($amparos as $amparo)
                                                                @if($acuerdo->id_promocion == $amparo->id)
                                                                <option value="{{$amparo->id}}" selected>
                                                                    Folio: {{$amparo->folio}} Tipo: {{$amparo->tipo}}
                                                                </option>
                                                                @else
                                                                <option value="{{$amparo->id}}">
                                                                    Folio: {{$amparo->folio}} Tipo: {{$amparo->tipo}}
                                                                </option>
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                            <div class="text-danger" id='error_promocion'
                                                                name="error_promocion"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="col-3 mr-auto mr-4 mb-4">
                                                    <div class="form-group" id='display_promocion'
                                                        style='display:none;width: 100%'>
                                                        <div class="form-group">
                                                            <label for="userName">Seleccione promocion<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="form-control" style="width: 100%"
                                                                name="promocion" id="promocion"
                                                                data-placeholder="Seleccione una opción ...">
                                                                <option value="" selected>Seleccione una opción</option>
                                                                @foreach($amparos as $amparo)
                                                                <option value="{{$amparo->id}}">
                                                                    Folio: {{$amparo->folio}} Tipo: {{$amparo->tipo}}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="text-danger" id='error_promocion'
                                                                name="error_promocion"></div>

                                                        </div>
                                                    </div>
                                                </div>
                                                @endif


                                                @include('acuerdos.modalAcuerdo')
                                                <div class="col-lg-4">
                                                    <div class="card bg-primary text-white">
                                                        <div class="card-body">
                                                            <blockquote class="card-bodyquote mb-0">
                                                                <p>Ver acuerdo con
                                                                    correciones
                                                                </p>
                                                                <footer class="blockquote-footer text-white font-13">
                                                                    Acuerdo anterior con correciones.
                                                                </footer>
                                                                <button type="button"
                                                                    class="btn btn-danger waves-effect waves-light"
                                                                    data-toggle="modal"
                                                                    data-target="#modalAcuerdo{{$acuerdo->id}}"
                                                                    data-dismiss="modal">
                                                                    <i class="mdi mdi-file-pdf">Ver</i>
                                                                </button>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="exampleTextarea">Modificar acuerdo</label>
                                                        <textarea class="ckeditor" id="acuerdo" name="acuerdo"
                                                            rows="10">
                                                    {{$acuerdo->acuerdo_text}}
                                                    </textarea>
                                                        <div class="text-danger" id='error_acuerdo'
                                                            name="error_acuerdo">
                                                        </div>

                                                    </div>
                                                </div>
                                                @if($acuerdo->observaciones <> null)
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-4">
                                                            <div class="card card-inverse text-white"
                                                                style="background-color: #333; border-color: #333;">
                                                                <div class="card-body">
                                                                    <h5 class="card-title text-white">Observaciónes:
                                                                    </h5>
                                                                    <p class="card-text">{{$acuerdo->observaciones}}</p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div><!-- end row -->
                                                    @endif

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="exampleTextarea">Agregar observaciónes</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <textarea name="observaciones" id="observaciones" cols="60"
                                                                rows="10" maxlength="255"></textarea>

                                                        </div>

                                                    </div><!-- end row -->



                                        </div>
                                    </section>
                                    <h3>Editar firmas necesarias</h3>
                                    <section>
                                        @if($asignaciones)
                                        <div class="row">
                                            <div class="col-3 mr-auto mr-4 mb-4">

                                                <div class="form-group">

                                                    <label for="userName">Tipo de documento<span
                                                            class="text-danger">*</span></label>

                                                    <select class="form-control" style="width: 100%"
                                                        name="tipoDocumento" id="tipoDocumento" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="{{$asignaciones[0]->tipo_documento}}" selected>
                                                            {{$asignaciones[0]->tipo_documento}}
                                                        </option>
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="userName">Tipo de expediente<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%"
                                                        name="tipoExpediente" id="tipoExpediente" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value=" {{$asignaciones[0]->tipo_expediente}}">
                                                            {{$asignaciones[0]->tipo_expediente}}
                                                        </option>

                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>

                                            </div>


                                            <div class="col-3 mr-auto mr-4 mb-4">
                                                <div class="form-group">
                                                    <label for="userName">Tipo de juicio<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%" name="tipoJuicio"
                                                        id="tipoJuicio" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="{{$asignaciones[0]->tipo_juicio}}" selected>
                                                            {{$asignaciones[0]->tipo_juicio}}
                                                        </option>

                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="contestacion">Número de expediente<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="num_exp" parsley-trigger="change" required
                                                        placeholder="Ingrese el número de expediente"
                                                        value=" {{$asignaciones[0]->num_expediente}}"
                                                        class="form-control" id="num_exp" readonly>
                                                </div>
                                            </div>
                                            <div class="col-3 mr-auto mr-4 mb-4">
                                                <div class="form-group">
                                                    <label for="userName">Sala<span class="text-danger">*
                                                        </span></label>
                                                    <select class="form-control" style="width: 100%" name="sala"
                                                        id="sala" required data-placeholder="Seleccione una opción ...">
                                                        <option value=" {{$asignaciones[0]->sala}}" selected readonly>
                                                            {{$asignaciones[0]->sala}}</option>
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="userName">Proyectista<span class="text-danger">*
                                                        </span></label>
                                                    <select class="form-control" style="width: 100%" name="proyectista"
                                                        id="proyectista" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="" selected>Seleccione una opción</option>
                                                        @foreach($users as $user)
                                                        @if($user->funcion == "PROYECTISTA" || $user->funcion ==
                                                        "SECRETARIO AUXILIAR" || $user->funcion == "SECRETARIA GENERAL
                                                        DE ACUERDOS" )
                                                        @if($user->name." ".$user->apellido_p." ".$user->apellido_m ==
                                                        $asignaciones[0]->proyectista)
                                                        <option
                                                            value="{{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}"
                                                            selected>
                                                            {{$user->funcion}} {{$user->name}} {{$user->apellido_p}}
                                                            {{$user->apellido_m}}
                                                        </option>
                                                        @else
                                                        <option
                                                            value="{{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}">
                                                            {{$user->funcion}} {{$user->name}} {{$user->apellido_p}}
                                                            {{$user->apellido_m}}
                                                        </option>
                                                        @endif
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="contestacion">Ponente<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="ponente" name="ponente" required
                                                    placeholder="Nombre del ponente"
                                                    value=" {{$asignaciones[0]->ponente}}"
                                                    onkeypress="return caracteres(event)" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mr-auto mr-6 mb-6">
                                                <div class="form-group">
                                                    <label for="userName">Agregar firmantes<span class="text-danger">*
                                                            (En el
                                                            orden deseado para
                                                            su firma)</span></label>
                                                    <select class="form-control" style="width: 100%" name="firmantes"
                                                        id="firmantes" data-placeholder="Seleccione una opción ...">
                                                        <option value="" selected>Seleccione una opción</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}">
                                                            {{$user->funcion}}: {{$user->name}} {{$user->apellido_p}}
                                                            {{$user->apellido_m}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <a class="btn waves-effect btn-secondary"
                                                        onclick="llenar_firmante();recorre_tabla();">Agregar </a>
                                                </div>
                                                <div class="porlets-content">
                                                    <div class="table-responsive">
                                                        <table class="display table table-bordered table-striped"
                                                            name="detalles[]" id="detalles" id="dynamic-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Eliminar </th>
                                                                    <th>Número de firma </th>
                                                                    <th>Usuario </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <?php
                                                            $i=1;
                                                            ?>
                                                                    @foreach($asignaciones as $asignacion)
                                                                    <td><input type="button"
                                                                            class="btn waves-effect btn-secondary"
                                                                            value="Eliminar"
                                                                            onClick="eliminarFilaLista(this.parentNode.parentNode.rowIndex);recorre_tabla();">
                                                                    </td>
                                                                    <td> {{$i}}</td>
                                                                    <td><select class="form-control" style="width: 100%"
                                                                            name="tipoIngreso"
                                                                            id="{{$asignacion->id_user}}"
                                                                            data-toggle="select2">
                                                                            <option value="{{$asignacion->id_user}}"
                                                                                selected>{{$asignacion->funcion}}:
                                                                                {{$asignacion->name}}
                                                                                {{$asignacion->apellido_p}}
                                                                                {{$asignacion->apellido_m}}</option>
                                                                        </select></td>
                                                                </tr>
                                                                <?php $i=$i+1; ?>
                                                                @endforeach

                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <!--/porlets-content-->
                                                </div>
                                                <!--/block-web-->
                                            </div>
                                        </div>
                                        <input id="array" name="array[]" type="hidden">
                                        <div class="row">
                                            <div class="col-6">






                                            </div>

                                        </div>
                                        </div>
                                        @else


                                
                                <div class="col-md-4">
                                    <div class="text-center mt-4">
                                        <div>
                                            <i class="far fa-file-code text-warning h2 mb-0"></i>
                                        </div>
                                        <h5 class="font-16">Aun no ha asignado firmas para este acuerdo</h5>
                                    </div>
                                </div>

                                @endif

                                </section>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- end row -->



</div> <!-- end container-fluid -->
</div>
<!-- end wrapper -->



@stop

@section('javascript')

<script>
window.onload = function() {
    $(".select2-multiple").select2({
        width: '100%'
    });
    $('.select2-multiple').val(null).trigger('change');

    id = '{{ $expediente->id }}';
    traerExpediente(id, 'detalle');
    recorre_tabla();
};
</script>
@endsection