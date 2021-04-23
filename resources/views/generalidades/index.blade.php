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
                        <li class="breadcrumb-item"><a href="/generalidades">Generalidades</a></li>
                        <li class="breadcrumb-item active">Listado de generalidades</li>
                    </ol>
                </div>
                <h4 class="page-title">Listado de generalidades registradas</h4>
                <a href="/expedientes/create" class="button-list">
                    <button type="button" class="btn btn-success waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-plus-box"></i>
                        </span>Registra nuevo ingreso</button>
                </a>
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
                            <th>Tipo</th>
                            <th>N° expediente</th>
                            <th>Fecha</th>
                            <th>Ver expediente</th>
                            <th>Editar</th>
                            <th>Borrar</th>
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th>Fecha de registro</th>
                            <th>Ultima actualización</th>
                            <th>Modificado por</th>

                        </tr>
                    </thead>


                    <tbody>
                        @foreach($generalidades as $generalidad)
                        <tr>
                        <td>{{$generalidad->tipo}}</td>
                        <td>{{$generalidad->num_expediente}}</td>
                            <td><strong>{{$generalidad->fecha}}<strong></td>
                            <td>


                                <a href="{{URL::action('generalidadesController@show',$generalidad->id)}}"
                                    class="btn waves-effect waves-light btn-info" role="button"><i
                                        class="mdi mdi-eye"></i></a>
                            </td>
                            <td> <a href="{{URL::action('ExpedientesController@edit',$generalidad->id)}}"
                                    class="btn waves-effect waves-light btn-primary" role="button"><i
                                        class="mdi mdi-account-edit-outline"></i></a>
                            </td>
                            @if($generalidad->estado == "ACTIVO")
                            <td> <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                                <a class="btn waves-effect waves-light btn-warning"
                                    onclick=inactivar('{{$generalidad->id}}','expedientes');
                                    style="margin-right: 10px;" role="button"><i class="mdi mdi-delete"></i></a>
                            </td>
                            <td><span class="badge badge-success">{{$generalidad->estado}}</span></td>

                            @else
                            <td>No aplica</td>
                            <td><span class="badge badge-danger">{{$generalidad->estado}}</span></td>
                            @endif
                            <td>{{$generalidad->ubicacion}}</td>
                            <td>{{$generalidad->created_at}}</td>
                            <td>{{$generalidad->updated_at}}</td>
                            <td>{{$generalidad->captura}}</td>

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