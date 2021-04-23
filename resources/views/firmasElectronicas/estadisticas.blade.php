@extends('layouts.principal')
@section('contenido')
<link rel="shortcut icon" href="assets/images/favicon.ico">

<!-- Chartist Chart CSS -->
<link rel="stylesheet" href="assets/libs/chartist/chartist.min.css">

<!-- App css -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="assets/css/app.min.css" rel="stylesheet" type="text/css"  id="app-stylesheet" />
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                      
                        <a class="btn btn-sm btn-warning tooltips" id="excel_estadisticas" href="{{ route('firmasElectronicas.excel','2')}}" style="margin-right: 10px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-file-excel"></i> Descargar </a>
                    </ol>
                </div>
                <h4 class="page-title">Estadisticas Firmas</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <form action="" method="post" files="true"
        enctype="multipart/form-data">

        {{csrf_field()}}
        
        <div>

         <!--/////////////////////////////////////////////////////////////////////////////////////////////////  -->
          <!-- Begin page -->
    <div id="wrapper">
                        <!-- ============================================================== -->
                        <!-- Start Page Content here -->
                        <!-- ============================================================== -->

            <div class="container-fluid">

                <div class="row">

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box tilebox-two">
                            <i class="icon-chart float-right text-muted"></i>
                            <h6 class="text-primary text-uppercase">Total de firmas requeridas</h6>
                            <h3><span data-plugin="counterup">{{$total_registros}}</span></h3>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box tilebox-two">
                            <h6 class="text-muted text-uppercase mt-0">Firmas requeridas del mes de {{$mes_letra}} </h6>
                            <h3 class="my-3" data-plugin="counterup">{{$docs_mes}}</h3>
                            <div class="progress progress-md">
                                <?php if($docs_mes >0){$y=($docs_mes*100)/$total_registros;}else{$y=0;} ?></h1>
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$y}}%"
                                    aria-valuenow="{{$docs_mes}}" aria-valuemin="0" aria-valuemax="{{$total_registros}}">
                                </div>
                            </div>
                            @if($registros_year_menos > $docs_mes)
                            <?php $dif_year=$registros_year_menos-$docs_mes; ?>
                            <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Mes pasado</span>
                            @elseif($docs_mes == $registros_year_menos)
                            <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Mes pasado</span>
                            @else
                            <?php $dif_year=$docs_mes-$registros_year_menos; ?>
                            <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Mes
                                pasado</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box tilebox-two">
                            <h6 class="text-muted text-uppercase mt-0">Firmas requeridas del año {{$year}}</h6>
                            <h3 class="my-3" data-plugin="counterup">{{$registros_year}}</h3>
                            <div class="progress progress-md">
                                <?php if($registros_year <> null ){
                                $z=($registros_year*100)/$total_registros;
                                }else{
                                $z=0;} ?></h1>
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$z}}%"
                                    aria-valuenow="{{$registros_year}}" aria-valuemin="0" aria-valuemax="{{$total_registros}}">
                                </div>
                            </div>
                            @if($registros_year_menos > $registros_year)
                            <?php $dif_year=$registros_year_menos-$registros_year; ?>
                            <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Año pasado</span>
                            @elseif($registros_year == $registros_year_menos)
                            <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Año pasado</span>
                            @else
                            <?php $dif_year=$registros_year-$registros_year_menos; ?>
                            <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Año
                                pasado</span>
                            @endif

                        </div>
                    </div>
                </div> <!-- end row -->

            <div class="row"> <!--row -->
                <div class="col-md-12">
                    <div class="mt-5">
                        <h4 class="header-title">Grafica de documentos generados al año</h4>
                            <p class="sub-header">
                                
                            </p>

                            <div class="p-3" dir="ltr">
                                <div id="svg-animation" class="ct-chart ct-golden-section"></div>
                            </div>
                    </div>
                </div>
            </div>     <!-- end row -->
            <hr>
                <div class='row'>
                    <div class="col-xl-3 col-md-6">
                        <div class="card-box tilebox-two">
                            <i class="icon-chart float-right text-muted"></i>
                            <h6 class="text-primary text-uppercase">Total cocumentos generados</h6>
                            <h3><span data-plugin="counterup">{{$num_docs}}</span></h3>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box tilebox-two">
                            <h6 class="text-muted text-uppercase mt-0">Documentos generados del mes de {{$mes_letra}} </h6>
                            <h3 class="my-3" data-plugin="counterup">{{$docus_mes}}</h3>
                            <div class="progress progress-md">
                                <?php if($docus_mes >0){$y=($docus_mes*100)/$num_docs;}else{$y=0;} ?></h1>
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$y}}%"
                                    aria-valuenow="{{$docus_mes}}" aria-valuemin="0" aria-valuemax="{{$num_docs}}">
                                </div>
                            </div>
                            @if($docs_year_menos > $docus_mes)
                            <?php $dif_years=$docs_year_menos-$docus_mes; ?>
                            <span class="badge badge-danger mr-1"> -{{$dif_years}} </span> <span class="text-muted">Mes pasado</span>
                            @elseif($docus_mes == $docs_year_menos)
                            <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Mes pasado</span>
                            @else
                            <?php $dif_years=$docus_mes-$docs_year_menos; ?>
                            <span class="badge badge-success mr-1"> +{{$dif_years}} </span> <span class="text-muted">Mes
                                pasado</span>
                            @endif
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6">
                        <div class="card-box tilebox-two">
                            <h6 class="text-muted text-uppercase mt-0">Documentos generados del año {{$year}}</h6>
                            <h3 class="my-3" data-plugin="counterup">{{$docs_year}}</h3>
                            <div class="progress progress-md">
                                <?php if($docs_year <> null ){
                                $z=($docs_year*100)/$num_docs;
                                }else{
                                $z=0;} ?></h1>
                                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$z}}%"
                                    aria-valuenow="{{$docs_year}}" aria-valuemin="0" aria-valuemax="{{$num_docs}}">
                                </div>
                            </div>
                            @if($docs_year_menos > $docs_year)
                            <?php $dif_year=$docs_year_menos-$docs_year; ?>
                            <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Año pasado</span>
                            @elseif($docs_year == $docs_year_menos)
                            <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Año pasado</span>
                            @else
                            <?php $dif_year=$docs_year-$docs_year_menos; ?>
                            <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Año
                                pasado</span>
                            @endif

                        </div>
                    </div>
                 </div>
                 <div class="row"> <!--row -->
                    <div class="col-md-12">
                        <div class="mt-5">
                            <h4 class="header-title">Grafica de documentos generados al año</h4>
                                <p class="sub-header">
                                    
                                </p>
    
                                <div class="p-3" dir="ltr">
                                    <div id="svg-animation1" class="ct-chart ct-golden-section"></div>
                                </div>
                        </div>
                    </div>
                </div>     <!-- end row -->                                       
            </div> <!-- end container-fluid -->
         </div>   
        <!--//////////////////////////////////////////////////////////////////////////////////////////////7  -->
        <hr>
            <div class="col-12">
                 <h1>Detalles</h1>
                    <div class="row">
                        <div class="form-group">
                            <label for="userName">Seleccióne tipo<span class="text-danger">*</span></label>
                            <select class="form-control" onchange="cambia_display_estadisticas(this.value);"
                                style="width: 100%" name="origen" id="origen" required
                                data-placeholder="Seleccione una opción ...">
                                <option value="" selected>Seleccione una opción</option>
                                <option value="juicio">Tipo de Juicio</option>
                                <option value="documentos">Tipo de Documento</option>
                                <option value="expedientes">Expediente</option>
                                <option value="salas">Sala</option>
                            </select>

                        </div>
                     </div>
                       
             </div>
        <!--//////////////////////////////////////////////////////////////////////////////////////////////7  -->

