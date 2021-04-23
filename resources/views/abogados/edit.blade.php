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
                        <li class="breadcrumb-item active">Edición de abogados</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar abogado</h4>

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
                            Formulario para editar : {{$abogado->nombre}} {{$abogado->apellido_paterno}} {{$abogado->apellido_materno}} .
                            </p>




                            <form action="{{url('/abogados', [$abogado->id])}}" method="post" class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8" >
                            {{csrf_field()}}

							<input type="hidden" name="_method" value="PUT">

                            

                              

                                    <div class="form-group">
                                        <label for="userName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" required maxlength="30" minlength="1"  parsley-trigger="change" 
                                            placeholder="Ingresar el nombre" class="form-control" value="{{$abogado->nombre}}" id="nombre">
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Paterno<span class="text-danger">*</span></label>
                                        <input type="text" name="apellidoPaterno"  required parsley-trigger="change"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido paterno" value="{{$abogado->apellido_paterno}}" onkeypress="return soloLetras(event)" class="form-control"
                                            id="apellidoPaterno">
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Materno<span class="text-danger"></span></label>
                                        <input type="text" name="apellidoMaterno"  parsley-trigger="change" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido materno"  value="{{$abogado->apellido_materno}}" onkeypress="return soloLetras(event)" class="form-control"
                                            id="apellidoMaterno">
                                    </div>

                                    <div class="form-group">
                                    <label for="sexo">Sexo<span class="text-danger">*</span></label><br>
                                    <select class="form-control" name="sexo" id="sexo" required
                                        data-toggle="select2">
                                        <option selected>Seleccione una opción</option>
                                        <option value="MASCULINO">Masculino</option>
                                        <option value="FEMENINO">Femenino</option>
                                    </select>

                                    </div>

                                    <div class="form-group">
                                            <label for="userName">Email<span class="text-danger">*</span></label>
                                            <input type="email" name="emailAbogado" parsley-trigger="change" onchange="valida_email_abogado('0');"
                                                placeholder="Ingresar email" value="{{$abogado->email}}" class="form-control" id="emailAbogado" required>
                                            <div class="text-danger" id='error_email' name="error_email" ></div>
                                        </div>

                                    <div class="form-group">
                                        <label for="userName">Número de Cédula<span class="text-danger">*</span></label>
                                        <input type="text" name="cedulaAbogado" parsley-trigger="change" onchange="valida_cedula_abogado('0');"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingrese número de Cedula, maximo 8 digitos" value="{{$abogado->num_cedula}}" onkeypress="return soloNumeros(event)" maxlength="8"
                                            class="form-control" id="cedulaAbogado" required>
                                            <div class="text-danger" id='error_num_cedula' name="error_num_cedula" ></div>    
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="card-box">

                                                <h4 class="header-title mb-4" id='cedula_pro'>Subir Cédula</h4>

                                                <input type="file" accept=".pdf" id="file" required=""
                                                 name="file" class="dropify" data-max-file-size="3M" />
                                            </div>
                                        </div><!-- end col -->

                                    </div>
                                                           

                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" type="submit">
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