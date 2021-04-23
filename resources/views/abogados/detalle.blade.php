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
                        <li class="breadcrumb-item"><a href="/abogados">Abogados</a></li>
                        <li class="breadcrumb-item active">Detalles de abogados</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles del abogado: {{$abogado->nombre}} {{$abogado->apellido_paterno}} {{$abogado->apellido_materno}} . </h4>
                <div class="row">
                    <div class="col-6">

                    </div>
                    <div class="col-6 float-right">
                        <a href="/expedientes/create" class="button-list float-right">
                            <button type="button" class="btn btn-success waves-effect waves-light mb-3">
                                <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                                </span>Registrar nuevo expediente</button>
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
                                            <th>Nombre del abogado:</th>
                                            <td><select class="form-control" style="width: 100%" name="nombre_aut[]"
                                                    id="nombre_aut" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$abogado->nombre}}
                                                    </option>
                                                </select></td>

                                        </tr>      

                                          <tr class="bg-light text-dark">
                                            <th>Apellido paterno:</th>
                                            <td><select class="form-control" style="width: 100%" name="apellido_paterno[]"
                                                    id="apellido_paterno" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$abogado->apellido_paterno}}
                                                    </option>
                                                </select></td>

                                        </tr>      

                                          <tr class="bg-light text-dark">
                                            <th>Apellido materno:</th>
                                            <td><select class="form-control" style="width: 100%" name="apellido_materno[]"
                                                    id="apellido_materno" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$abogado->apellido_materno}}
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
                                            <th>Estado: </th>
                                            <td id="estado"><select class="form-control " style="width: 100%"
                                                    name="estado[]" id="estado" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$abogado->estado}}
                                                    </option>

                                                </select></td>
                                        </tr>


                                        <tr class="bg-light text-dark">
                                            <th>Modificado por : </th>
                                            <td><select class="form-control" style="width: 100%" name="captura_amparo[]"
                                                    id="captura_amparo" data-toggle="select2" multiple="multiple"
                                                    disabled>

                                                    <option value="{$amparo->captura}}" selected>
                                                        {{$abogado->captura}}
                                                    </option>
                                                </select></td>

                                        </tr>




                                        <tr class="bg-white text-dark">
                                            <th>Fecha de captura:</th>
                                            <td id="num_exp2"><select class="form-control " style="width: 100%"
                                                    name="created_amparo[]" id="created_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                        {{$abogado->created_at}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Ultima actualización: </th>
                                            <td> <select class="form-control s " style="width: 100%"
                                                    name="updated_amparo[]" id="updated_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$abogado->updated_at}}
                                                    </option>

                                                </select></td>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <h4 class="header-title">Expedientes relacionados</h4>
                    @if($expedientes)
                    <p class="sub-header">
                                Formulario que muestra todos los expedientes en lo que aparece el abogado .
                            </p>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>N° expediente</th>
                                    <th>Fecha</th>
                                    <th>Fecha de captura</th>
                                    <th>Estado</th>
                                    <th>Modificado por</th>
                                    <th>Ver expediente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expedientes as $expediente)
                                <tr>
                                    <td>{{$expediente->tipo}}</td>
                                    <td>{{$expediente->num_expediente}}</td>
                                    <td>{{$expediente->fecha}}</td>
                                    <td>{{$expediente->created_at}}</td>
                                    @if($expediente->estado == "ACTIVO")                                
                                    <td><span class="badge badge-success">{{$expediente->estado}}</span></td>
                                    @else                                   
                                    <td><span class="badge badge-danger">{{$expediente->estado}}</span></td>
                                    @endif
                                    <td>{{$expediente->captura}}</td>
                                    <td><a href='/ver_expediente/{{$expediente->id}}'
                                            class="btn waves-effect waves-light btn-info btn-sm" role="button">
                                            <i class="mdi mdi-eye"></i></a></td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="alert alert-warning" role="alert">
                        <strong>Lo sentimos!</strong> No hay expedientes registrados a este actor.
                    </div>
                    @endif


                </div>

            </div>

        </div>
        <!--FIN ROW PROMOCIONES Y AMPAROS-->




    </form>

</div> <!-- end container-fluid -->

@stop