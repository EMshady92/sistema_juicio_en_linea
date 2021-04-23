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
                        <li class="breadcrumb-item"><a href="/personas">{{$actor->tipo}}</a></li>
                        <li class="breadcrumb-item active">Edición de {{$actor->tipo}}</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar {{$actor->tipo}}</h4>

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
                                Formulario para editar : {{$actor->nombre}} {{$actor->apellido_paterno}}
                                {{$actor->apellido_materno}} {{$actor->razon_social}}.
                            </p>




                            <form action="{{url('/personas', [$actor->id])}}" id="formulario" method="post"
                                class="form-horizontal parsley-examples" enctype="multipart/form-data"
                                accept-charset="UTF-8">
                                {{csrf_field()}}

                                <input type="hidden" name="_method" value="PUT">




                                <div class="form-group">
                                    <label for="userName">Tipo de Persona<span class="text-danger">*</span></label>
                                    <select class="form-control" name="tipoPersona"
                                        onchange="mostrar_datos(this.value);" id="tipoPersona" required
                                        data-toggle="select2">
                                        @if($actor->tipo == "FISICA" )
                                        <option value="FISICA" selected>Persona Fisica</option>
                                        <option value="MORAL">Persona Moral</option>
                                        <option value="AUTORIDAD">Autoridad</option>
                                        <option value="SUB">Subautoridad</option>
                                        @elseif($actor->tipo == "MORAL" )
                                        <option value="AUTORIDAD">Autoridad</option>
                                        <option value="SUB">Subautoridad</option>
                                        <option value="FISICA">Persona Fisica</option>
                                        <option value="MORAL" selected>Persona Moral</option>
                                        @elseif($actor->tipo == "AUTORIDAD" )
                                        <option value="AUTORIDAD" selected>Autoridad</option>
                                        <option value="SUB">Subautoridad</option>
                                        <option value="FISICA">Persona Fisica</option>
                                        <option value="MORAL">Persona Moral</option>
                                        @elseif($actor->tipo == "SUB" )
                                        <option value="AUTORIDAD">Autoridad</option>
                                        <option value="SUB" selected>Subautoridad</option>
                                        <option value="FISICA">Persona Fisica</option>
                                        <option value="MORAL">Persona Moral</option>
                                        @endif
                                    </select>

                                </div>

                                <div class="form-group" id='display_fisica' style='display:none;'>

                                    <div class="form-group">
                                        <label for="userName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="nombre"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            onkeypress="return soloLetras(event)" maxlength="30" minlength="1"
                                            parsley-trigger="change" required placeholder="Ingresar el nombre"
                                            value="{{$actor->nombre}}" class="form-control" id="nombre">
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Paterno<span class="text-danger">*</span></label>
                                        <input type="text" name="apellidoPaterno" parsley-trigger="change" required
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido paterno"
                                            value="{{$actor->apellido_paterno}}" onkeypress="return soloLetras(event)"
                                            class="form-control" id="apellidoPaterno">
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">Apellido Materno<span class="text-danger"></span></label>
                                        <input type="text" name="apellidoMaterno" parsley-trigger="change"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingresar el apellido materno"
                                            value="{{$actor->apellido_materno}}" onkeypress="return soloLetras(event)"
                                            class="form-control" id="apellidoMaterno">
                                    </div>

                                    <div class="form-group">
                                        <label for="sexo">Sexo<span class="text-danger">*</span></label><br>
                                        <select class="form-control" data-placeholder="Seleccione una opción ..."
                                            style="width: 100%" name="sexo" id="sexo" data-toggle="select2">
                                            @if($actor->sexo == "MASCULINO")
                                            <option value="MASCULINO" selected>Masculino</option>
                                            <option value="FEMENINO">Femenino</option>
                                            @else
                                            <option value="MASCULINO">Masculino</option>
                                            <option value="FEMENINO" selected>Femenino</option>
                                            @endif
                                        </select>

                                    </div>

                                    <div class="form-group">
                                        <label for="userName">CURP</label>
                                        <input type="text" name="curp" parsley-trigger="change"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            onkeypress="return soloLetras(event)" value="{{$actor->curp}}"
                                            placeholder="Ingresar su CURP" class="form-control" id="curp">
                                    </div>


                                    <div class="form-group">
                                        <label for="userName">Esta persona es abogado<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" style="width: 100%" name="abogado"
                                            data-placeholder="Seleccione una opción ..."
                                            onchange="mostrar_datos(this.value);" id="abogado" data-toggle="select2">
                                            @if($actor->num_cedula <> null)
                                                <option value="SI" selected>SI</option>
                                                <option value="NO">NO</option>
                                                @else
                                                <option value="SI">SI</option>
                                                <option value="NO" selected>NO</option>
                                                @endif
                                        </select>

                                    </div>

                                </div>

                                <div class="form-group" id='display_autoridad' style='display:none;'>

                                    <div class="form-group">
                                        <label for="userName">Nombre de la autoridad<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nombre_aut"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            onkeypress="return soloLetras(event)" maxlength="50" minlength="1"
                                            parsley-trigger="change" value="{{$actor->nombre}}"
                                            placeholder="Ingresar el nombre de la autoridad" class="form-control"
                                            id="nombre_aut">
                                    </div>
                                </div>


                                <div class="form-group" id='display_sub' style='display:none;'>
                                    <div class="form-group">
                                        <label for="userName">Seleccione autoridad a la que pertenece<span
                                                class="text-danger">*</span></label>
                                        <select class="form-control" style="width: 100%" name="autoridad"
                                            data-placeholder="Seleccione una opción ..." id="autoridad"
                                            data-toggle="select2">
                                            <option value="" selected>Seleccione una opción</option>
                                            @foreach($autoridades as $autoridad)
                                            <option value="{{$autoridad->id}}">{{$autoridad->nombre}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group" id='display_abogado' style='display:none;'>

                                    <div class="form-group">
                                        <label for="userName">Número de Cédula<span class="text-danger">*</span></label>
                                        <input type="text" name="cedulaAbogado" parsley-trigger="change"
                                            onchange="valida_cedula_abogado('0');valida_sexo();"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            placeholder="Ingrese número de Cedula, maximo 8 digitos"
                                            onkeypress="return soloNumeros(event)" value="{{$actor->num_cedula}}" maxlength="8" class="form-control"
                                            id="cedulaAbogado">
                                        <div class="text-danger" id='error_num_cedula' name="error_num_cedula"></div>
                                    </div>


                                    <div class="col-lg-6">
                                        <div class="card-box">

                                            <h4 class="header-title mb-4" id='cedula_pro'>Subir Cédula</h4>

                                            <input type="file" accept=".pdf" id="file" value="OFICIALIA/archivos/cedulas/{{$actor->num_cedula}}" name="file" class="dropify"
                                                data-max-file-size="3M" />
                                        </div>
                                    </div><!-- end col -->

                                </div>


                                <div class="form-group" id='display_moral' style='display:none;'>

                                    <div class="form-group">
                                        <label for="userName">Razón Social<span class="text-danger">*</span></label>
                                        <input type="text" name="razonSocial" parsley-trigger="change" required
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            onkeypress="return soloLetras(event)" value="{{$actor->razon_social}}"
                                            placeholder="Ingresar el nombre" class="form-control" id="razonSocial">
                                    </div>

                                    <div class="form-group">
                                        <label for="userName">RFC</label>
                                        <input type="text" name="rfc" parsley-trigger="change"
                                            onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                            onkeypress="return soloLetras(event)" value="{{$actor->rfc}}" placeholder="Ingresar el RFC"
                                            class="form-control" id="rfc">
                                    </div>

                                </div>






                                <div class="form-group">
                                    <label for="emailAddress">Email<span class="text-danger">*</span></label>
                                    <input type="email" name="email" parsley-trigger="change" required
                                        placeholder="Ingresar el email" value="{{$actor->email}}"
                                        onchange="valida_email('{{$actor->email}}');" class="form-control" id="email">
                                    <div class="text-danger" id='error_email' name="error_email"></div>
                                </div>

                                <div class="form-group">
                                    <label>Teléfono Celular</label>
                                    <input type="text" placeholder="Ingresa el télefono celular" value="{{$actor->celular}}" name="celular" id="celular"
                                        data-mask="(492) 999-9999" class="form-control">
                                    <span class="font-13 text-muted">(492) 999-9999</span>
                                </div>

                                <div class="form-group">
                                    <label>Teléfono Oficina</label>
                                    <input type="text" placeholder="Ingresa el télefono de oficina" value="{{$actor->telefono}}" name="telefono" id="telefono"
                                        data-mask="(492) 999-9999" class="form-control">
                                    <span class="font-13 text-muted">(492) 999-9999</span>
                                </div>





                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1 " id="submit"
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


<script type="text/javascript">
window.onload = function() {
    var tipo = '{{ $actor->tipo }}';
    var cedula= '{{$actor->num_cedula}}';    
    mostrar_datos(tipo);

    if(cedula != ""){
        mostrar_datos('SI');

    }else{
        mostrar_datos('NO');

    }
};
</script>
@endsection
@section('javascript')
<script type="text/javascript">
$('.submit_button').click(function () {
           
           Swal.fire({
               title: 'Estas seguro de guardar cambios?',
               icon: 'question',
               showDenyButton: true,
               showCancelButton: true,
               confirmButtonText: `Si`,
               denyButtonText: `No`,
             }).then((result) => {
               /* Read more about isConfirmed, isDenied below */
               if (result.isConfirmed) {
       
                 let fmr =  document.getElementById("formulario");
                 const submitFormFunction = Object.getPrototypeOf(fmr).submit ;
                 submitFormFunction.call(formulario);
                 Swal.fire('Guardado!', '', 'success')
               } else if (result.isDenied) {
                 Swal.fire('Cancelado', '', 'info')
               }
             })
              
       });



       

</script>
@endsection