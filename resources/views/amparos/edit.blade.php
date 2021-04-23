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
                <h4 class="page-title">Editar {{$expediente->tipo}}: {{$expediente->num_expediente}}</h4>

            </div>



        </div>
    </div>
    <!-- end page title -->
    <form action="{{url('/amparos_promociones', [$expediente->id])}}" id="form" method="post" files="true"
        enctype="multipart/form-data" class="form-horizontal parsley-examples">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">



        <div class="form-group">
            <div class="row">
                <div class="col-lg-7">
                    <label for="userName" class="col-sm-4 control-label">Expediente
                        <span class="text-danger"></span></label>
                    <select class="form-control" style="width: 100%" name="expediente" id="expediente"
                        data-toggle="select2" data-placeholder="Seleccione una opción ...">
                        <option value="">Seleccione una opción</option>
                        @foreach($expedientes as $expediente_aux)
                        @if($expediente_aux->id == $expediente->id_expediente)
                        <option value="{{$expediente_aux->id}}" selected>{{$expediente_aux->num_expediente}}</option>
                        @else
                        <option value="{{$expediente_aux->id}}">{{$expediente_aux->num_expediente}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="col-6 mr-auto mr-4 mb-4">
            <label for="userName">Tipo de ingreso<span class="text-danger">*</span></label>
            <select class="form-control" style="width: 100%" name="tipoIngreso"
                data-placeholder="Seleccione una opción ..." id="tipoIngreso" required data-toggle="select2">
                @if($expediente->tipo == "AMPARO")
                <option value="">Seleccione una opción</option>
                <option value="AMPARO" selected>Amparo </option>
                <<option value="PROMOCION">Promoción</option>
                    @else
                    <option value="" selected>Seleccione una opción</option>
                    <option value="AMPARO">Amparo</option>
                    <option value="PROMOCION" selected>Promoción</option>
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

                                <div class="form-group" id='display_archivos' style='display:block;'>
                                    <div class="row">

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="userName">Fecha del expediente<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="date" value="{{$expediente->fecha}}"
                                                    name="fecha" id="fecha">
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="userName">Hojas de escrito<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="hojas_escrito"
                                                    id="hojas_escrito" value="{{$expediente->hojas_escrito}}"
                                                    placeholder="Hojas de escrito (numérico)"
                                                    onmousewheel="this.blur();" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label for="userName">Número de anexos<span
                                                        class="text-danger">*</span></label>
                                                <input type="number" onchange="anexos_hojas(this.value);"
                                                    class="form-control" value="{{$expediente->num_anexos}}"
                                                    name="hojas_anexo" id="hojas_anexo" min="0" max="99"
                                                    placeholder="Hojas de anexo (numérico)" onmousewheel="this.blur();"
                                                    required>
                                            </div>
                                        </div>



                                    </div><!-- end row-->
                                    <div class="row" id="anexos_div">
                                        @foreach($escaneos as $anexo)
                                        <div class="col-lg-4">
                                            <div class="card-box">
                                                <h4 class="header-title mb-4">Anexo N° {{$anexo->num_anexo}}</h4>
                                                <select class="form-control mt-2 mb-2"
                                                    name="select{{$anexo->num_anexo}}" id="select{{$anexo->num_anexo}}"
                                                    data-toggle="select2" style="width: 100%"
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
                                                    style="width: 100%" data-placeholder="Seleccione una opción ...">
                                                    @foreach($options2 as $option)
                                                    @if($option == $anexo->forma)
                                                    <option value="{{$option}}" selected>{{$option}}</option>
                                                    @else
                                                    <option value="{{$option}}">{{$option}}</option>
                                                    @endif
                                                    @endforeach
                                                </select>
                                                <label for="userName">Hojas del anexo<span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control mt-2 mb-2" required
                                                    name="input2{{$anexo->num_anexo}}" id="input2{{$anexo->num_anexo}}"
                                                    type="number" min="1" max="99" value="{{$anexo->num_hojas}}"
                                                    placeholder="Hojas del anexo (numérico)"
                                                    onmousewheel="this.blur();">



                                                <input type="file" name="input{{$anexo->num_anexo}}"
                                                    id="input{{$anexo->num_anexo}}" accept=".pdf"
                                                    name="escaneo_escrito{{$anexo->id}}" class="dropify"
                                                    data-default-file="{{$anexo->escaneo_anexos}}"
                                                    data-max-file-size="3M" value="{{$anexo->escaneo_anexos}}" />

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
                                                    data-default-file="{{$expediente->escaneo_escrito}}"
                                                    value="{{$expediente->escaneo_escrito}}" class="dropify"
                                                    data-max-file-size="3M" />
                                            </div>
                                        </div><!-- end col -->

                                    </div>

                                </div><!-- end div archivos -->

                            </div>


                            <div class="form-group text-right mb-0">
                                <button class="btn btn-primary waves-effect waves-light mr-1" id="submit" type="submit">
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
</script>
@endsection