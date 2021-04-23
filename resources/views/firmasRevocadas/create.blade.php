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
                        <li class="breadcrumb-item"><a href="/revocarDocumentos">Cancelar documentos</a></li>
                        <li class="breadcrumb-item active">Cancelar documentos</li>
                    </ol>
                </div>
                <h4 class="page-title">Cancelar nuevo documento</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->


    @include('users.modalPassword')
    <div class="row">
        <div class="col-12">
            <div class="card-box">
            @if($firmas_act)
                <div class="row">
                    <div class="col-lg-12">
                        <div>
                            <h4 class="header-title">Formulario de registro</h4>
                            <p class="sub-header">
                                Formulario para cancelar documentos.
                            </p>




                            <form action="{{route('revocarDocumentos.store')}}"
                                onsubmit="return valida_envio_firma('formulario_firma');" method="post"
                                id="formulario_firma" name="formulario" class="form-horizontal parsley-examples">
                                {{csrf_field()}}




                             
                                <div class="form-group">
                                    <label for="userName">Seleccione la clave alfanumerica del documento<span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" data-toggle="select2" name="clave" id="clave"
                                        data-placeholder="Seleccione una opción ..."
                                        onchange="traerAsignacionFirma(this.value)" ; style="width: 100%" required>
                                        <option value="" selected>Seleccione una opción...</option>
                                        @foreach($firmas_act as $firma)
                                        <option value="{{$firma->num_asignacion}}">{{$firma->clave_alfanumerica}}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger" id='error_usuario' name="error_usuario"></div>
                                </div>
                                <div class="form-group" id='display_revocar' style='display:none;'>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card-box">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless mb-0">




                                                        <tr class="bg-light text-dark">
                                                            <th>Número de expediente:</th>
                                                            <td><select class="form-control" style="width: 100%"
                                                                    name="num_exp" id="num_exp" data-toggle="select2"
                                                                    multiple="multiple" disabled>
                                                                    <option selected>

                                                                    </option>
                                                                </select></td>

                                                        </tr>

                                                        <tr class="bg-light text-dark">
                                                            <th>Número de folio:</th>
                                                            <td><select class="form-control" style="width: 100%"
                                                                    name="folio" id="folio" data-toggle="select2"
                                                                    multiple="multiple" disabled>
                                                                    <option selected>

                                                                    </option>
                                                                </select></td>

                                                        </tr>


                                                        <tr class="bg-light text-dark">
                                                            <th>Clave alfanumerica:</th>
                                                            <td><select class="form-control" style="width: 100%"
                                                                    name="clave_alfa" id="clave_alfa"
                                                                    data-toggle="select2" multiple="multiple" readonly>
                                                                    <option selected>

                                                                    </option>
                                                                </select></td>

                                                        </tr>


                                                        <tr class="bg-light text-dark">
                                                            <th>Tipo de documento:</th>
                                                            <td><select class="form-control" style="width: 100%"
                                                                    name="tipo_doc" id="tipo_doc" data-toggle="select2"
                                                                    multiple="multiple" disabled>
                                                                    <option selected>

                                                                    </option>
                                                                </select></td>

                                                        </tr>

                                                        <tr class="bg-light text-dark">
                                                            <th>Tipo de expediente:</th>
                                                            <td><select class="form-control" style="width: 100%"
                                                                    name="tipo_exp" id="tipo_exp" data-toggle="select2"
                                                                    multiple="multiple" disabled>
                                                                    <option selected>

                                                                    </option>
                                                                </select></td>

                                                        </tr>

                                                        <tr class="bg-light text-dark">
                                                            <th>Tipo de juicio:</th>
                                                            <td><select class="form-control" style="width: 100%"
                                                                    name="tipo_juicio" id="tipo_juicio"
                                                                    data-toggle="select2" multiple="multiple" disabled>
                                                                    <option selected>

                                                                    </option>
                                                                </select></td>

                                                        </tr>


                                                        <tr class="bg-white text-dark">
                                                            <th>Ver documento a firmar: </th>
                                                            <td id="hojas_anexos">

                                                                <div class="mb-2">
                                                                    <a href="../public/DOCUMENTOSPARAFIRMA/" name="doc"
                                                                        id="doc"
                                                                        class="btn btn-outline-danger waves-effect waves-light"
                                                                        role="button">
                                                                        <i class="mdi mdi-xml"> Ver .docx</i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="card-box">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless mb-0">


                                                        <tr class="bg-white text-dark">
                                                            <th>Nombre del solicitante: </th>
                                                            <td><select class="form-control " style="width: 100%"
                                                                    name="propietario" id="propietario"
                                                                    data-toggle="select2" multiple="multiple" disabled>

                                                                    <option selected>

                                                                    </option>

                                                                </select></td>
                                                        </tr>


                                                        <tr class="bg-white text-dark">
                                                            <th>Ponente: </th>
                                                            <td><select class="form-control " style="width: 100%"
                                                                    name="ponente" id="ponente" data-toggle="select2"
                                                                    multiple="multiple" disabled>

                                                                    <option selected>

                                                                    </option>

                                                                </select></td>
                                                        </tr>


                                                        <tr class="bg-white text-dark">
                                                            <th>Proyectista: </th>
                                                            <td><select class="form-control " style="width: 100%"
                                                                    name="proyectista" id="proyectista"
                                                                    data-toggle="select2" multiple="multiple" disabled>

                                                                    <option selected>

                                                                    </option>

                                                                </select></td>
                                                        </tr>


                                                        <tr class="bg-light text-dark">
                                                            <th>Generado por : </th>
                                                            <td><select class="form-control" style="width: 100%"
                                                                    name="captura" id="captura" data-toggle="select2"
                                                                    multiple="multiple" disabled>

                                                                    <option value="" selected>

                                                                    </option>
                                                                </select></td>

                                                        </tr>

                                                        <tr class="bg-white text-dark">
                                                            <th>Fecha de captura:</th>
                                                            <td id="num_exp2"><select class="form-control "
                                                                    style="width: 100%" name="created" id="created"
                                                                    data-toggle="select2" multiple="multiple" disabled>

                                                                    <option selected>

                                                                    </option>

                                                                </select></td>
                                                        </tr>

                                                        <tr class="bg-light text-dark">
                                                            <th>Ultima actualización: </th>
                                                            <td> <select class="form-control s " style="width: 100%"
                                                                    name="updated" id="updated" data-toggle="select2"
                                                                    multiple="multiple" disabled>
                                                                    <option selected>

                                                                    </option>

                                                                </select></td>
                                                        </tr>

                                                          
                                                        <tr class="bg-light text-dark">
                                                            <th>Estado del documento: </th>
                                                            <td> <select class="form-control " style="width: 100%"
                                                                    name="estado" id="estado" data-toggle="select2"
                                                                    multiple="multiple" disabled>
                                                                    <option selected>

                                                                    </option>

                                                                </select></td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>




                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card-box">
                                                <h4 class="header-title">Firmas necesarias</h4>
                                                <div class="form-group" class="table-responsive">
                                                    <table id="datatable"
                                                        class="table table-bordered dt-responsive nowrap"
                                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Función</th>
                                                                <th>Estado de la firma</th>
                                                                <th>Fecha y hora</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>



                                            </div>

                                        </div>

                                    </div>


                                    <div class="form-group">
                                        <label for="userName">Motivo de la cancelación<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control" type="text" value="{{old('password')}}" required=""
                                            name="motivo" id="motivo" placeholder="Ingresa el motivo de la cancelación">
                                    </div>



                                    <div class="form-group text-right mb-0">
                                        <button class="btn btn-primary waves-effect waves-light mr-1" id="btnSubmit"
                                            type="submit">
                                            Guardar
                                        </button>
                                        <button type="reset" class="btn btn-secondary waves-effect">
                                            Cancelar
                                        </button>
                                    </div>

                                </div>
                                @else
                                <div class="alert alert-warning" role="alert">
                        <strong>Lo sentimos!</strong> No hay documentos que cumplan con los requisitos para su cancelación.
                    </div>
                                @endif
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div> <!-- end row -->








</div> <!-- end container-fluid -->
@stop