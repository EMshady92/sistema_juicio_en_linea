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
                        <li class="breadcrumb-item"><a href="/magistradoExpedientes">Expedientes</a></li>
                        <li class="breadcrumb-item active">Listado de Expedientes</li>
                    </ol>
                </div>
                <h4 class="page-title">Listado de Expedientes</h4>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card-box tilebox-two">
                <a href="misExpedientes" class="btn btn-sm btn-primary waves-effect waves-light float-right">Ver</a>
                <h6 class="text-muted text-uppercase mt-0">Expedientes de mi sala </h6>
                <h3 class="my-3" data-plugin="counterup">{{$num}}</h3>
                <div class="progress progress-md">
                    <?php if($num <> null){$x=($num*100)/$total_expedientes;}else{$x=0;} ?></h1>
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$x}}%"
                        aria-valuenow="{{$num}}" aria-valuemin="0" aria-valuemax="{{$total_expedientes}}"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card-box tilebox-two">
                <h6 class="text-muted text-uppercase mt-0">Expedientes del mes de {{$mes_letra}} </h6>
                <h3 class="my-3" data-plugin="counterup">{{$expedientes_mes}}</h3>
                <div class="progress progress-md">
                    <?php if($expedientes_mes >0 && $total_expedientes>0){$y=($expedientes_mes*100)/$total_expedientes;}else{$y=0;} ?></h1>
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$y}}%"
                        aria-valuenow="{{$expedientes_mes}}" aria-valuemin="0" aria-valuemax="{{$total_expedientes}}">
                    </div>
                </div>
                @if($expedientes_mes_menos > $expedientes_mes)
                <?php $dif_year=$expedientes_mes_menos-$expedientes_mes; ?>
                <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Mes pasado</span>
                @elseif($expedientes_mes == $expedientes_mes_menos)
                <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Mes pasado</span>
                @else
                <?php $dif_year=$expedientes_mes-$expedientes_mes_menos; ?>
                <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Mes
                    pasado</span>
                @endif
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card-box tilebox-two">
                <h6 class="text-muted text-uppercase mt-0">Expedientes del año {{$year}}</h6>
                <h3 class="my-3" data-plugin="counterup">{{$expedientes_year}}</h3>
                <div class="progress progress-md">
                    <?php if($expedientes_year >0  && $total_expedientes>0 ){
                    $z=($expedientes_year*100)/$total_expedientes;
                    }else{
                    $z=0;} ?></h1>
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: {{$z}}%"
                        aria-valuenow="{{$expedientes_year}}" aria-valuemin="0" aria-valuemax="{{$total_expedientes}}">
                    </div>
                </div>
                @if($expedientes_year_menos > $expedientes_year)
                <?php $dif_year=$expedientes_year_menos-$expedientes_year; ?>
                <span class="badge badge-danger mr-1"> -{{$dif_year}} </span> <span class="text-muted">Año pasado</span>
                @elseif($expedientes_year == $expedientes_year_menos)
                <span class="badge badge-warning mr-1"> 0 </span> <span class="text-muted">Año pasado</span>
                @else
                <?php $dif_year=$expedientes_year-$expedientes_year_menos; ?>
                <span class="badge badge-success mr-1"> +{{$dif_year}} </span> <span class="text-muted">Año
                    pasado</span>
                @endif

            </div>
        </div>



        <div class="col-xl-3 col-md-6">
            <div class="card-box tilebox-two">
                <i class="icon-chart float-right text-muted"></i>
                <h6 class="text-primary text-uppercase">Total de expedientes</h6>
                <h3><span data-plugin="counterup">{{$total_expedientes}}</span></h3>
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
                        <th>Tipo de expediente</th>
                            <th>Número de expediente</th>
                            <th>Sala</th>
                            <th>Magistrado</th>                            
                            <th>Estado</th>
                            @if($user->funcion == "ADMINISTRADOR")
                            <th>Validar</th>
                            <th>Asignar</th>
                            @endif
                            <th>Fecha</th>
                            <th>Ver expediente</th>
                          
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>
                            <th>Modificado por</th>


                        </tr>
                    </thead>


                    <tbody>
                    @foreach($expedientes as $expediente)
                        @include('magistradoExpedientes.modal')
                        <tr>
                            <td>{{$expediente->tipo}}</td>
                            <td>{{$expediente->num_expediente}}</td>
                            <td>{{$expediente->num_sala}}</td>
                            <td>{{$expediente->name}} {{$expediente->apellido_p}} {{$expediente->apellido_m}}</td>
                            @if($expediente->estado == "ACTIVO")
                            <td><span class="badge badge-success">{{$expediente->estado}}</span></td>
                            @else
                            <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                            @endif
                            @if($user->funcion == "ADMINISTRADOR")
                                @if($expediente->estado == "POR_VALIDAR")
                                <td>
                                <a data-target="#modal-{{$expediente->id}}" data-toggle="modal"
                                        class="btn waves-effect waves-light btn-success" role="button"><i
                                            class="ion ion-md-checkmark-circle"></i></a>
                                </td>
                                <td><span class="badge badge-danger">No disponible</span></td>
                            @elseif($expediente->estado == "POR_ASIGNAR")
                                <td><span class="badge badge-danger">No aplica</span></td>
                           
                                        <td> 
                                            <a class="btn waves-effect waves-light btn-primary" data-toggle="modal"
                                                data-target="#modal{{$expediente->id_expediente_sala}}" data-dismiss="modal"><i
                                                    class="mdi mdi-account-edit-outline"></i></a>
                                        </td>
                                       
                                    
                                
                                    
                            @else
                            <td><span class="badge badge-danger">No disponible</span></td>
                            <td><span class="badge badge-danger">No disponible</span></td>
                            @endif
                            @endif
                            <td><strong>{{$expediente->fecha}}<strong></td>

                            <td>


                                <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                    class="btn waves-effect waves-light btn-info" role="button"><i
                                        class="mdi mdi-eye"></i></a>
                            </td>                          

                            <td>{{$expediente->created_at}}</td>
                            <td>{{$expediente->updated_at}}</td>
                            <td>{{$expediente->captura}}</td>

                        </tr>
                        @include('magistradoExpedientes.modalasigns')
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- end row -->

</div> <!-- end container-fluid -->
@stop