<?php 
$date = date('Y-m-d');
?>
<!-- Tipo juicio -->
<div id="juicio" style='display:none'>
<div class="col-12 mr-auto mr-12 mb-12">
        <div class="container-fluid">
                        <div class="row">
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha inicio<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_inicio" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_inicio">
                            </div>
    
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha fin<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_fin" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_fin">
                            </div>
                        <div class="form-group" style="padding:5px;">
                            <label for="userName">Tipo de juicio<span class="text-danger">*</span></label>
                            <select class="form-control" style="" onchange='traerJuicios();traerJuiciosfirmados();traerJuiciosPendientes();traerJuiciosRevocadas();llenarPasterJuicios();traerJuicios_totales();' name="tipo_juicio" id="tipo_juicio" required
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


                        <div class="form-group col-2" style="padding:5px;">  
                            <label for="userName">Sala<span class="text-danger">* </span></label>
                            <select class="form-control" style="" name="sala" id="sala" onchange='traerJuicios();traerJuiciosfirmados();traerJuiciosPendientes();traerJuiciosRevocadas();llenarPasterJuicios();traerJuicios_totales();' required
                                data-placeholder="Seleccione una opción ...">
                                @foreach($salas as $sala)
                                <option value="{{$sala->num_sala}}">
                                {{$sala->num_sala}}
                                </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div>
                        </div> <!-- fin row   -->            

                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mt-5">
                                    <h4 class="header-title"></h4>
                                    <p class="sub-header">
                                       
                                    </p>

                                    <div class="p-3" dir="ltr">
                                        <div id="pastel" class="ct-chart ct-golden-section simple-pie-chart-chartist"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                                                
                <!-- end row -->


                </div> <!-- end container-fluid -->




            </div>





