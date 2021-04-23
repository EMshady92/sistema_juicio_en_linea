@extends('layouts.principal')
@section('contenido')
<script src="https://www.google.com/recaptcha/api.js"></script>

<!-- Start Content-->

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/">Firmas electrónicas</a></li>
                        <li class="breadcrumb-item active">Validar firmas</li>
                    </ol>
                </div>
                <h4 class="page-title">Firmar documentos con firma electrónica</h4>
            </div>
        </div>
    </div>

    <!-- end page title -->

    @include('firmaDocumentos.modal_loading')
    @include('users.modalPassword')

    <form id="wizard-validation-form" action="guardardocFirmado" name="formulario"
        onsubmit="return valida_envio_firma();recorre_tabla();" method="post" files="true"
        enctype="multipart/form-data">

        {{csrf_field()}}
        <div>
            <h3>Documento a firmar</h3>
            <section>
                <div class="row">
                    <div class="col-12 mr-auto mr-4 mb-4">
                        <div class="col-lg-6">
                            <div class="card-box">
                                <h4 class="header-title mb-6" id='escanesc'>Documento a firmar .docx</h4>
                                <input type="file" accept=".docx" id="doc" value="{{old('doc')}}" name="doc"
                                    class="dropify" required data-max-file-size="10M" />
                            </div>
                        </div>
                    </div>


                    <div class="col-3 mr-auto mr-4 mb-4">
                        <div class="form-group">
                            <label for="userName">Tipo de documento<span class="text-danger">*</span></label>
                            <select class="form-control" style="width: 100%" onchange="tipo_documento(this.value);"
                                name="tipoDocumento" id="tipoDocumento" required
                                data-placeholder="Seleccione una opción ...">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach($tipo_documentos as $tipo)
                                <option value="{{$tipo->tipo_documento}}">
                                    {{$tipo->tipo_documento}}
                                </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div>

                        
                        <div class="form-group">
                            <label for="userName">Tipo de expediente<span class="text-danger">*</span></label>
                            <select class="form-control" style="width: 100%" name="tipoExpediente" id="tipoExpediente"
                                required data-placeholder="Seleccione una opción ...">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach($tipo_exp as $tipo_exp)
                                <option value="{{$tipo_exp}}">
                                    {{$tipo_exp}}
                                </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div>                       
                    </div>


                    <div class="col-3 mr-auto mr-4 mb-4">
                        <div class="form-group">
                            <label for="userName">Tipo de juicio<span class="text-danger">*</span></label>
                            <select class="form-control" style="width: 100%" name="tipoJuicio" id="tipoJuicio" required
                                data-placeholder="Seleccione una opción ...">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach($tipo_juicio as $tipo_juicio)
                                <option value="{{$tipo_juicio->tipo}}">
                                    {{$tipo_juicio->tipo}}
                                </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div>
                        <div class="form-group">
                            <label for="contestacion">Número de expediente<span class="text-danger">*</span></label>
                            <input type="text" name="num_exp" parsley-trigger="change" required
                                placeholder="Ingrese el número de expediente" value="TJA/000/2021-P"
                                class="form-control" id="num_exp">
                        </div>
                    </div>
                    <div class="col-4 mr-auto mr-4 mb-4">
                    <div class="form-group" id='display_acuerdo' style='display:none;'>
                            <div class="form-group">
                                <label for="userName">Tipo de acuerdo<span class="text-danger">*</span></label>
                                <select class="form-control" style="width: 100%" onchange="tipo_documento(this.value);"
                                    name="tipoAcuerdo" id="tipoAcuerdo" required
                                    data-placeholder="Seleccione una opción ...">
                                    <option value="" selected>Seleccione una opción</option>
                                    @foreach($tipos_acuerdos as $tipo_acuerdo)
                                    <option value="{{$tipo_acuerdo->tipo}}">
                                        {{$tipo_acuerdo->tipo}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                            </div>


                            <div class="form-group">
                                <label for="userName">Actores<span class="text-danger">*</span></label>
                                <div class="tags-default">
                                    <input name="actores[]" id="actores" type="text" value="" data-role="tagsinput" placeholder="Agregar actores" />
                                </div>
                            </div>
                        </div>
                        </div>
                 
                        <div class="col-4 mr-auto mr-4 mb-4">
                        <div class="form-group" id='display_sentencia' style='display:none;'>
                            <div class="form-group">
                                <label for="userName">Sala<span class="text-danger">* </span></label>
                                <select class="form-control" style="width: 100%" name="sala" id="sala"
                                    onchange="traerMagistradoSala(this.value)" required
                                    data-placeholder="Seleccione una opción ...">
                                    <option value="" selected>Seleccione una opción</option>
                                    @foreach($salas as $sala)
                                    <option value="{{$sala->id}}">
                                        {{$sala->num_sala}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                            </div>
                            <div class="form-group">
                                <label for="userName">Proyectista<span class="text-danger">* </span></label>
                                <select class="form-control" style="width: 100%" name="proyectista" id="proyectista"
                                    required data-placeholder="Seleccione una opción ...">
                                    <option value="" selected>Seleccione una opción</option>
                                    @foreach($proyectistas as $proyectista)
                                    @if($proyectista->funcion == "PROYECTISTA" || $proyectista->funcion == "SECRETARIO AUXILIAR" ||
                                    $proyectista->funcion == "SECRETARIA GENERAL DE ACUERDOS" )
                                    <option value="{{$proyectista->name}} {{$proyectista->apellido_p}} {{$proyectista->apellido_m}}">
                                        {{$proyectista->funcion}} {{$proyectista->name}} {{$proyectista->apellido_p}} {{$proyectista->apellido_m}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                            </div>

                            <div class="form-group col-12">
                            <label for="contestacion">Ponente<span class="text-danger">*</span></label>
                            <input type="text" id="ponente" value="" name="ponente" required placeholder="Nombre del ponente"
                                onkeypress="return caracteres(event)" class="form-control" readonly>
                        </div>
                        </div>                       
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mr-auto mr-6 mb-6">
                        <div class="form-group">
                            <label for="userName">Agregar firmantes<span class="text-danger">* (En el orden deseado
                                    para
                                    su firma)</span></label>
                            <select class="form-control" style="width: 100%" name="firmantes" id="firmantes" required
                                data-placeholder="Seleccione una opción ...">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach($users as $user)
                                @if($user->sexo == "FEMENINO" && $user->funcion == "MAGISTRADO")
                                <option value="{{$user->id}}">
                                    MAGISTRADA: {{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}
                                </option>
                                @else
                                <option value="{{$user->id}}">
                                    {{$user->funcion}}: {{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}
                                </option>
                                @endif
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div>
                        <div class="form-group">
                            <a class="btn waves-effect btn-secondary"
                                onclick="llenar_firmante();recorre_tabla();">Agregar </a>
                        </div>
                        <div class="porlets-content">
                            <div class="table-responsive">
                                <table class="display table table-bordered table-striped" name="detalles[]"
                                    id="detalles" id="dynamic-table">
                                    <thead>
                                        <tr>
                                            <th>Eliminar </th>
                                            <th>Número de firma </th>
                                            <th>Usuario </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>

                            </div>
                            <!--/porlets-content-->
                        </div>
                        <!--/block-web-->
                    </div>
                </div>
                <input id="array" name="array[]" type="hidden">
            </section>

        </div>
    </form>
</div> <!-- end container-fluid -->
@stop

@section('javascript')

<script type="text/javascript">
$(document).ready(function() {
    $(".select2-multiple").select2({
        width: '100%'
    });
    $('.select2-multiple').val(null).trigger('change');
});


//OCULTAR Y MOSTRAR EL INPUT DE PROMOCIONES EN LOS ACUERDOS

function cambia_display_documento(value) {
    if (value == "pegar") {
        document.getElementById('display_pegar').style.display = 'block';
        document.getElementById('display_subir').style.display = 'none';
        document.getElementById('redactar').required = true;
        document.getElementById('doc').required = false;
    } else {
        document.getElementById('display_pegar').style.display = 'none';
        document.getElementById('display_subir').style.display = 'block';
        document.getElementById('redactar').required = false;
        document.getElementById('doc').required = true;
    }

}
</script>

@endsection