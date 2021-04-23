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
                            <li class="breadcrumb-item active">Revisar acuerdo</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Revisar acuerdo generado Folio:{{$acuerdo_aux[0]->num_folio}} número de
                        expediente{{$expediente->num_expediente}}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="header-title">Formulario para revisar acuerdo</h4>

                            @include('users.modalPassword')
                            <form id="wizard-validation-form"
                                action="{{ url('guardarAcuerdoRev',[$acuerdo_aux[0]->id]) }}"  name="formulario" onsubmit="return valida_envio_firma();recorre_tabla();" method="post" files="true"
                                enctype="multipart/form-data">

                                {{csrf_field()}}

                                <div>
                                    <h3>Historial del expediente</h3>
                                    <section>
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
                                                                    id="num_expediente"
                                                                    value="{{$expediente->num_expediente}}"
                                                                    multiple="multiple" disabled>

                                                        </tr>

                                                        <tr class="bg-white text-dark">
                                                            <th>Tipo:</th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="tipo_aux[]" id="tipo_aux"
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>

                                                        <tr class="bg-white text-dark">
                                                            <th>Tipo de juicio:</th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="tipo_juicio[]"
                                                                    id="tipo_juicio" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>

                                                        @if($expediente->tipo == "RAG" || $expediente->tipo ==
                                                        "GENERALIDAD")
                                                        <tr class="bg-white text-dark">
                                                            <th>Tipo de falta:</th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="tipo_falta[]"
                                                                    id="tipo_falta" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>


                                                        <tr class="bg-light text-dark">
                                                            <th>Presunto responsable: </th>
                                                            <td id="num_exp"> <select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="presunto_resp_aux[]"
                                                                    id="presunto_resp_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        <tr class="bg-white text-dark">
                                                            <th>Autoridad Investigadora: </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="autoridad_inv_aux[]"
                                                                    id="autoridad_inv_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        <tr class="bg-light text-dark">
                                                            <th>Autoridad Sustanciadora: </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="autoridad_sust_aux[]"
                                                                    id="autoridad_sust_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        <tr lass="bg-white text-dark">
                                                            <th>Denunciante: </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="denunciante_aux[]"
                                                                    id="denunciante_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>

                                                        <tr lass="bg-white text-dark">
                                                            <th>Particular vinculado con faltas administrativas graves:
                                                            </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="particular_aux[]"
                                                                    id="particular_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        @elseif($expediente->tipo == "NULIDAD" || $expediente->tipo ==
                                                        "GENERALIDAD")
                                                        <tr class="bg-light text-dark">
                                                            <th>Actores: </th>
                                                            <td id="num_exp"> <select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="actor_aux[]"
                                                                    id="actor_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        <tr class="bg-white text-dark">
                                                            <th>Demandados: </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="demandados_aux[]"
                                                                    id="demandados_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        <tr class="bg-light text-dark">
                                                            <th>Abogados: </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="abogados_aux[]"
                                                                    id="abogados_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        <tr lass="bg-white text-dark">
                                                            <th>Terceros Interesados: </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="terceros_aux[]"
                                                                    id="terceros_aux" 
                                                                    multiple="multiple" disabled>

                                                                </select></td>
                                                        </tr>
                                                        @endif



                                                        <tr class="bg-light text-dark">
                                                            <th>Fecha: </th>
                                                            <td id="num_exp"><select
                                                                    class="form-control select2-multiple "
                                                                    style="width: 100%" name="fecha_aux[]"
                                                                    id="fecha_aux" 
                                                                    multiple="multiple" disabled>

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
                                                                        id="fecha_captura" multiple="multiple" disabled>

                                                            </tr>
                                                            <tr class="bg-white text-dark">
                                                                <th>Modificado por: </th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="modificado[]"
                                                                        id="modificado" multiple="multiple" disabled>

                                                                    </select></td>
                                                            </tr>

                                                            <tr class="bg-white text-dark">
                                                                <th>Observaciónes: </th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="observaciones_aux[]"
                                                                        id="observaciones_aux" 
                                                                        multiple="multiple" disabled>

                                                                    </select></td>
                                                            </tr>

                                                        


                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
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
                                                <td>{{$expediente->created_at}}</td>
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


                                 



                                    </section>
                                    <h3>Acuerdo generado</h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-box">
                                                    <h4 class="header-title">Realizar correciónes al acuerdo</h4>

                                                    <div class="table-responsive">
                                                        <table id="key-table"
                                                            class="table table-bordered dt-responsive nowrap"
                                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Versión</th>
                                                                    <th>N° Folio</th>
                                                                    <th>Tipo de
                                                                        acuerdo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                    </th>
                                                                    <th>Tiempo de contestación</th>
                                                                    <th>Estado</th>
                                                                    <th>Asignado</th>
                                                                    <th>Acuerdo original</th>
                                                                    <th>Modificado por</th>
                                                                    <th>Fecha de captura</th>
                                                                    <th>Ultima actualización</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($acuerdo_aux as $acuerdo)
                                                                @include('acuerdos.modalAcuerdo')

                                                                <tr>
                                                                    <td>{{$acuerdo->version}}</td>
                                                                    <td>{{$acuerdo->num_folio}}</td>
                                                                    <td style="width:50px"> <select class="form-control"
                                                                            style="width: 100%" name="tipoAcuerdo"
                                                                            id="tipoAcuerdo" required
                                                                            data-placeholder="Seleccione una opción ...">
                                                                            @foreach($tipos as $tipo)
                                                                            @if($tipo->id == $acuerdo->id_tipo_acuerdo)
                                                                            <option value="{{$tipo->id}}" selected>
                                                                                {{$tipo->tipo}}
                                                                            </option>
                                                                            @else
                                                                            <option value="{{$tipo->id}}">
                                                                                {{$tipo->tipo}}
                                                                            </option>
                                                                            @endif
                                                                            @endforeach

                                                                        </select>
                                                                    </td>

                                                                    <td>
                                                                    <input type="number" name="tiempo_contestacion"
                                                        parsley-trigger="change" min='1' max="99" value="15" required
                                                        placeholder="Ingrese el tiempo de contestación en número de días"
                                                        class="form-control" value="{{$acuerdo->tiempo_contestacion}}" id="tiempo_contestacion">
                                                         días</td>
                                                                    <td>{{$acuerdo->estado}}</td>
                                                                    <td>{{$acuerdo->name_asig}}
                                                                        {{$acuerdo->apellido_pasig}}
                                                                        {{$acuerdo->apellido_masig}}</td>
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
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>



                                                </div>

                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="exampleTextarea">Modificar acuerdo</label>
                                                    <textarea class="ckeditor" id="acuerdo" name="acuerdo" rows="60">
                                                   {{$acuerdo->acuerdo_text}}
                                                    </textarea>
                                                    <div class="text-danger" id='error_acuerdo' name="error_acuerdo">
                                                    </div>

                                                </div>

                                            </div><!-- end row -->


                                    </section>
                                    <h3>Estatus Final</h3>
                                    <section>



                                        <div class="col-8 mr-auto mr-4 mb-4">

                                            <div class="form-group">
                                                <label for="userName">Que desea hacer con la revisión<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" style="width: 100%" name="correcto"
                                                    id="correcto" required data-placeholder="Seleccione una opción ...">
                                                    <option value="" selected>Seleccione una opción</option>
                                                    <option value="ACUERDO_CON_CORRECCIONES">
                                                        Regresar el acuerdo a: {{$acuerdo_aux[0]->name_asig}}
                                                        {{$acuerdo_aux[0]->apellido_pasig}}
                                                        {{$acuerdo_aux[0]->apellido_masig}} con las observaciónes
                                                        realizadas.
                                                    </option>
                                                    <option value="ACUERDO_CON_CORRECCIONES_APLICADAS">
                                                        Realizar correciones aplicadas y firmar acuerdo.
                                                    </option>
                                                    <option value="ACUERDO_CORRECTO">
                                                        El acuerdo esta correcto, proceder a firma.
                                                    </option>
                                                </select>
                                                <div class="text-danger" id='error_promocion' name="error_promocion">
                                                </div>


                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="exampleTextarea">Observaciónes</label>
                                            </div>
                                            <div class="form-group">
                                                <textarea name="observaciones" id="observaciones" cols="60"
                                                    rows="10" maxlength="255"></textarea>

                                            </div>

                                        </div><!-- end row -->


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
    $('#correcto').select2({});
    $('.select2-multiple').val(null).trigger('change');

    id = '{{ $expediente->id }}';
    traerExpediente(id, 'detalle');
};
</script>
@endsection