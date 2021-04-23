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
                        <li class="breadcrumb-item"><a href="/acuerdos">Expedientes</a></li>
                        <li class="breadcrumb-item active">Listado de acuerdos</li>
                    </ol>
                </div>
                <h4 class="page-title">Listado de acuerdos generados</h4>                        
            </div>
        </div>
        @if($mis_acuerdos_revisar > 0)
                <div class="col-xl-3 col-md-6">
                    <div class="card-box tilebox-two">
                    <a href="revisarAcuerdos" class="btn btn-sm btn-primary waves-effect waves-light float-right">Ver</a>
                        <h6 class="text-muted text-uppercase mt-0">Acuerdos de mi sala</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$mis_acuerdos_revisar}}</h3>
                        <?php $y=round(($mis_acuerdos_revisar*100)/$total_acuerdos); ?></h1>
                        <div class="progress progress-md">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                            style="width: {{$y}}%"  aria-valuenow="{{$mis_acuerdos_revisar}}" aria-valuemin="0"
                                aria-valuemax="{{$total_acuerdos}}"></div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-xl-3 col-md-6">
                    <div class="card-box tilebox-two">
                        <h6 class="text-muted text-uppercase mt-0">Total de acuerdos del mes de {{$mes_letra}} </h6>
                        <h3 class="my-3" data-plugin="counterup">{{$acuerdos_mes}}</h3>
                        <div class="progress progress-md">
                            <?php if($acuerdos_mes > 0){
                                $y=round(($acuerdos_mes*100)/$total_acuerdos);
                            }else{$y=0;} ?></h1>
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
                        <h6 class="text-muted text-uppercase mt-0">Total de acuerdos del año {{$year}}</h6>
                        <h3 class="my-3" data-plugin="counterup">{{$acuerdos_year}}</h3>
                        <div class="progress progress-md">
                            <?php if($acuerdos_year > 0){ $z=round(($acuerdos_year*100)/$total_acuerdos);}else{$z=0;} ?></h1>
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
                        <th>Promoción relacionada</th>
                        <th>Estado del acuerdo</th>
                        <th>Estado del expediente</th>
                        <th>Ver acuerdo</th>                     
                        <th>Sala</th>
                        <th>Asignado</th>
                        <th>Fecha</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                        <th>Fecha de registro del expediente</th>
                        <th>Ultima actualización del expediente</th>
                        <th>Fecha de registro del acuerdo</th>
                        <th>Expediente modificado por</th>
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
                        <td>Folio: {{$expediente->folio_promocion}} Tipo: {{$expediente->tipo_promocion}}</td>
                        <td><span class="badge badge-success">{{$expediente->estado_acuerdo}}</span></td>
                        <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>

                        <td>
                            <a href="{{URL::action('acuerdosController@show',$expediente->id_acuerdo)}}"
                                class="btn waves-effect waves-light btn-info" role="button"><i
                                    class="mdi mdi-eye"></i></a>
                        </td>                     
                        <td>{{$expediente->num_sala}}</td>
                        <td>{{$expediente->name_asig}} {{$expediente->apellido_pasig}}
                            {{$expediente->apellido_masig}}</td>
                        <td><strong>{{$expediente->fecha}}<strong></td>
                        <td> <a href="{{URL::action('acuerdosController@edit',$expediente->id_acuerdo)}}"
                                class="btn waves-effect waves-light btn-primary" role="button"><i
                                    class="mdi mdi-account-edit-outline"></i></a>
                        </td>
                        @if($expediente->estado == "ACTIVO")
                        <td> <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning"
                                onclick=inactivar('{{$expediente->id}}','expedientes'); style="margin-right: 10px;"
                                role="button"><i class="mdi mdi-delete"></i></a>
                        </td>
                        @else
                        <td>No aplica</td>
                        @endif

                        <td>{{$expediente->created_at}}</td>
                        <td>{{$expediente->updated_at}}</td>
                        <td>{{$expediente->created_acuerdo}}</td>
                        <td>{{$expediente->captura}}</td>
                        <td>{{$expediente->captura_acuerdo}}</td>

                    </tr>
                    @endforeach
                    @foreach($expedientes_sin as $expediente)
                    <tr>
                        <td>{{$expediente->num_expediente}}</td>
                        <td>{{$expediente->tipo}}</td>
                        <td>{{$expediente->tipo_acuerdo}}</td>
                        <td>{{$expediente->num_folio}}</td>
                        <td>{{$expediente->version}}</td>
                        <td><span class="badge badge-danger">Sin relación de
                                Promocion</span></td>
                        <td><span class="badge badge-success">{{$expediente->estado_acuerdo}}</span></td>
                        <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                        <td>
                            <a href="{{URL::action('acuerdosController@show',$expediente->id_acuerdo)}}"
                                class="btn waves-effect waves-light btn-info" role="button"><i
                                    class="mdi mdi-eye"></i></a>
                        </td>                     
                        <td>{{$expediente->num_sala}}</td>
                        <td>{{$expediente->name_asig}} {{$expediente->apellido_pasig}}
                            {{$expediente->apellido_masig}}</td>
                        <td><strong>{{$expediente->fecha}}<strong></td>
                        <td> <a href="{{URL::action('acuerdosController@edit',$expediente->id_acuerdo)}}"
                                class="btn waves-effect waves-light btn-primary" role="button"><i
                                    class="mdi mdi-account-edit-outline"></i></a>
                        </td>
                        @if($expediente->estado == "ACTIVO")
                        <td> <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                            <a class="btn waves-effect waves-light btn-warning"
                                onclick=inactivar('{{$expediente->id}}','expedientes'); style="margin-right: 10px;"
                                role="button"><i class="mdi mdi-delete"></i></a>
                        </td>

                        @else
                        <td>No aplica</td>
                        @endif

                        <td>{{$expediente->created_at}}</td>
                        <td>{{$expediente->updated_at}}</td>
                        <td>{{$expediente->created_acuerdo}}</td>
                        <td>{{$expediente->captura}}</td>
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