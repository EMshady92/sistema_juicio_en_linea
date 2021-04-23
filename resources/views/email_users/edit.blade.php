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
                        <li class="breadcrumb-item"><a href="/tiposDocumentos">Correos Usuarios</a></li>
                        <li class="breadcrumb-item active">Edición Correos Usuarios</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar Correo </h4>

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
                                Formulario para editar Correos
                            .
                            </p>




                            <form action="{{url('/email_users', [$emails_u->id])}}" id="formulario" method="post" class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8" >
                            {{csrf_field()}}

							<input type="hidden" name="_method" value="PUT">

                            <div class="form-group">
                                <label for="userName">Personas<span class="text-danger">*</span></label>
                                <select class="form-control" style="width: 100%" name="id_personas"
                                    data-placeholder="Seleccione una opción ..."
                                    id="id_personas" required
                                    data-toggle="select2">
                                    @foreach($personas as $persona)
                                    <option value="{{$persona->id}}" selected>{{$persona->nombre}}
                                        {{$persona->apellido_paterno}} {{$persona->apellido_materno}}</option>
                                    @endforeach
                                   
                                </select>
                                <div class="text-danger" id='error_sala_asg' name="error_sala_asg"></div>
                            </div>

                            <div class="form-group" >
                                <label for="AcuerdoName">Email<span class="text-danger">*</span></label>
                                <input type="email" name="email"  parsley-trigger="change" required 
                                 placeholder="Ingrese el Email" class="form-control" value='{{$emails_u->email}}' id="email">
                                 <div class="text-danger" id='error_email_users' name="error_email_users"></div>
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