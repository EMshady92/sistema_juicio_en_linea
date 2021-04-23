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
                        <li class="breadcrumb-item"><a href="/misFirmas">Mis Firmas electrónicas</a></li>
                        <li class="breadcrumb-item active">Firmar documento asignado</li>
                    </ol>
                </div>
                <h4 class="page-title">Firmar documento </h4>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="/firmarAsignaciones/{{$firma->id}}" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">Datos del documento:</h4>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">




                                        <tr class="bg-light text-dark">
                                            <th>Número de expediente:</th>
                                            <td><select class="form-control" style="width: 100%" name="nombre"
                                                    id="nombre" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->num_expediente}}
                                                    </option>
                                                </select></td>

                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Tipo de documento:</th>
                                            <td><select class="form-control" style="width: 100%" name="email" id="email"
                                                    data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->tipo_documento}}
                                                    </option>
                                                </select></td>

                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Tipo de expediente:</th>
                                            <td><select class="form-control" style="width: 100%" name="puesto"
                                                    id="puesto" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->tipo_expediente}}
                                                    </option>
                                                </select></td>

                                        </tr>
                                        
                                        
                                        <tr class="bg-white text-dark">
                                            <th>Ver documento a firmar: </th>
                                            <td id="hojas_anexos">

                                                <div class="mb-2">
                                                    <a href="../public/DOCUMENTOSPARAFIRMA/{{$firma->docx}}"
                                                        download="{{$firma->docx}}"
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
                                            <td><select class="form-control " style="width: 100%" name="serial"
                                                    id="serial" data-toggle="select2" multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$firma->name}} {{$firma->apellido_p}} {{$firma->apellido_m}}
                                                    </option>

                                                </select></td>
                                        </tr>


                                        <tr class="bg-light text-dark">
                                            <th>Generado por : </th>
                                            <td><select class="form-control" style="width: 100%" name="captura"
                                                    id="captura" data-toggle="select2" multiple="multiple" disabled>

                                                    <option value="{$amparo->captura}}" selected>
                                                        {{$firma->captura}}
                                                    </option>
                                                </select></td>

                                        </tr>




                                        <tr class="bg-white text-dark">
                                            <th>Fecha de captura:</th>
                                            <td id="num_exp2"><select class="form-control " style="width: 100%"
                                                    name="created_amparo" id="created_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$firma->created_at}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Ultima actualización: </th>
                                            <td> <select class="form-control s " style="width: 100%"
                                                    name="updated_amparo[]" id="updated_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->updated_at}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Número de asignación: </th>
                                            <td> <select class="form-control s " style="width: 100%" name="tipo_cifrado"
                                                    id="tipo_cifrado" data-toggle="select2" multiple="multiple"
                                                    disabled>
                                                    <option selected>
                                                      {{$firma->num_asignacion}}
                                                    </option>

                                                </select></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>




                    </div>
                    <!--Fin del row -->
                      <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="header-title">Firmas necesarias</h4>
                                <div class="form-group" class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
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
                                            <tr>
                                                @foreach($firmas as $firmas)
                                                 <td>{{$firmas->name}} {{$firmas->apellido_p}} {{$firmas->apellido_m}}</td>
                                                 <td>{{$firmas->funcion}}</td>
                                                 @if($firmas->estado == "PENDIENTE")
                                                  <td><span class="badge badge-danger">{{$firmas->estado}}</span>
                                                </td>
                                                 @else
                                                  <td><span class="badge badge-success">{{$firmas->estado}}</span>
                                                </td>
                                                 @endif
                                                 <td>{{$firmas->updated_at}}</td>
                                                 </tr>
                                                @endforeach

                                           

                                        </tbody>
                                    </table>
                                </div>



                            </div>

                        </div>

                    </div>
                      <h3>Ingrese sus credenciales</h3>
                     <div class="row">
                    <div class="col-lg-6">

                        <div class="card-box">

                            <h4 class="header-title mb-6" id='escanesc'>Certificado .cer</h4>

                            <input type="file" accept=".cer" id="certificado" value="{{old('certificado')}}" required
                                name="certificado" class="dropify" data-max-file-size="1M" />
                        </div>


                    </div>

                    <div class="col-lg-6">
                        <div class="card-box">

                            <h4 class="header-title mb-6" id='escanesc'>Llave privada .key</h4>

                            <input type="file" accept=".key" id="key" required name="key" value="{{old('key')}}"
                                class="dropify" data-max-file-size="1M" />
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="card-box">

                            <label for="userName">Contraseña de Firma electrónica<span class="text-danger">*</span></label>
                            <input class="form-control" type="password" value="{{old('password')}}" required=""
                                name="password" id="password" placeholder="Ingresa una contraseña">
                        </div>
                    </div><!-- end col -->

                </div>
                
                	@include('firmaDocumentos.modal_loading')
                            <div class="form-group text-right mb-0">
                                <button class="btn btn-primary waves-effect waves-light mr-1" onclick="modal_loading();" id="submit" type="submit">
                                    Guardar
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect">
                                    Cancelar
                                </button>
                            </div>




                </div>
            </div>
        </div>
        <!-- end row -->




    </form>

</div> <!-- end container-fluid -->

@stop