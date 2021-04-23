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
                        <li class="breadcrumb-item"><a href="/firmaElectronica">Firma electrónica</a></li>
                        <li class="breadcrumb-item active">Detalles de firma electrónica</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles de firma electrónica: {{$usuario->name}} . </h4>
                <div class="row">
                    <div class="col-6">

                    </div>
                    <div class="col-6 float-right">
                        <a href="/firmaElectronica/create" class="button-list float-right">
                            <button type="button" class="btn btn-success waves-effect waves-light mb-3">
                                <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                                </span>Registrar nueva firma electrónica</button>
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
                    <h4 class="header-title">Datos:</h4>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">




                                        <tr class="bg-light text-dark">
                                            <th>Nombre del interesado:</th>
                                            <td><select class="form-control" style="width: 100%" name="nombre"
                                                    id="nombre" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$usuario->name}}
                                                    </option>
                                                </select></td>

                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Email:</th>
                                            <td><select class="form-control" style="width: 100%" name="email" id="email"
                                                    data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$usuario->email}}
                                                    </option>
                                                </select></td>

                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Puesto o función:</th>
                                            <td><select class="form-control" style="width: 100%" name="puesto"
                                                    id="puesto" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$usuario->funcion}}
                                                    </option>
                                                </select></td>

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
                                            <th>Nuúmero de serie del certificado: </th>
                                            <td><select class="form-control " style="width: 100%" name="serial"
                                                    id="serial" data-toggle="select2" multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$firma->serial}}
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
                                            <th>Tipo de Cifrado: </th>
                                            <td> <select class="form-control s " style="width: 100%" name="tipo_cifrado"
                                                    id="tipo_cifrado" data-toggle="select2" multiple="multiple"
                                                    disabled>
                                                    <option selected>
                                                        SHA256
                                                    </option>

                                                </select></td>
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
                                            <th>Descarga Certificado: </th>
                                            <td id="hojas_anexos">

                                                <div class="mb-2">
                                                    <a href="../ssl/cert/{{$firma->cert}}"
                                                        download="{{$firma->cert}}"
                                                        class="btn btn-outline-danger waves-effect waves-light"
                                                        role="button">
                                                        <i class="mdi mdi-xml"> Descargar .cert</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr class="bg-white text-dark">
                                            <th>Descargar Llave privada: </th>
                                            <td id="hojas_anexos">

                                                <div class="mb-2">
                                                    <a href="../ssl/key/{{$firma->llave}}"
                                                        download="{{$firma->llave}}"
                                                        class="btn btn-outline-danger waves-effect waves-light"
                                                        role="button">
                                                        <i class="mdi mdi-file-pdf-outline"> Descargar .key</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                     
                                      

                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!--Fin del row -->





                </div>
            </div>
        </div>
        <!-- end row -->




    </form>

</div> <!-- end container-fluid -->

@stop