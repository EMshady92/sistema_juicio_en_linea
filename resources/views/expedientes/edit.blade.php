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
                        <li class="breadcrumb-item active">Edición de expediente</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar expediente: {{$expediente->num_expediente}}</h4>

            </div>
            @include('expedientes.modal')
            @include('expedientes.modal_demandado')
            @include('expedientes.modal_abogado')
            @include('expedientes.modal_tercera')



        </div>
    </div>
    <!-- end page title -->
    <form action="{{url('/expedientes', [$expediente->id])}}" id="form" method="post" files="true"
        enctype="multipart/form-data" class="form-horizontal parsley-examples">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">




        <div class="col-6 mr-auto mr-4 mb-4">
            <label for="userName">Tipo de ingreso<span class="text-danger">*</span></label>
            <select class="form-control" style="width: 100%" name="tipoIngreso"
                data-placeholder="Seleccione una opción ..." onchange="mostrar_datos_inicio_edit(this.value);"
                id="tipoIngreso" required data-toggle="select2">
                @if($expediente->tipo == "NULIDAD")
                <option value="">Seleccione una opción</option>
                <option value="NULIDAD" selected>Demanda de nulidad </option>
                <option value="RAG">RAG</option>
                <option value="GENERALIDAD">Generalidad (Otros)</option>
                @elseif($expediente->tipo == "RAG")
                <option value="" selected>Seleccione una opción</option>
                <option value="NULIDAD">Demanda de nulidad </option>
                <option value="RAG" selected>RAG</option>
                <option value="GENERALIDAD">Generalidad (Otros)</option>
                @else
                <option value="" selected>Seleccione una opción</option>
                <option value="NULIDAD">Demanda de nulidad </option>
                <option value="RAG">RAG</option>
                <option value="GENERALIDAD" selected>Generalidad (Otros)</option>
                @endif


            </select>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <h4 class="header-title">Formulario de edición</h4>
                                <p class="sub-header">
                                    Formulario para editar expedientes.
                                </p>


                                @if($expediente->tipo == "NULIDAD" || $expediente ->tipo == "GENERALIDAD")
                                <div class="form-group" id='display_nuevo' style='display:block;'>
                                    @else
                                    <div class="form-group" id='display_nuevo' style='display:none;'>
                                        @endif

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-7 ">

                                                    <label for="userName" class="col-sm-3 control-label">Actor<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%" name="actor_aux[]"
                                                        id="actor_aux" data-toggle="select2" multiple="multiple"
                                                        data-placeholder="Seleccione una opción ..." >
                                                        @foreach($personas as $actor)
                                                        <option value="{{$actor->id}}">{{$actor->nombre}}
                                                            {{$actor->apellido_paterno}} {{$actor->apellido_materno}}
                                                            {{$actor->razon_social}}
                                                        </option>
                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-7">

                                                    <label for="userName" class="col-sm-3 control-label">Demandado<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control select2-multiple"
                                                        name="demandados_aux[]" id="demandados_aux"
                                                        data-toggle="select2" multiple="multiple"
                                                        data-placeholder="Seleccione una opción ..." style="width: 100%"
                                                        >
                                                        @foreach($personas as $demandado)
                                                        <option value="{{$demandado->id}}">{{$demandado->nombre}}
                                                            {{$demandado->apellido_paterno}}
                                                            {{$demandado->apellido_materno}}{{$demandado->razon_social}}
                                                        </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <label for="userName" class="col-sm-3 control-label">Abogado<span
                                                            class="text-danger"></span></label>
                                                    <select class="form-control select2-multiple" name="abogados_aux[]"
                                                        id="abogados_aux" data-toggle="select2" style="width: 100%"
                                                        multiple="multiple"
                                                        data-placeholder="Seleccione una opción ...">
                                                        @foreach($personas as $abogado)
                                                        @if($abogado->num_cedula <> "")
                                                            <option value="{{$abogado->id}}">{{$abogado->nombre}}
                                                                {{$abogado->apellido_paterno}}
                                                                {{$abogado->apellido_materno}}{{$abogado->razon_social}}
                                                            </option>

                                                            @endif
                                                            @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <label for="userName" class="col-sm-3 control-label">Tercero
                                                        interesado<span class="text-danger"></span></label>
                                                    <select class="form-control select2-multiple" name="terceros_aux[]"
                                                        id="terceros_aux" data-toggle="select2" style="width: 100%"
                                                        multiple="multiple"
                                                        data-placeholder="Seleccione una opción ...">
                                                        @foreach($personas as $tercero)
                                                        <option value="{{$tercero->id}}">{{$tercero->nombre}}
                                                            {{$tercero->apellido_paterno}}
                                                            {{$tercero->apellido_materno}}{{$tercero->razon_social}}
                                                        </option>
                                                        @endforeach

                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!--Fin del div oculto -->


                                    @if($expediente->tipo == "RAG")
                                    <div class="form-group" id='display_rag' style='display:block;'>
                                        @else
                                        <div class="form-group" id='display_rag' style='display:none;'>
                                            @endif


                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-7 ">

                                                        <label for="userName" class="col-sm-7 control-label">Presunto
                                                            responsable<span class="text-danger">*</span></label>
                                                        <select class="form-control select2-multiple "
                                                            style="width: 100%" name="presunto_resp_aux[]"
                                                            id="presunto_resp_aux" data-toggle="select2" multiple="multiple"
                                                            data-placeholder="Seleccione una opción ...">
                                                            @foreach($personas as $presunto_res)
                                                            <option value="{{$presunto_res->id}}">
                                                                {{$presunto_res->nombre}}
                                                                {{$presunto_res->apellido_paterno}}
                                                                {{$presunto_res->apellido_materno}}{{$presunto_res->razon_social}}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                    </div>


                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-7">

                                                        <label for="userName" class="col-sm-7 control-label">Autoridad
                                                            Investigadora<span class="text-danger">*</span></label>
                                                        <select class="form-control select2-multiple"
                                                            name="autoridad_inv_aux[]" id="autoridad_inv_aux"
                                                            data-toggle="select2" multiple="multiple"
                                                            data-placeholder="Seleccione una opción ..."
                                                            style="width: 100%" >
                                                            @foreach($personas as $autoridad_in)
                                                            <option value="{{$autoridad_in->id}}">
                                                                {{$autoridad_in->nombre}}
                                                                {{$autoridad_in->apellido_paterno}}
                                                                {{$autoridad_in->apellido_materno}}{{$autoridad_in->razon_social}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-7">

                                                        <label for="userName" class="col-sm-7 control-label">Autoridad
                                                            Sustanciadora<span class="text-danger">*</span></label>
                                                        <select class="form-control select2-multiple"
                                                            name="autoridad_sust_aux[]" id="autoridad_sust_aux"
                                                            data-toggle="select2" multiple="multiple"
                                                            data-placeholder="Seleccione una opción ..."
                                                            style="width: 100%" >
                                                            @foreach($personas as $autoridad_sus)
                                                            <option value="{{$autoridad_sus->id}}">
                                                                {{$autoridad_sus->nombre}}
                                                                {{$autoridad_sus->apellido_paterno}}
                                                                {{$autoridad_sus->apellido_materno}}{{$autoridad_sus->razon_social}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <label for="userName"
                                                            class="col-sm-7 control-label">Denunciante</label>
                                                        <select class="form-control select2-multiple"
                                                            name="denunciante_aux[]" id="denunciante_aux" data-toggle="select2"
                                                            style="width: 100%" multiple="multiple"
                                                            data-placeholder="Seleccione una opción ...">
                                                            @foreach($personas as $denunciante)
                                                            <option value="{{$denunciante->id}}">
                                                                {{$denunciante->nombre}}
                                                                {{$denunciante->apellido_paterno}}
                                                                {{$denunciante->apellido_materno}}{{$denunciante->razon_social}}
                                                            </option>
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <label for="userName" class="col-sm-8 control-label">Particular
                                                            vinculado con faltas administrativas graves <span
                                                                class="text-danger"></span></label>
                                                        <select class="form-control select2-multiple"
                                                            name="particular_aux[]" id="particular_aux" data-toggle="select2"
                                                            style="width: 100%" multiple="multiple"
                                                            data-placeholder="Seleccione una opción ...">
                                                            @foreach($personas as $particular_vinc)
                                                            <option value="{{$particular_vinc->id}}">
                                                                {{$particular_vinc->nombre}}
                                                                {{$particular_vinc->apellido_paterno}}
                                                                {{$particular_vinc->apellido_materno}}{{$particular_vinc->razon_social}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <label for="userName" class="col-sm-7 control-label">Tipo de
                                                            falta<span class="text-danger">*</span></label>
                                                        <select class="form-control" name="tipo_falta" id="tipo_falta"
                                                            data-toggle="select2" style="width: 100%"
                                                            data-placeholder="Seleccione una opción ...">
                                                            <option value="" selected>Seleccione una opción
                                                            </option>
                                                            @foreach($faltas as $falta)
                                                            @if($falta->id == $expediente->id_falta)
                                                            <option value="{{$falta->id}}" selected>{{$falta->tipo_falta}}
                                                            </option>
                                                            @else
                                                            <option value="{{$falta->id}}">{{$falta->tipo_falta}}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <!--Fin del div oculto -->





                                       
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <label for="userName" class="col-sm-3 control-label">Tipo de
                                                            Juicio<span class="text-danger">*</span></label>
                                                        <select class="form-control" name="id_juicio"
                                                            id="id_juicio" data-toggle="select2" style="width: 100%"                                                         
                                                            data-placeholder="Seleccione una opción ...">
                                                            @foreach($juicios as $juicio)
                                                            @if($juicio->id == $expediente->id_juicio)
                                                            <option value="{{$juicio->id}}" selected>
                                                                {{$juicio->tipo}}
                                                            </option>
                                                            @else
                                                            <option value="{{$juicio->id}}">
                                                                {{$juicio->tipo}}
                                                            </option>
                                                            @endif
                                                            @endforeach
                                                        </select>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <label for="userName">Observaciónes<span
                                                                class="text-danger"></span></label>
                                                        <textarea type="text" name="observaciones"
                                                            parsley-trigger="change" class="form-control"
                                                            value='{{$expediente->observaciones}}'
                                                            id="observaciones">{{$expediente->observaciones}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                       








                                        <div class="form-group" id='display_archivos' style='display:block;'>
                                            <div class="row">

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="userName">Fecha del expediente<span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control" type="date"
                                                            value="{{$expediente->fecha}}" name="fecha" id="fecha">
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="userName">Hojas de escrito<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" name="hojas_escrito"
                                                            id="hojas_escrito" value="{{$DetalleExp->hojas_escrito}}"
                                                            placeholder="Hojas de escrito (numérico)"
                                                            onmousewheel="this.blur();" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="userName">Número de anexos<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" onchange="anexos_hojas(this.value);"
                                                            class="form-control" value="{{$DetalleExp->num_anexos}}"
                                                            name="hojas_anexo" id="hojas_anexo" max="99"
                                                            placeholder="Número de anexos (numérico)"
                                                            onmousewheel="this.blur();" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-3">
                                                    <div class="form-group">
                                                        <label for="userName">Hojas de trasalado<span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" name="hojas_traslado"
                                                            id="hojas_traslado" value="{{$DetalleExp->hojas_traslados}}"
                                                            placeholder="Hojas de traslado (numérico)"
                                                            onmousewheel="this.blur();" required>
                                                    </div>
                                                </div>

                                            </div><!-- end row-->
                                            <div class="row" id="anexos_div">
                                                @foreach($escaneos as $anexo)
                                                <div class="col-lg-4">
                                                    <div class="card-box">
                                                        <h4 class="header-title mb-4">Anexo N° {{$anexo->num_anexo}}
                                                        </h4>
                                                        <select class="form-control mt-2 mb-2"
                                                            name="select{{$anexo->num_anexo}}"
                                                            id="select{{$anexo->num_anexo}}" data-toggle="select2"
                                                            style="width: 100%"
                                                            data-placeholder="Seleccione una opción ...">
                                                            @foreach($options as $option)
                                                            @if($option == $anexo->tipo)
                                                            <option value="{{$option}}" selected>{{$option}}</option>
                                                            @else
                                                            <option value="{{$option}}">{{$option}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>

                                                        <select class="form-control mt-2 mb-2"
                                                            name="select2{{$anexo->num_anexo}}"
                                                            id="select2{{$anexo->num_anexo}}" data-toggle="select2"
                                                            style="width: 100%"
                                                            data-placeholder="Seleccione una opción ...">
                                                            @foreach($options2 as $option)
                                                            @if($option == $anexo->forma)
                                                            <option value="{{$option}}" selected>{{$option}}</option>
                                                            @else
                                                            <option value="{{$option}}">{{$option}}</option>
                                                            @endif
                                                            @endforeach
                                                        </select>

                                                        <input type="file" name="input{{$anexo->num_anexo}}"
                                                            id="input{{$anexo->num_anexo}}" accept=".pdf"
                                                            name="escaneo_escrito{{$anexo->id}}" class="dropify"
                                                            data-default-file="{{$anexo->escaneo_anexos}}"
                                                            data-max-file-size="3M"
                                                            value="{{$anexo->escaneo_anexos}}" />

                                                    </div>
                                                </div><!-- end col -->
                                                @endforeach

                                            </div>



                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="card-box">

                                                        <h4 class="header-title mb-4">Escaneo escrito</h4>

                                                        <input type="file" accept=".pdf" id="escaneo_escrito"
                                                            name="escaneo_escrito"
                                                            data-default-file="{{$DetalleExp->escaneo_escrito}}"
                                                            value="{{$DetalleExp->escaneo_escrito}}" class="dropify"
                                                            data-max-file-size="3M" />
                                                    </div>
                                                </div><!-- end col -->

                                            </div>

                                        </div><!-- end div archivos -->

                                    </div>


                                    <div class="form-group text-right mb-0">
                                        <button class="btn btn-primary waves-effect waves-light mr-1" id="submit"
                                            type="submit">
                                            Guardar
                                        </button>
                                        <button type="reset" class="btn btn-secondary waves-effect">
                                            Cancelar
                                        </button>
                                    </div>

    </form>
</div> <!-- end container-fluid -->



@stop

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $('.dropify').dropify();
    id = '{{ $expediente->id }}';  
    traerExpediente(id, 'edit');
});

$('.submit_button').click(function () {
           
           Swal.fire({
               title: 'Estas seguro de guardar cambios?',
               icon: 'question',
               showDenyButton: true,
               showCancelButton: true,
               confirmButtonText: `Si`,
               denyButtonText: `No`,
             }).then((result) => {
               /* Read more about isConfirmed, isDenied below */
               if (result.isConfirmed) {
       
                 let fmr =  document.getElementById("form");
                 const submitFormFunction = Object.getPrototypeOf(fmr).submit ;
                 submitFormFunction.call(form);
                 Swal.fire('Guardado!', '', 'success')
               } else if (result.isDenied) {
                 Swal.fire('Cancelado', '', 'info')
               }
             })
              
       });
</script>
@endsection