@extends('layouts.principal')
@section('contenido')


<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/acuerdos">Acuerdos</a></li>
                        <li class="breadcrumb-item active">Ver acuerdos</li>
                    </ol>
                </div>
                <h4 class="page-title">Ver los acuerdos generados para el expediente:
                    {{$acuerdos->num_expediente}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <form action="#" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card-box widget-user position-relative">
                                <img src="../img/martillo.png" class="avatar-md rounded-circle" alt="user">
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">{{$acuerdos->num_folio}}</p>
                                        <div class="user-position">
                                            <span class="text-warning font-weight-bold">Número de folio</span>
                                        </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                                    <i class="ion ion-md-paper font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-success text-uppercase">Tipo de acuerdo </h6>
                                    <h3>{{$acuerdos->tipo}}</h3>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-7">
                            <div class="card-box tilebox-three">
                                <div class="avatar-lg rounded-circle bg-light border border float-left">
                                    <i class=" mdi mdi-home-map-marker font-22 avatar-title text-muted"></i>
                                </div>
                                <div class="text-right">
                                    <h6 class="text-pink text-uppercase">Estado actual del acuerdo</h6>
                                    <h5>{{$acuerdos->estado}}</5>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card-box">
                                <h4 class="header-title">Datos</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">


                                        <tr class="bg-white text-dark">
                                            <th>Ultima actualización:</th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="ultima_ac[]" id="ultima_ac"
                                                    data-toggle="select2" value="{{$acuerdos->updated_at}}"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$acuerdos->updated_at}}" selected>
                                                        {{$acuerdos->updated_at}}
                                                    </option>

                                                </select></td>
                                        </tr>
                                        <tr class="bg-light text-dark">
                                            <th scope="row">Fecha de captura : </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="fecha_captura[]" id="fecha_captura"
                                                    data-toggle="select2" value="{{$acuerdos->created_at}}"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$acuerdos->created_at}}" selected>
                                                        {{$acuerdos->created_at}}
                                                    </option>

                                        </tr>
                                        <tr class="bg-white text-dark">
                                            <th>Modificado por: </th>
                                            <td id="num_exp"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="modificado[]" id="modificado"
                                                    data-toggle="select2" value="{{$acuerdos->captura}}"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$acuerdos->captura}}" selected>
                                                        {{$acuerdos->captura}}
                                                    </option>
                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Ultima observacion: </th>
                                            <td id="hojas_anexo"><select class="form-control " style="width: 100%"
                                                    data-toggle="select2" name="hojas_anexo[]" id="hojas_anexo"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$acuerdos->observaciones}}" selected>
                                                        {{$acuerdos->observaciones}}
                                                    </option>


                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Tiempo de contestacion: </th>
                                            <td id="hojas_escrito"><select class="form-control " style="width: 100%"
                                                    name="hojas_escrito[]" id="hojas_escrito" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$acuerdos->tiempo_contestacion}}" selected>
                                                        {{$acuerdos->tiempo_contestacion}} dias.
                                                    </option>

                                                </select></td>
                                        </tr>

                                        @if($promocion_relacionada)
                                        <tr class="bg-white text-dark">
                                            <th>Promoción relacionada: </th>
                                            <td id="hojas_escrito"><select class="form-control " style="width: 100%"
                                                    name="hojas_escrito[]" id="hojas_escrito" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option value="{{$acuerdos->tiempo_contestacion}}" selected>
                                                        Tipo: {{$promocion_relacionada->tipo}}, Folio:
                                                        {{$promocion_relacionada->folio}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        @endif



                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="col-lg-5">
                            <div class="card-box">
                                <h4 class="header-title">Ultima version generada</h4>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">


                                        <tr class="bg-white text-dark">
                                            <th>Versión:</th>
                                            <td id="version"><select class="form-control select2-multiple "
                                                    style="width: 100%" name="version[]" id="version"
                                                    data-toggle="select2" multiple="multiple" disabled>
                                                    <option value="{{$acuerdos->version}}" selected>
                                                        {{$acuerdos->version}}
                                                    </option>

                                                </select></td>
                                        </tr>
                                      
                                        <tr class="bg-white text-dark">
                                            <th>Vista previa del acuerdo: </th>
                                            <td id="hojas_traslados">
                                            <a href='../SALAS/acuerdos/{{$acuerdos->acuerdo}}'
                                                target="_blank" class="btn btn-danger waves-effect waves-light"
                                                role="button">
                                                <i class="fas fa-file-pdf"></i></a>
                                        </td>                                          
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Ver expediente completo: </th>
                                            <td>
                                                <a href="{{URL::action('ExpedientesController@show',$acuerdos->id_expediente)}}"
                                                    class="btn waves-effect waves-light btn-info" role="button"
                                                    target="_blank"><i class="mdi mdi-eye"></i></a>
                                            </td>
                                        </tr>




                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">

                                <h4 class="header-title">Versiones del acuerdo</h4>
                                @if($acuerdos)
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Versión</th>
                                                <th>Observaciones</th>

                                                <th>Ver texto</th>
                                                <th>Ver acuerdo</th>
                                                <th>Modificado por</th>
                                                <th>Fecha de captura</th>
                                                <th>Ultima actualización</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($versiones as $acuerdo)
                                            @include('acuerdos.modalAcuerdo')
                                            @include('acuerdos.modalText')
                                            <tr>
                                                <td>{{$acuerdo->version}}</td>
                                                <td>{{$acuerdo->observaciones}}</td>
                                                <td><button type="button" class="btn btn-info waves-effect waves-light "
                                                        data-toggle="modal" data-target="#modalText{{$acuerdo->id}}"
                                                        data-dismiss="modal" role="button">
                                                        <i class="fa fa-edit"></i></button></td>
                                                <td> <button type="button"
                                                        class="btn btn-danger waves-effect waves-light"
                                                        data-toggle="modal" data-target="#modalAcuerdo{{$acuerdo->id}}"
                                                        data-dismiss="modal">
                                                        <i class="mdi mdi-file-pdf"></i>
                                                    </button></td>
                                                <td>{{$acuerdo->captura}}</td>
                                                <td>{{$acuerdo->created_at}}</td>
                                                <td>{{$acuerdo->updated_at}}</td>


                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="alert alert-warning" role="alert">
                                    <strong>Lo sentimos!</strong> No hay acuerdos
                                    registrados en este
                                    expediente.
                                </div>
                                @endif



                            </div>
                        </div>

                    </div>
                    <!--FIN ROW PROMOCIONES Y AMPAROS-->







                </div>
            </div>
        </div> <!-- end row -->
</div> <!-- end row -->
</form>



</div> <!-- end container-fluid -->




@stop