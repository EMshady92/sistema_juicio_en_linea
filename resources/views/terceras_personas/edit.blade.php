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
                        <li class="breadcrumb-item"><a href="/terceras_personas">Terceros interesados</a></li>
                        <li class="breadcrumb-item active">Edición de terceros interesados</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar tercer interesado</h4>

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
                            <h4 class="header-title">Formulario de edición</h4>
                            <p class="sub-header">
                                Formulario para editar : {{$tercera->nombre}} {{$tercera->apellido_paterno}} {{$tercera->apellido_materno}} {{$tercera->razon_social}}.
                            </p>




                            <form action="{{url('/terceras_personas', [$tercera->id])}}" method="post" class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8" >
                            {{csrf_field()}}

							<input type="hidden" name="_method" value="PUT">




                                <div class="form-group">
                                    <label for="userName">Tipo de Persona<span class="text-danger">*</span></label>
                                    <select class="form-control" name="tipoPersona"
                                        onchange="mostrar_datos(this.value);" id="tipoPersona" required
                                        data-toggle="select2">
                                        @if($tercera->tipo_persona == "FISICA" )
                                        <option >Seleccione una opción</option>
                                        <option value="FISICA" selected>Persona Fisica</option>
                                        <option value="MORAL">Persona Moral</option>
                                        @else
                                        <option >Seleccione una opción</option>
                                        <option value="FISICA">Persona Fisica</option>
                                        <option value="MORAL" selected>Persona Moral</option>
                                        @endif
                                    </select>

                                </div>

                                <div class="form-group" id='display_fisica' style='display:none;'>

                                    <div class="form-group">
                                        <label for="userName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" maxlength="30" minlength="1"  parsley-trigger="change" required
                                            placeholder="Ingresar el nombre" value="{{$tercera->nombre}}" class="form-control" id="nombre">
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Paterno<span class="text-danger">*</span></label>
                                        <input type="text" name="apellidoPaterno"  parsley-trigger="change" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido paterno" value="{{$tercera->apellido_paterno}}" onkeypress="return soloLetras(event)" class="form-control"
                                            id="apellidoPaterno">
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Materno<span class="text-danger"></span></label>
                                        <input type="text" name="apellidoMaterno"  parsley-trigger="change" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido materno" value="{{$tercera->apellido_materno}}" onkeypress="return soloLetras(event)" class="form-control"
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

                                </div>

                                <div class="form-group" id='display_moral' style='display:none;'>

                                <div class="form-group" >
                                    <label for="userName">Razón Social<span class="text-danger">*</span></label>
                                    <input type="text" name="razonSocial"  parsley-trigger="change" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                    onkeypress="return soloLetras(event)" value="{{$tercera->razon_social}}" placeholder="Ingresar el nombre" class="form-control" id="razonSocial">
                                </div>
                                 </div>

                                <div class="form-group">
                                     <label for="userName">Email<span class="text-danger">*</span></label>
                                     <input type="email" name="email" parsley-trigger="change" onchange="valida_email_terceras('0');"
                                         placeholder="Ingresar email" class="form-control" id="email" value="{{$tercera->email}}" required>
                                     <div class="text-danger" id='error_email' name="error_email" ></div>
                                 
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


<script type="text/javascript"> 
window.onload = function() {
    var tipo = '{{ $tercera->tipo_persona }}';
    mostrar_datos(tipo);
};

</script>
@endsection