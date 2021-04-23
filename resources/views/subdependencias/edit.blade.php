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
                        <li class="breadcrumb-item"><a href="/tiposDocumentos">Sub dependencias</a></li>
                        <li class="breadcrumb-item active">Edición Sub dependencias</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar Sub dependencia </h4>

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
                                Formulario para editar Sub dependencias
                            .
                            </p>




                            <form action="{{url('/subdependencias', [$subdependencias->id])}}" id="formulario" method="post" class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8" >
                            {{csrf_field()}}

							<input type="hidden" name="_method" value="PUT">

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
                                    parsley-trigger="change" value='{{$subdependencias->nombre}}' required placeholder="Ingresar el nombre"
                                    class="form-control" id="nombre">
                            </div>

                            <div class="form-group">
                                 <label for="emailAddress">Email<span class="text-danger">*</span></label>
                                <input type="email" name="email" parsley-trigger="change" value='{{$subdependencias->email}}' required
                                    placeholder="Ingresar el email" class="form-control" id="email">
                                <div class="text-danger" value="{{old('email')}}" id='error_email' name="error_email"></div>
                            </div>    

                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" placeholder="Ingresa el télefono celular" value='{{$subdependencias->telefono}}' name="telefono" id="telefono"
                                    data-mask="(492) 999-9999" class="form-control">
                                <span class="font-13 text-muted">(492) 999-9999</span>
                            </div>

                        </div>

                                


                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1"  id="submit" type="submit">
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


</script>
@endsection