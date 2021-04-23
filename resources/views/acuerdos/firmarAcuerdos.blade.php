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
                        <li class="breadcrumb-item"><a href="/acuerdos">Acuerdos</a></li>
                        <li class="breadcrumb-item active">Firmar acuerdo</li>
                    </ol>
                </div>
                <h4 class="page-title">Firmar acuerdo generado folio:{{$acuerdo->num_folio}}</h4>
                <div class="row">
                    <div class="col-6">


                        <a href="/imprimir_acuerdo/{{$acuerdo->id}}" target="_blank" class="button-list">
                            <button type="button" class="btn btn-danger waves-effect waves-light">
                                <span class="btn-label"><i class="mdi mdi-pdf-box"></i>
                                </span>Vista previa acuerdo</button>
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="/firmarAcuerdo/{{$acuerdo->id}}" id="form_firmar" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">Expediente: {{$acuerdo->num_expediente}}</h4>
                    <div class="row">


                        <div class="col-xl-3 col-md-6">
                            <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                                    <i class="ion ion-md-paper font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-success text-uppercase">Número de Sala </h6>
                                    <h3>{{$acuerdo->num_sala}}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-7">
                            <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                                    <i class=" mdi mdi-home-map-marker font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-pink text-uppercase">Ubicación del expediente</h6>
                                    <h5>{{$acuerdo->ubicacion}}</5>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="header-title">Información del acuerdo generado</h4>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Versión</th>
                                                <th>N° Folio</th>
                                                <th>Tipo</th>
                                                <th>Estado</th>
                                                <th>Asignado</th>

                                                <th>Modificado por</th>
                                                <th>Fecha de captura</th>
                                                <th>Ultima actualización</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$acuerdo->version}}</td>
                                                <td>{{$acuerdo->num_folio}}</td>
                                                <td>{{$acuerdo->tipo}}</td>
                                                <td>{{$acuerdo->estado}}</td>
                                                <td>{{$acuerdo->name_asig}} {{$acuerdo->apellido_pasig}}
                                                    {{$acuerdo->apellido_masig}}</td>
                                                <td>{{$acuerdo->captura}}</td>
                                                <td>{{$acuerdo->created_at}}</td>
                                                <td>{{$acuerdo->updated_at}}</td>


                                            </tr>

                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="header-title">Firmar acuerdo</h4>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">

                                    <h4 class="header-title mb-4" id='escanesc'>Certificado .cert</h4>

                                    <input type="file" accept=".cer" id="certificado" required name="certificado"
                                        class="dropify" data-max-file-size="1M" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">

                                    <h4 class="header-title mb-4" id='escanesc'>Llave privada .key</h4>

                                    <input type="file" accept=".key" id="llaveprivada" required name="llaveprivada"
                                        class="dropify" data-max-file-size="1M" />
                                </div>
                            </div><!-- end col -->

                            <div class="col-lg-6">
                                <div class="card-box">
                                    <h4 class="header-title mb-4" id='escanesc'>Contraseña de su FIEL</h4>
                                    <input class=" form-control" type="password" required name="password"
                                        id="password" placeholder="Ingresa su contraseña de su FIEL">
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="card-box">

                                    <h4 class="header-title mb-4" id='escanesc'>Validar CAPTCHA</h4>
                                    <button class="g-recaptcha" data-sitekey="6LewbWkaAAAAAIY9JBU6nj0R3abDNOSpk_ijtnvO"
                                        data-callback='onSubmit' data-action='submit'>Submit</button>
                                </div>
                            </div>
 



                        </div>
                    </div>
                </div>
                <!-- end row -->
    </form>

</div> <!-- end container-fluid -->

<script>
function onSubmit(token) {
    document.getElementById("form_firmar").submit();
}
</script>
@stop