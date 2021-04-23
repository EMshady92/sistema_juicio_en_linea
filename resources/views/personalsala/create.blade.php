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
                        <li class="breadcrumb-item active">Registro de salas-personal</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo usuario</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <form action="{{route('personalSala.store')}}" id="formsalamagistrado" method="post"
        class="form-horizontal parsley-examples">
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
                                        onchange="validaSalaMagistrado();validar_sala()" id="user" required
                                        data-toggle="select2">
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" selected>{{$user->name}}
                                            {{$user->apellido_p}} {{$user->apellido_m}} - {{$user->funcion}}</option>
                                        @endforeach
                                        <option value="" selected>Selecciona una opción... </option>
                                    </select>
                                    <div class="text-danger" id='error_sala_asg' name="error_sala_asg"></div>
                                </div>


                                <div class="form-group">
                                    <label for="userName">Función<span class="text-danger">*</span></label>
                                    <select class="form-control" style="width: 100%" name="funcion"
                                        data-placeholder="Seleccione una opción ..."
                                        onchange="validaSalaMagistrado('sala');" id="funcion" required
                                        data-toggle="select2">
                                        @foreach($funciones as $funcion)
                                        <option value="{{$funcion}}" selected>{{$funcion}} </option>
                                        @endforeach
                                        <option value="" selected>Selecciona una opción... </option>
                                    </select>
                                    <div class="text-danger" id='error_salas' name="error_salas"></div>

                                </div>



                                <div class="form-group">
                                    <label for="userName">Sala<span class="text-danger">*</span></label>
                                    <select class="form-control" style="width: 100%" name="sala"
                                        data-placeholder="Seleccione una opción ..."
                                        onchange="validaSalaMagistrado('sala');valida_magistrado();" id="sala" required
                                        data-toggle="select2">
                                        @foreach($salas as $sala)
                                        <option value="{{$sala->id}}" selected>{{$sala->num_sala}} </option>
                                        @endforeach
                                        <option value="" selected>Selecciona una opción... </option>
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