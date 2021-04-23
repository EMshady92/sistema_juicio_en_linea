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
                        <li class="breadcrumb-item"><a href="/acuerdos">Acuerdos</a></li>
                        <li class="breadcrumb-item active">Mis acuerdos</li>
                    </ol>
                </div>
                <h4 class="page-title">Mis acuerdos por revisar</h4>                        
            </div>
        </div>
        @if($mis_acuerdos_revisar > 0)
                <div class="col-xl-3 col-md-6">
                    <div class="card-box tilebox-two">                   
                        <h6 class="text-muted text-uppercase mt-0">Mis acuerdos pendientes por revisar</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$mis_acuerdos_revisar}}</h3>
                        <?php $z=round(($mis_acuerdos_revisar*100)/$total_acuerdos); ?></h1>
                        <div class="progress progress-md">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                            style="width: {{$z}}%"  aria-valuenow="{{$mis_acuerdos_revisar}}" aria-valuemin="0"
                                aria-valuemax="{{$total_acuerdos}}"></div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xl-3 col-md-6">
                    <div class="card-box tilebox-two">
                        <h6 class="text-muted text-uppercase mt-0">Acuerdos del mes de {{$mes_letra}} </h6>
                        <h3 class="my-3" data-plugin="counterup">{{$acuerdos_mes}}</h3>
                        <div class="progress progress-md">
                            <?php $y=round(($acuerdos_mes*100)/$total_acuerdos); ?></h1>
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                style="width: {{$y}}%" aria-valuenow="{{$acuerdos_mes}}" aria-valuemin="0"
                                aria-valuemax="{{$total_acuerdos}}">
                            </div>
                        </div>
                        @if($acuerdos_mes_menos > $acuerdos_mes)
                        <?php $dif_year=$acuerdos_mes_menos-$acuerdos_mes; ?>
                        <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Mes
                            pasado</span>
                        @elseif($acuerdos_mes == $acuerdos_mes_menos)
                        <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Mes pasado</span>
                        @else
                        <?php $dif_year=$acuerdos_mes-$acuerdos_mes_menos; ?>
                        <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Mes
                            pasado</span>
                        @endif
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card-box tilebox-two">
                        <h6 class="text-muted text-uppercase mt-0">Acuerdos del año {{$year}}</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$acuerdos_year}}</h3>
                        <div class="progress progress-md">
                            <?php $z=round(($acuerdos_year*100)/$total_acuerdos); ?></h1>
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                style="width: {{$z}}%" aria-valuenow="{{$acuerdos_year}}" aria-valuemin="0"
                                aria-valuemax="{{$total_acuerdos}}">
                            </div>
                        </div>
                        @if($acuerdos_year_menos > $acuerdos_year)
                        <?php $dif_year=$acuerdos_year_menos-$acuerdos_year; ?>
                        <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Año
                            pasado</span>
                        @elseif($acuerdos_year == $acuerdos_year_menos)
                        <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Año pasado</span>
                        @else
                        <?php $dif_year=$acuerdos_year-$acuerdos_year_menos; ?>
                        <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Año
                            pasado</span>
                        @endif

                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card-box tilebox-two">
                        <i class="icon-chart float-right text-muted"></i>
                        <h6 class="text-primary text-uppercase">Total de acuerdos</h6>
                        <h3><span data-plugin="counterup">{{$total_acuerdos}}</span></h3>
                    </div>
                </div>
    </div>
</div>
<!-- end page title -->



<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="header-title">Descarga</h4>


            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                        <th>N° de expediente</th>
                        <th>Tipo de expediente</th>
                        <th>Tipo de acuerdo</th>
                        <th>N° folio de acuerdo</th>
                        <th>Versión</th>
                        <th>Revisar</th>
                      
                        <th>Estado del acuerdo</th>
                        <th>Estado del expediente</th>
                       
                        
                                                                    
                       
                        <th>Fecha de registro del acuerdo</th>                       
                        <th>Acuerdo modificado por</th>

                    </tr>
                </thead>


                <tbody>
                    @foreach($expedientes as $expediente)
                    <tr>
                        <td>{{$expediente->num_expediente}}</td>
                        <td>{{$expediente->tipo}}</td>
                        <td>{{$expediente->tipo_acuerdo}}</td>
                        <td>{{$expediente->num_folio}}</td>
                        <td>{{$expediente->version}}</td>
                        @if($expediente->estado_acuerdo =="ACUERDO_GENERADO" )
                        <td>
                            <a href="/revisarAcuerdo/{{$expediente->id_acuerdo}}"
                                class="btn waves-effect waves-light btn-info" role="button"><i
                                    class="pe-7s-hammer"></i></a>
                        </td>
                        @elseif($expediente->estado_acuerdo =="ACUERDO_REVISADO")
                        <td><span class="icon-check badge badge-success">Acuerdo revisado</span></td>
                        @else
                        <td></td>
                        @endif                                              
                        <td><span class="badge badge-success">{{$expediente->estado_acuerdo}}</span></td>
                        <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                        <td>{{$expediente->created_acuerdo}}</td>
                        <td>{{$expediente->captura_acuerdo}}</td>

                    </tr>
                    @endforeach                   
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- end row -->

</div> <!-- end container-fluid -->
@stop