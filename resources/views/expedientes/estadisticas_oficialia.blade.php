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
                      
                    </ol>
                </div>
                <h4 class="page-title">Estadísticas Oficialia de Partes</h4>

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

                         <div class="row"> {{-- primer rooow --}}

                            <div class="col-xl-3 col-md-6">
                                <div class="card-box tilebox-two">
                                    <i class="icon-chart float-right text-muted"></i>
                                    <h6 class="text-primary text-uppercase">Total de expedientes</h6>
                                    <h3><span data-plugin="counterup">{{$all_exp}}</span></h3>
                                </div>
                            </div>    

                            <div class="col-xl-3 col-md-6">
                                <div class="card-box tilebox-two">
                                    <h6 class="text-muted text-uppercase mt-0">Expedientes del mes de {{$mes_letra}} </h6>
                                    <h3 class="my-3" data-plugin="counterup">{{$all_mes}}</h3>
                                    <div class="progress progress-md">
                                        <?php if($all_mes >0){$y=($all_mes*100)/$all_mes;}else{$y=0;} ?></h1>
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$y}}%"
                                            aria-valuenow="{{$all_mes}}" aria-valuemin="0" aria-valuemax="{{$all_mes}}">
                                        </div>
                                    </div>
                                    @if($all_mes_menos > $all_mes)
                                    <?php $dif_year=$all_mes_menos-$all_mes; ?>
                                    <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Mes pasado</span>
                                    @elseif($all_mes == $all_mes_menos)
                                    <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Mes pasado</span>
                                    @else
                                    <?php $dif_year=$all_mes-$all_mes_menos; ?>
                                    <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Mes
                                        pasado</span>
                                    @endif
                                </div>
                            </div>
                    
                            <div class="col-xl-3 col-md-6">
                                <div class="card-box tilebox-two">
                                    <h6 class="text-muted text-uppercase mt-0">Expedientes del año {{$year}}</h6>
                                    <h3 class="my-3" data-plugin="counterup">{{$all_year}}</h3>
                                    <div class="progress progress-md">
                                        <?php if($all_year <> null ){
                                            
                                            if ($all_mes == 0){
                                                $z=0;
                                            }else{
                                                $z=($all_year*100)/$all_mes;
                                            }
                                       
                                        
                                    }else{
                                        $z=0;} ?></h1>
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$z}}%"
                                            aria-valuenow="{{$all_year}}" aria-valuemin="0" aria-valuemax="{{$all_mes}}">
                                        </div>
                                    </div>
                                    @if($all_year_menos > $all_year)
                                    <?php $dif_year=$all_year_menos-$all_year; ?>
                                    <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Año pasado</span>
                                    @elseif($all_year == $all_year_menos)
                                    <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Año pasado</span>
                                    @else
                                    <?php $dif_year=$all_year-$all_year_menos; ?>
                                    <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Año
                                        pasado</span>
                                    @endif
                    
                                </div>
                            </div>
                                    
            
                         </div>
                                    <!-- end row -->
                                   
                                    
                        </div> <!-- end container-fluid -->
                        
            
                        <!-- ============================================================== -->
                        <!-- End Page content -->
                        <!-- ============================================================== -->
            
                       

                </div>   
        <!--//////////////////////////////////////////////////////////////////////////////////////////////7  -->
        <hr>
       


<?php 
$date = date('Y-m-d');
?>
<!-- Tipo juicio -->
<div>
<div class="col-12 mr-auto mr-12 mb-12">
        <div class="container-fluid">
                        <div class="row">
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha inicio<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_inicio" value="{{$date}}" onchange="traerNul();traerRag();traerGen();traerAmp();traerProm();" parsley-trigger="change" required
                                class="form-control" id="fecha_inicio">
                            </div>
    
                            <div class="form-group" style="padding:5px;">
                                <label for="contestacion">Fecha fin<span class="text-danger">*</span></label>
                                <input type="date" name="fecha_fin" value="{{$date}}" onchange="traerNul();traerRag();traerGen();traerAmp();traerProm();" parsley-trigger="change" required
                                class="form-control" id="fecha_fin">
                            </div>
                            <div class="form-group" style="margin-top: 40px;">  
                                <a class="btn btn-primary btn-sm" href="{{URL::action('ExpedientesController@acusedia',$date)}}" id="acusedia" style="margin-right: 20px;" data-toggle="tooltip" target="_blank" data-placement="bottom" title="" data-original-title="Descargar"> <i class="fa fa-print"></i> Generar PDF</a>
                             </div>
                       {{--  <div class="form-group" style="padding:5px;">
                            <label for="userName">Tipo Expediente<span class="text-danger">*</span></label>
                            <select class="form-control" style="" onchange='' name="tipo_juicio" id="tipo_juicio" required
                                data-placeholder="Seleccione una opción ...">
                                <option value="" selected>Seleccione una opción</option>
                               
                                <option value="NULIDAD">
                                    NULIDAD
                                </option>

                                <option value="RAG">
                                    RAG
                                </option>

                                <option value="GENERALIDAD">
                                    GENERALIDAD
                                </option>

                                <option value="AMPARO">
                                    AMPARO
                                </option>

                                <option value="PROMOCION">
                                    PROMOCIÓN
                                </option>

                               
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>
                        </div> --}}


                              

                        

                                                
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
                                        <div class="col-md-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Nulidad</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" id='tot_nul' data-height="120" data-linecap=round data-fgColor="#5d9cec" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                        
                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total RAG</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='tot_rag' data-linecap=round data-fgColor="#fb6d9d" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            

                                                </div>
                                            </div>
            
                                        </div>
            
                                        <div class="col-md-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Amparos</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='tot_amp' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>

                                        <div class="col-md-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Promociones</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='tot_prom' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>

                                        <div class="col-md-3">
                                            <div class="card-box">
                                                <h4 class="header-title">Total Generalidades</h4>
            
                                                <div class="widget-chart text-center">
                                                    <div dir="ltr">
                                                        <input data-plugin="knob" data-width="120" data-height="120" id='tot_gen' data-linecap=round data-fgColor="#34d3eb" value="0" data-skin="tron" data-angleOffset="120" data-readOnly=true data-thickness=".12"/>
                                                    </div>
            
                                                    
                                                </div>
                                            </div>
            
                                        </div>
            
                                    </div>
                                    <!-- end row -->
            
                                    
                                </div> <!-- end container-fluid -->