<br><br>
                    <!-- Begin page -->
                    <div id="wrapper">
                        <!-- ============================================================== -->
                        <!-- Start Page Content here -->
                        <!-- ============================================================== -->

                        <div class="container-fluid">

                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='juicioest_tot' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Firmas en Sala</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='juicioest' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas tipo juicio estado "Firmado"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_firmado' data-linecap=round data-fgColor="#fb6d9d" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            

                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas tipo juicio estado "Pendiente"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_pendiente' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>

                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas tipo juicio estado "Revocadas"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_revocadas' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>
            
                                    </div>
                                    <!-- end row -->
            
                                    
                                </div> <!-- end container-fluid -->
                        
            
                        <!-- ============================================================== -->
                        <!-- End Page content -->
                        <!-- ============================================================== -->
            
                       

                </div>
                <!-- END wrapper -->
</div> <!-- fin id juiocio -->


<!-- tipo documentos -->
<div id="documentos" style='display:none'>
    <div class="col-12 mr-auto mr-12 mb-12">
        <div class="container-fluid">
                        <div class="row">
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha inicio<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_inicio_doc" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_inicio_doc">
                            </div>
    
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha fin<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_fin_doc" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_fin_doc">
                            </div>
                        
                            <div class="form-group" style="padding:5px;">
                                <label for="userName">Tipo de documento<span class="text-danger">*</span></label>
                                <select class="form-control" style="width: 100%" onchange="traerDocumentos();traerDocumentosfirmados();traerDocumentosPendientes();traerDocumentosRevocadas();traerDocumentos_totales();llenarPastelDocumentos();" name="tipoDocumento" id="tipoDocumento"
                                    required data-placeholder="Seleccione una opción ...">
                                    <option value="" selected>Seleccione una opción</option>
                                    @foreach($tipo_documentos as $tipo)
                                    <option value="{{$tipo->tipo_documento}}">
                                        {{$tipo->tipo_documento}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
    
                            </div>


                        <div class="form-group col-2" style="padding:5px;">  
                            <label for="userName">Sala<span class="text-danger">* </span></label>
                            <select class="form-control" style="" name="sala_doc" id="sala_doc" onchange='traerDocumentos();traerDocumentosfirmados();traerDocumentosPendientes();traerDocumentosRevocadas();traerDocumentos_totales();;llenarPastelDocumentos()' required
                                data-placeholder="Seleccione una opción ...">
                                @foreach($salas as $sala)
                                <option value="{{$sala->num_sala}}">
                                {{$sala->num_sala}}
                                </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div>
                        </div> <!-- fin row   -->            

                        
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mt-5">
                                    <h4 class="header-title"></h4>
                                    <p class="sub-header">
                                       
                                    </p>

                                    <div class="p-3" dir="ltr">
                                        <div id="pastelDocumentos" class="ct-chart ct-golden-section simple-pie-chart-chartist"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                                                
                <!-- end row -->


                </div> <!-- end container-fluid -->




            </div>





<br><br>
                    <!-- Begin page -->
                    <div id="wrapper">
                        <!-- ============================================================== -->
                        <!-- Start Page Content here -->
                        <!-- ============================================================== -->

                        <div class="container-fluid">

                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='documentostot_tot' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Firmas en Sala</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='documentostot' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas tipo documento estado "Firmado"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_firmado_doc' data-linecap=round data-fgColor="#fb6d9d" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            

                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas tipo documento estado "Pendiente"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_pendiente_doc' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>

                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas tipo documento estado "Revocadas"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_revocadas_doc' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>
            
                                    </div>
                                    <!-- end row -->
            
                                    
                                </div> <!-- end container-fluid -->
                        
            
                        <!-- ============================================================== -->
                        <!-- End Page content -->
                        <!-- ============================================================== -->
            
                       

                </div>
                <!-- END wrapper -->
</div>
<!--Fin tipo documentos -->

<!-- tipo expedientes -->
<div id="expedientes" style='display:none'>
    <div class="col-12 mr-auto mr-12 mb-12">
        <div class="container-fluid">
                        <div class="row">
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha inicio<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_inicio_exp" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_inicio_exp">
                            </div>
    
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha fin<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_fin_exp" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_fin_exp">
                            </div>
                        
                            <div class="form-group" style="padding:5px;">
                                <label for="userName">Tipo de expediente<span class="text-danger">*</span></label>
                                <select class="form-control" style="width: 100%" onchange='traerExpedientes();traerExpedientesfirmados();traerExpedientesPendientes();traerExpedientesRevocadas();traerexpedientes_totales();' name="tipoExpediente" id="tipoExpediente"
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


                        <div class="form-group col-2" style="padding:5px;">  
                            <label for="userName">Sala<span class="text-danger">* </span></label>
                            <select class="form-control" style="" name="sala_exp" id="sala_exp" onchange='traerExpedientes();traerExpedientesfirmados();traerExpedientesPendientes();traerExpedientesRevocadas();traerexpedientes_totales();' required
                                data-placeholder="Seleccione una opción ...">
                                @foreach($salas as $sala)
                                <option value="{{$sala->num_sala}}">
                                {{$sala->num_sala}}
                                </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div>
                        </div> <!-- fin row   -->            
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mt-5">
                                    <h4 class="header-title"></h4>
                                    <p class="sub-header">
                                       
                                    </p>

                                    <div class="p-3" dir="ltr">
                                        <div id="pastelExpedientes" class="ct-chart ct-golden-section simple-pie-chart-chartist"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        

                                                
                <!-- end row -->


                </div> <!-- end container-fluid -->




            </div>





<br><br>
                    <!-- Begin page -->
                    <div id="wrapper">
                        <!-- ============================================================== -->
                        <!-- Start Page Content here -->
                        <!-- ============================================================== -->

                        <div class="container-fluid">

                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='tot_exp_tot' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Firmas en Sala</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='tot_exp' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas  estado "Firmado"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_firmado_exp' data-linecap=round data-fgColor="#fb6d9d" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            

                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas estado "Pendiente"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_pendiente_exp' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>

                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas estado "Revocadas"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_revocadas_exp' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>
            
                                    </div>
                                    <!-- end row -->
            
                                    
                                </div> <!-- end container-fluid -->
                        
                             
                        <!-- ============================================================== -->
                        <!-- End Page content -->
                        <!-- ============================================================== -->
            
                       

                </div>
                <!-- END wrapper -->
</div>
<!--Fin tipo expedientes -->

<!-- tipo sala -->
<div id="salas" style='display:none'>
    <div class="col-12 mr-auto mr-12 mb-12">
        <div class="container-fluid">
                        <div class="row">
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha inicio<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_inicio_sala" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_inicio_sala">
                            </div>
    
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha fin<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_fin_sala" value="{{$date}}" parsley-trigger="change" required
                                class="form-control" id="fecha_fin_sala">
                            </div>
                            
                            <div class="form-group" style="padding:5px;">
                                <label for="userName">Salas<span class="text-danger">* </span></label>
                                <select class="form-control" style="width: 100%" name="sala_salas" id="sala_salas" onchange="traerSalas();traerSalasfirmados();traerSalasPendientes();traerSalasRevocadas();llenarPastelSalas();" required
                                    data-placeholder="Seleccione una opción ...">
                                    <option value="" selected>Seleccione una opción</option>
                                    @foreach($salas as $sala)
                                    <option value="{{$sala->num_sala}}">
                                    {{$sala->num_sala}}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
    
                            </div>
                        </div> <!-- fin row   -->            

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mt-5">
                                    <h4 class="header-title"></h4>
                                    <p class="sub-header">
                                       
                                    </p>

                                    <div class="p-3" dir="ltr">
                                        <div id="pastelSalas" class="ct-chart ct-golden-section simple-pie-chart-chartist"></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                                                
                <!-- end row -->


                </div> <!-- end container-fluid -->




            </div>





<br><br>
                    <!-- Begin page -->
                    <div id="wrapper">
                        <!-- ============================================================== -->
                        <!-- Start Page Content here -->
                        <!-- ============================================================== -->

                        <div class="container-fluid">

                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Firmas</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='tot_sala' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas estado "Firmado"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_firmado_sala' data-linecap=round data-fgColor="#fb6d9d" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            

                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas estado "Pendiente"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_pendiente_sala' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>

                                        <div class="col-xl-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total firmas "Revocadas"</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='estado_revocadas_sala' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>
            
                                    </div>
                                    <!-- end row -->
                                    
                                    
                                </div> <!-- end container-fluid -->
                        
            
                        <!-- ============================================================== -->
                        <!-- End Page content -->
                        <!-- ============================================================== -->
            
                       

                </div>
                <!-- END wrapper -->
</div>
<!--Fin tipo sala -->
                    <div id="wrapper">
                        <!-- ============================================================== -->
                        <!-- Start Page Content here -->
                        <!-- ============================================================== -->

                        <div class="container-fluid">
                            
                                    
                                                            
                        </div> <!-- end container-fluid -->
                    </div>                      

            
                  
            
                    <!-- Vendor js -->
                    <script src="assets/js/vendor.min.js"></script>
            
                    <!--Morris Chart-->
                    <script src="assets/libs/morris-js/morris.min.js"></script>
                    <script src="assets/libs/raphael/raphael.min.js"></script>
            
                    <!--Chartist Chart-->
                    <script src="assets/libs/chartist/chartist.min.js"></script>
                    <script src="assets/libs/chartist/chartist-plugin-tooltip.min.js"></script>
            
                    <!-- KNOB JS -->
                    <script src="assets/libs/jquery-knob/jquery.knob.min.js"></script>
            
                    <!-- widget init -->
                    <script src="assets/js/pages/widgets.init.js"></script>
            
                    <!-- App js -->
                    <script src="assets/js/app.min.js"></script>
                    
               
           
        
        
        </div>

    </form>

</div> <!-- end container-fluid -->

@stop
@section('javascript')
 <!-- Vendor js -->
 <script src="assets/js/vendor.min.js"></script>

<!--Chartist Chart-->
<script src="assets/libs/chartist/chartist.min.js"></script>
<script src="assets/libs/chartist/chartist-plugin-tooltip.min.js"></script>

<!-- Init js -->
<script src="assets/js/pages/chartist.init.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>
<script type="text/javascript">
//OCULTAR Y MOSTRAR EL INPUT DE PROMOCIONES EN LOS ACUERDOS
function cambia_display_estadisticas(value) {
    if(value == "juicio"){
        document.getElementById('juicio').style.display = 'block';
        document.getElementById('documentos').style.display = 'none';
        document.getElementById('expedientes').style.display = 'none';
        document.getElementById('salas').style.display = 'none';
    }else if(value == "documentos"){
        document.getElementById('juicio').style.display = 'none';
        document.getElementById('documentos').style.display = 'block';
        document.getElementById('expedientes').style.display = 'none';
        document.getElementById('salas').style.display = 'none';
    }else if(value == "expedientes"){
        document.getElementById('juicio').style.display = 'none';
        document.getElementById('documentos').style.display = 'none';
        document.getElementById('expedientes').style.display = 'block';
        document.getElementById('salas').style.display = 'none';
    }else if(value == "salas"){
        document.getElementById('juicio').style.display = 'none';
        document.getElementById('documentos').style.display = 'none';
        document.getElementById('expedientes').style.display = 'none';
        document.getElementById('salas').style.display = 'block';
    }
} 
(chart=new Chartist.Line("#svg-animation1",{labels:["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],series:[[1,5,2,5,4,3],[2,3,4,8,1,2],[5,4,3,2,1,.5]]},{low:0,showArea:!0,showPoint:!1,fullWidth:!0})).on("draw",function(e){"line"!==e.type&&"area"!==e.type||e.element.animate({d:{begin:2e3*e.index,dur:2e3,from:e.path.clone().scale(1,0).translate(0,e.chartRect.height()).stringify(),to:e.path.clone().stringify(),easing:Chartist.Svg.Easing.easeOutQuint}})});

(chart=new Chartist.Line("#svg-animation",{labels:["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],series:[[1,5,2,5,4,3],[2,3,4,8,1,2],[5,4,3,2,1,.5]]},{low:0,showArea:!0,showPoint:!1,fullWidth:!0})).on("draw",function(e){"line"!==e.type&&"area"!==e.type||e.element.animate({d:{begin:2e3*e.index,dur:2e3,from:e.path.clone().scale(1,0).translate(0,e.chartRect.height()).stringify(),to:e.path.clone().stringify(),easing:Chartist.Svg.Easing.easeOutQuint}})});

/* data={series:[5,3,4]};
var sum=function(e,t){return e+t};
new Chartist.Pie("#pastel",data,{labelInterpolationFnc:function(e){return Math.round(e/data.series.reduce(sum)*100)+"%"}}); */
</script>
@endsection