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
                <h4 class="page-title">Validador de firmas electrónicas</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="validarFirma" id="form_firmar" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">                  
                    <div class="row">




                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card-box">

                                    <h4 class="header-title mb-6" id='escanesc'>Certificado .cer</h4>

                                    <input type="file" accept=".cer" id="certificado" value="{{old('certificado')}}" required name="certificado"
                                        class="dropify" data-max-file-size="1M" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card-box">

                                    <h4 class="header-title mb-6" id='escanesc'>Firma del documento .dat</h4>

                                    <input type="file" accept=".dat" id="firma" required name="firma" value="{{old('firma')}}" class="dropify"
                                        data-max-file-size="1M" />
                                </div>
                            </div><!-- end col -->
                            <div class="col-lg-12">
                                <div class="card-box">

                                    <h4 class="header-title mb-12" id='escanesc'>XML .xml</h4>

                                    <input type="file" accept=".xml" id="xml" required name="xml" value="{{old('xml')}}" class="dropify"
                                        data-max-file-size="1M" />
                                </div>
                            </div><!-- end col -->

                        

                         







                        </div>
                    </div>
                    <!-- end row -->
                      <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" id="submit"  type="submit">
                                        Validar
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">
                                        Cancelar
                                    </button>
                                </div>
    </form>

</div> <!-- end container-fluid -->

@stop