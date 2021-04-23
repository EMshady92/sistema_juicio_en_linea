@extends('layouts.principal')
@section('contenido')
<!-- Start Content-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/expedientes">Expedientes</a></li>
                        <li class="breadcrumb-item active">Nuevo ingreso</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo ingreso</h4>

            </div>
            @include('expedientes.modal')



        </div>
    </div>
    <!-- end page title -->
    <form action="{{route('expedientes.store')}}" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="col-6 mr-auto mr-4 mb-4">
            <label for="userName">Tipo de ingreso<span class="text-danger">*</span></label>
            <select class="form-control" style="width: 100%" name="tipoIngreso"
                onchange="mostrar_datos_inicio(this.value);changeescaneo(this.value);"
                data-placeholder="Seleccione una opción ..." id="tipoIngreso" required data-toggle="select2">
                <option value="" selected>Seleccione una opción</option>
                <option value="NULIDAD">Demanda de nulidad </option>
                <option value="RAG">RAG</option>
                <option value="AMPARO">Amparo</option>
                <option value="PROMOCION">Promoción</option>
                <option value="GENERALIDAD">Generalidad (Otros)</option>
            </select>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <h4 class="header-title">Formulario de registro</h4>
                                <p class="sub-header">
                                    Formulario para registrar nuevos ingresos.
                                </p>

                                <div class="form-group" id='display_nuevo' style='display:none;'>


                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-7 ">

                                                <label for="userName" class="col-sm-3 control-label">Actor<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control select2-multiple " style="width: 100%"
                                                    name="actor[]" id="actor" data-toggle="select2" multiple="multiple"
                                                    data-placeholder="Seleccione una opción ..." required>
                                                    @foreach($personas as $actor)
                                                    <option value="{{$actor->id}}">{{$actor->nombre}}
                                                        {{$actor->apellido_paterno}}
                                                        {{$actor->apellido_materno}}{{$actor->razon_social}}
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
                                                <select class="form-control select2-multiple" name="demandado[]"
                                                    id="demandado" data-toggle="select2" multiple="multiple"
                                                    data-placeholder="Seleccione una opción ..." style="width: 100%"
                                                    required>
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
                                                        class="text-danger">*</span></label>
                                                <select class="form-control select2-multiple" name="abogado[]"
                                                    id="abogado" data-toggle="select2" style="width: 100%"
                                                    multiple="multiple" data-placeholder="Seleccione una opción ...">
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
                                                <select class="form-control select2-multiple" name="tercero[]"
                                                    id="tercero" data-toggle="select2" style="width: 100%"
                                                    multiple="multiple" data-placeholder="Seleccione una opción ...">
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

                                <div class="form-group" id='display_rag' style='display:none;'>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-7 ">

                                                <label for="userName" class="col-sm-7 control-label">Presunto
                                                    responsable<span class="text-danger">*</span></label>
                                                <select class="form-control select2-multiple " style="width: 100%"
                                                    name="presunto_resp[]" id="presunto_resp" data-toggle="select2"
                                                    multiple="multiple" data-placeholder="Seleccione una opción ...">
                                                    @foreach($personas as $presunto_res)
                                                    <option value="{{$presunto_res->id}}">{{$presunto_res->nombre}}
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
                                                <select class="form-control select2-multiple" name="autoridad_inv[]"
                                                    id="autoridad_inv" data-toggle="select2" multiple="multiple"
                                                    data-placeholder="Seleccione una opción ..." style="width: 100%"
                                                    required>
                                                    @foreach($personas as $autoridad_in)
                                                    <option value="{{$autoridad_in->id}}">{{$autoridad_in->nombre}}
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
                                                <select class="form-control select2-multiple" name="autoridad_sust[]"
                                                    id="autoridad_sust" data-toggle="select2" multiple="multiple"
                                                    data-placeholder="Seleccione una opción ..." style="width: 100%"
                                                    required>
                                                    @foreach($personas as $autoridad_sus)
                                                    <option value="{{$autoridad_sus->id}}">{{$autoridad_sus->nombre}}
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
                                                <label for="userName" class="col-sm-7 control-label">Denunciante</label>
                                                <select class="form-control select2-multiple" name="denunciante[]"
                                                    id="denunciante" data-toggle="select2" style="width: 100%"
                                                    multiple="multiple" data-placeholder="Seleccione una opción ...">
                                                    @foreach($personas as $denunciante)
                                                    <option value="{{$denunciante->id}}">{{$denunciante->nombre}}
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
                                                <select class="form-control select2-multiple" name="particular[]"
                                                    id="particular" data-toggle="select2" style="width: 100%"
                                                    multiple="multiple" data-placeholder="Seleccione una opción ...">
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
                                                <label for="userName" class="col-sm-7 control-label">Tipo de falta<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="tipo_falta" id="tipo_falta"
                                                    data-toggle="select2" style="width: 100%"
                                                    data-placeholder="Seleccione una opción ...">
                                                    <option value="" selected>Seleccione una opción
                                                    </option>
                                                    @foreach($faltas as $falta)
                                                    <option value="{{$falta->id}}">{{$falta->tipo_falta}}
                                                    </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!--Fin del div oculto -->

                                <div class="form-group" id='display_amparo' style='display:none;'>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <label for="userName" class="col-sm-6 control-label">Seleccione un
                                                    expediente
                                                    <span class="text-danger"></span></label>
                                                <select class="form-control" style="width: 100%" name="expediente"
                                                    id="expediente" data-toggle="select2"
                                                    data-placeholder="Seleccione una opción ..."
                                                    onchange="traerExpediente(this.value,'cr');">
                                                    <option value="" selected>Seleccione una opción</option>
                                                    @foreach($expedientes as $expediente)

                                                    <option value="{{$expediente->id}}">{{$expediente->num_expediente}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group" id='display_info' style='display:none;'>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="card-box">
                                                    <h4 class="header-title">Información del expediente</h4>
                                                    <div class="table-responsive">
                                                        <table class="table table-borderless mb-0">
                                                            
                                                                <tr>
                                                                    <th>Actores: </th>
                                                                    <td id="num_exp"> <select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="actor_aux[]"
                                                                            id="actor_aux" data-toggle="select2"
                                                                            multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th>Demandados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="demandados_aux[]"
                                                                            id="demandados_aux" data-toggle="select2"
                                                                            multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Abogados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="abogados_aux[]"
                                                                            id="abogados_aux" data-toggle="select2"
                                                                            multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th>Terceros Interesados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="terceros_aux[]"
                                                                            id="terceros_aux" data-toggle="select2"
                                                                            multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                          
                                                                <tr class="bg-light text-dark">
                                                                    <th>Presunto responsable: </th>
                                                                    <td id="num_exp"> <select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="presunto_resp_aux[]"
                                                                            id="presunto_resp_aux" data-toggle="select2"
                                                                            multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-white text-dark">
                                                                    <th>Autoridad Investigadora: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="autoridad_inv_aux[]"
                                                                            id="autoridad_inv_aux" data-toggle="select2"
                                                                            multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th>Autoridad Sustanciadora: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="autoridad_sust_aux[]"
                                                                            id="autoridad_sust_aux"
                                                                            data-toggle="select2" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr lass="bg-white text-dark">
                                                                    <th>Denunciante: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="denunciante_aux[]"
                                                                            id="denunciante_aux" data-toggle="select2"
                                                                            multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>

                                                                <tr lass="bg-white text-dark">
                                                                    <th>Particular vinculado con faltas administrativas
                                                                        graves: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="particular_aux[]"
                                                                            id="particular_aux" data-toggle="select2"
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
                                                            <tr class="bg-light text-dark">
                                                                <th scope="row">Número de expediente : </th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="num_expediente[]"
                                                                        id="num_expediente" data-toggle="select2"
                                                                        multiple="multiple" disabled>

                                                            </tr>
                                                            <tr class="bg-white text-dark">
                                                                <th>Tipo:</th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="tipo_aux[]"
                                                                        id="tipo_aux" data-toggle="select2"
                                                                        multiple="multiple" disabled>

                                                                    </select></td>
                                                            </tr>
                                                            <tr class="bg-light text-dark">
                                                                <th>Fecha: </th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="fecha_aux[]"
                                                                        id="fecha_aux" data-toggle="select2"
                                                                        multiple="multiple" disabled>

                                                                    </select></td>
                                                            </tr>
                                                            <tr class="bg-white text-dark">
                                                                <th>Ultima actualización:</th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="ultima_ac[]"
                                                                        id="ultima_ac" data-toggle="select2"
                                                                        multiple="multiple" disabled>

                                                                    </select></td>
                                                            </tr>
                                                            <tr class="bg-light text-dark">
                                                                <th scope="row">Fecha de captura : </th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="fecha_captura[]"
                                                                        id="fecha_captura" data-toggle="select2"
                                                                        multiple="multiple" disabled>

                                                            </tr>
                                                            <tr class="bg-white text-dark">
                                                                <th>Modificado por: </th>
                                                                <td id="num_exp"><select
                                                                        class="form-control select2-multiple "
                                                                        style="width: 100%" name="modificado[]"
                                                                        id="modificado" data-toggle="select2"
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
                                    </div>
                                    <!--Fin del div info -->
                                </div>
                                <!--Fin del div oculto -->
                                <div class="form-group" id='display_obs' style='display:none;'>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <label for="userName" class="col-sm-3 control-label">Tipo de Juicio<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="id_juicio"
                                                    id="id_juicio" data-toggle="select2" style="width: 100%"
                                                    multiple="multiple" data-placeholder="Seleccione una opción ...">
                                                    @foreach($juicios as $juicio)
                                                    <option value="{{$juicio->id}}">
                                                        {{$juicio->tipo}}
                                                    </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <label for="userName">Observaciones<span
                                                        class="text-danger"></span></label>
                                                <textarea type="text" name="observaciones" parsley-trigger="change"
                                                    class="form-control" id="observaciones"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group" id='display_archivos' style='display:none;'>
                                    <div class="row">

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="userName">Fecha del expediente<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="date" value="{{$date}}" id="fecha"
                                                    name="fecha">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="userName">Hojas de escrito<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="hojas_escrito"
                                                    id="hojas_escrito" placeholder="Hojas de escrito (numérico)"
                                                    onmousewheel="this.blur();" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="userName">Número de anexos<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" onchange="anexos_hojas(this.value);"
                                                    class="form-control" name="hojas_anexo" id="hojas_anexo" max="99"
                                                    placeholder="Número de anexos (numérico)"
                                                    onmousewheel="this.blur();">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="userName">Hojas de trasalado<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="hojas_traslado"
                                                    id="hojas_traslado" placeholder="Hojas de traslado (numérico)"
                                                    onmousewheel="this.blur();">
                                            </div>
                                        </div>

                                    </div><!-- end row-->
                                    <div class="row" id="anexos_div">

                                    </div>



                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card-box">

                                                <h4 class="header-title mb-4" id='escanesc'>Escaneo escrito</h4>

                                                <input type="file" accept=".pdf" id="escaneo_escrito" required=""
                                                    name="escaneo_escrito" class="dropify" data-max-file-size="3M" />
                                            </div>
                                        </div><!-- end col -->

                                    </div>

                                </div><!-- end div archivos -->

                            </div>


                            <div class="form-group text-right mb-0">
                                <button class="btn btn-primary waves-effect waves-light mr-1" id="submit" name='submit_button' type="submit">
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


       
$(document).keydown(function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 116)  {
            e.preventDefault();
            confirm('Si recarga la página perdera todos los datos ingresados, ¿Deseas recargar la página?', function (result) {
                if (result) {
                    location.reload();
                } else {
                    recargar = false;
                }
            });
        }
    });

    /* function deshabilitaRetroceso(){
    window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button" //chrome
    window.onhashchange=function(){window.location.hash="";}
    console.log('retroceso desactivado');
} */

history.forward(1);   
</script>
@endsection