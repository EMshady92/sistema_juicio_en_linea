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
                        <li class="breadcrumb-item active">Registro de abogados</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo abogado</h4>

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
                                Formulario para registrar nuevos abogados.
                            </p>




                            <form action="{{route('abogados.store')}}" method="post" class="form-horizontal parsley-examples"  files="true" enctype="multipart/form-data">
                            {{csrf_field()}}

                            

                              

                                    <div class="form-group">
                                        <label for="userName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" maxlength="30" minlength="1"  parsley-trigger="change" 
                                            placeholder="Ingresar el nombre" required class="form-control" id="nombre" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Paterno<span class="text-danger">*</span></label>
                                        <input type="text" name="apellidoPaterno"  parsley-trigger="change"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido paterno" required onkeypress="return soloLetras(event)" class="form-control"
                                            id="apellidoPaterno" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Materno<span class="text-danger">*</span></label>
                                        <input type="text" name="apellidoMaterno"  parsley-trigger="change" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido materno" onkeypress="return soloLetras(event)" class="form-control"
                                            id="apellidoMaterno" required>
                                    </div>

                                    <div class="form-group">
                                    <label for="sexo">Sexo<span class="text-danger">*</span></label><br>
                                    <select class="form-control" parsley-trigger="change" name="sexo" id="sexo" required
                                        data-toggle="select2">
                                        <option value='' selected>Seleccione una opción</option>
                                        <option value="MASCULINO">Masculino</option> 
                                        <option value="FEMENINO">Femenino</option>
                                    </select>
                                    <div class="text-danger" id='error_sexo' name="error_sexo" ></div>
                                    </div>

                                        <div class="form-group">
                                            <label for="userName">Email<span class="text-danger">*</span></label>
                                            <input type="email" name="emailAbogado" parsley-trigger="change"  onchange="valida_email_abogado('0');valida_sexo();"
                                                placeholder="Ingresar email" class="form-control" id="emailAbogado" required>
                                            <div class="text-danger" id='error_email' name="error_email" ></div>
                                        </div>

                                    <div class="form-group">
                                        <label for="userName">Número de Cédula<span class="text-danger">*</span></label>
                                        <input type="text" name="cedulaAbogado" parsley-trigger="change" onchange="valida_cedula_abogado('0');valida_sexo();"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingrese número de Cedula, maximo 8 digitos" onkeypress="return soloNumeros(event)" maxlength="8"
                                            class="form-control" id="cedulaAbogado" required>
                                            <div class="text-danger" id='error_num_cedula' name="error_num_cedula" ></div>    
                                    </div>

                                    
                                        <div class="col-lg-6">
                                            <div class="card-box">

                                                <h4 class="header-title mb-4" id='cedula_pro'>Subir Cédula</h4>

                                                <input type="file" accept=".pdf" id="file" required
                                                 name="file" class="dropify" data-max-file-size="3M" />
                                            </div>
                                        </div><!-- end col -->

                                    
                                                            

                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" id="submit" type="submit">
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
<script>
</script>
@stop