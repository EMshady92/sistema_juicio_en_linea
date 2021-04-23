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
                        <li class="breadcrumb-item"><a href="/salasMagistrado">Salas-personal</a></li>
                        <li class="breadcrumb-item active">Edición de salas-personal</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar asignación sala</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <form action="{{url('/personalSala', [$personal->id])}}" id="formsalapersonal" method="post"
        class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8">
        {{csrf_field()}}

        <input type="hidden" name="_method" value="PUT">
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="row">

                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <div>
                                <h4 class="header-title">Formulario de registro para asignar personal a salas</h4><br>
                                <div class="form-group">
                                    <label for="userName">Personal<span class="text-danger">*</span></label>
                                    <select class="form-control" style="width: 100%" name="user"
                                        data-placeholder="Seleccione una opción ..."
                                        onchange="validaSalaMagistrado('magistrado');" id="user" required
                                        data-toggle="select2">
                                        @foreach($users as $user)
                                        @if($personal->id_user == $user->id)
                                        <option value="{{$user->id}}" selected>{{$user->name}}
                                            {{$user->apellido_p}} {{$user->apellido_m}}</option>
                                        @else
                                        <option value="{{$user->id}}" >{{$user->name}}
                                            {{$user->apellido_p}} {{$user->apellido_m}}</option>
                                        @endif
                                        @endforeach
                                    </select>

                                </div>


                                <div class="form-group">
                                    <label for="userName">Función<span class="text-danger">*</span></label>
                                    <select class="form-control" style="width: 100%" name="funcion"
                                        data-placeholder="Seleccione una opción ..."
                                        onchange="validaSalaMagistrado('sala');" id="funcion" required
                                        data-toggle="select2">
                                        @foreach($funciones as $funcion)
                                        @if($personal->funcion == $funcion)
                                        <option value="{{$funcion}}" selected>{{$funcion}} </option>
                                        @else
                                        <option value="{{$funcion}}" >{{$funcion}} </option>
                                        @endif
                                        @endforeach                                       
                                    </select>
                                    <div class="text-danger" id='error_sala' name="error_sala"></div>

                                </div>



                                <div class="form-group">
                                    <label for="userName">Sala<span class="text-danger">*</span></label>
                                    <select class="form-control" style="width: 100%" name="sala"
                                        data-placeholder="Seleccione una opción ..."
                                        onchange="validaSalaMagistrado('sala');" id="sala" required
                                        data-toggle="select2">
                                        @foreach($salas as $sala)
                                        @if($sala->id == $personal->id_sala)
                                        <option value="{{$sala->id}}" selected>{{$sala->num_sala}} </option>
                                        @else
                                        <option value="{{$sala->id}}" >{{$sala->num_sala}} </option>
                                        @endif
                                        @endforeach                                      
                                    </select>
                                    <div class="text-danger" id='error_sala' name="error_sala"></div>

                                </div>

                                <br><br>
                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1"
                                        onsubmit="validaSalaMagistrado();" id="submit" type="submit">
                                        Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">
                                        Cancelar
                                    </button>
                                </div>
                            </div>

                        </div>



                    </div>


                </div>

            </div>


        </div> <!-- end row -->
    </form>








</div> <!-- end container-fluid -->
@stop