<div class="row mt-3">

<div class="col-lg-6">
        <div class="mt-5">
             <h4 class="header-title">SVG Path animation</h4>
             <p class="sub-header">
                   Path animation is made easy with the SVG Path API. The API allows you to
                   modify complex SVG paths and transform them for different animation
                morphing states.
             </p>

             <div class="p-3" dir="ltr">
                  <div id="svg-animation" class="ct-chart ct-golden-section"></div>
            </div>
        </div>
</div>

<div class="col-lg-6">
    <div class="mt-5">
        <h4 class="header-title">Simple pie chart</h4>
        <p class="sub-header">
            A very simple pie chart with label interpolation to show percentage instead
            of the actual data series value.
        </p>

        <div class="p-3" dir="ltr">
            <div id="pastel" class="ct-chart ct-golden-section simple-pie-chart-chartist"></div>
        </div>
    </div>
</div>

</div>
            
                        <!-- ============================================================== -->
                        <!-- End Page content -->
                        <!-- ============================================================== -->
            
                       

                </div>
                <!-- END wrapper -->
</div> <!-- fin id juiocio -->



                        

            
                  
            
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
function cambia_display_estadisticas_ofi(value) {
    if(value == "nulidad"){
        document.getElementById('nulidad').style.display = 'block';
        document.getElementById('rag').style.display = 'none';
        document.getElementById('promocion').style.display = 'none';
        document.getElementById('amparo').style.display = 'none';
        document.getElementById('generalidad').style.display = 'none';
    }
}

function traerNul(){
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var tot_nul = document.getElementById('tot_nul');
    var route = ruta_global + "/traer_exp_nul/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
         tot_nul.value = data.expedientes_nul;;
      }});
}

function traerRag(){
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var tot_rag = document.getElementById('tot_rag');
    var route = ruta_global + "/traer_exp_rag/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
        tot_rag.value = data.expedientes_rag;;
      }});
}

function traerGen(){
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var tot_gen = document.getElementById('tot_gen');
    var route = ruta_global + "/traer_exp_gen/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
        tot_gen.value = data.expedientes_gen;;
      }});
}

function traerAmp(){
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var tot_amp = document.getElementById('tot_amp');
    var route = ruta_global + "/traer_exp_amp/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
        tot_amp.value = data.expedientes_amps;
      }});
}

function traerProm(){
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var fecha_fin = document.getElementById('fecha_fin').value;
    var tot_prom = document.getElementById('tot_prom');
    var route = ruta_global + "/traer_exp_prom/"+fecha_inicio+"/"+fecha_fin;
    var token = $("#token").val();
  $.ajax({
      type: "get",
      headers: { 'X-CSRF-TOKEN': token },
      method: 'get',
      url: route,
      success: function (data) {
        tot_prom.value = data.expedientes_prom;
      }});
}

(chart=new Chartist.Line("#svg-animation",{labels:["Mon","Tue","Wed","Thu","Fri","Sat"],series:[[1,5,2,5,4,3],[2,3,4,8,1,2],[5,4,3,2,1,.5]]},{low:0,showArea:!0,showPoint:!1,fullWidth:!0})).on("draw",function(e){"line"!==e.type&&"area"!==e.type||e.element.animate({d:{begin:2e3*e.index,dur:2e3,from:e.path.clone().scale(1,0).translate(0,e.chartRect.height()).stringify(),to:e.path.clone().stringify(),easing:Chartist.Svg.Easing.easeOutQuint}})});
data={series:[5,3,4]};
var sum=function(e,t){return e+t};
new Chartist.Pie("#pastel",data,{labelInterpolationFnc:function(e){return Math.round(e/data.series.reduce(sum)*100)+"%"}});data={labels:["Bananas","Apples","Grapes"],series:[20,15,40]},options={labelInterpolationFnc:function(e){return e[0]}},responsiveOptions=[["screen and (min-width: 640px)",{chartPadding:30,labelOffset:100,labelDirection:"explode",labelInterpolationFnc:function(e){return e}}],["screen and (min-width: 1024px)",{labelOffset:80,chartPadding:20}]];
</script>
@endsection