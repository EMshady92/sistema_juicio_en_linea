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
                <h4 class="page-title">Firmar </h4>
                <div class="row">
                    <div class="col-6">



                    </div>

                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="/ejemplo1" id="form_firmar" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                  
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