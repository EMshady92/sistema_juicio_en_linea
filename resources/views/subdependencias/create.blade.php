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
                        <li class="breadcrumb-item"><a href="/actores">Sub dependencias</a></li>
                        <li class="breadcrumb-item active">Registro de Sub dependencias</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nueva Sub dependencia</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->



    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <h4 class="header-title">Formulario de registro</h4>
                            <p class="sub-header">
                                Formulario para registrar nuevas Sub dependencias.
                            </p>




                            <form action="{{route('subdependencias.store')}}" method="post"
                                id="formulario"
                                class="form-horizontal parsley-examples" files="true" enctype="multipart/form-data">
                                {{csrf_field()}}



                               <!-- <div class="form-group">
                                    <label for="userName">Tipo de Persona<span class="text-danger">*</span></label>
                                    <select class="form-control" style="width: 100%" name="tipoPersona"
                                        data-placeholder="Seleccione una opción ..."
                                        onchange="mostrar_datos(this.value);" id="tipoPersona" required
                                        data-toggle="select2">
                                        <option value="" selected>Seleccione una opción</option>
                                        <option value="AUTORIDAD">Autoridad</option>
                                        <option value="SUB">Subautoridad</option>
                                        <option value="FISICA">Persona Fisica</option>
                                        <option value="MORAL">Persona Moral</option>
                                    </select>

                                </div>


                                <div class="form-group" id='display_fisica' style='display:none;'> -->

                                <div class="form-group">
                                
                                        <label for="userName" class="col-sm-3 control-label">Autoridades<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control select2-multiple" name="id_dependencia"
                                            id="id_dependencia" data-toggle="select2" 
                                             style="width: 100%"
                                            required>
                                            <option value="" selected>Seleccione una opción</option>
                                            @foreach($personas as $personas)
                                            <option value="{{$personas->id}}">{{$personas->nombre}}
                                            </option>
                                            @endforeach
                                        </select>
                            </div>   

                                <div class="form-group">
                                    <label for="userName">Nombre<span class="text-danger">*</span></label>
                                    <input type="text" name="nombre"
                                        onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" 
                                        parsley-trigger="change" required placeholder="Ingresar el nombre"
                                        class="form-control" id="nombre">
                                </div>

                                <div class="form-group">
                                     <label for="emailAddress">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" parsley-trigger="change" onchange="valida_email_subdeps(value);" required
                                        placeholder="Ingresar el email" class="form-control" id="email">
                                    <div class="text-danger" value="{{old('email')}}" id='error_email_sub' name="error_email_sub"></div>
                                </div>    
 
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" placeholder="Ingresa el télefono celular" name="telefono" id="telefono"
                                        data-mask="(492) 999-9999" class="form-control">
                                    <span class="font-13 text-muted">(492) 999-9999</span>
                                </div>




                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" id="submit"
                                        type="submit">
                                        Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">
                                        Cancelar
                                    </button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div> <!-- end row -->








</div> <!-- end container-fluid -->
@stop