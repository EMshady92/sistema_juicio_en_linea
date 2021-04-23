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
                        <li class="breadcrumb-item"><a href="/misFirmas">Mis Firmas electrónicas</a></li>
                        <li class="breadcrumb-item active">Validar Firma</li>
                    </ol>
                </div>
                <h4 class="page-title">Validar Firma </h4>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="/validarFiel" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                  
                    <!--Fin del row -->
                      <h3>Ingrese sus credenciales</h3>
                     <div class="row">
                    <div class="col-lg-6">

                        <div class="card-box">

                            <div class="form-group">
                            <label for="userName">Propietario de la firma<span class="text-danger">* </span></label>
                            <select class="form-control" style="width: 100%" name="firmante" id="firmante" required
                                data-placeholder="Seleccione una opción ...">
                                <option value="" selected>Seleccione una opción</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">
                                {{$user->funcion}}: {{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}
                                </option>
                                @endforeach
                            </select>
                            <div class="text-danger" id='error_tipo_acuerdo' name="error_tipo_acuerdo"></div>

                        </div>
                            <h4 class="header-title mb-6" id='escanesc'>Certificado .cert</h4>

                            <input type="file" accept=".cer" id="certificado" value="{{old('certificado')}}" required
                                name="certificado" class="dropify" data-max-file-size="1M" />
                        </div>


                    </div>

                    <div class="col-lg-6">
                        <div class="card-box">

                            <h4 class="header-title mb-6" id='escanesc'>Llave privada .key</h4>

                            <input type="file" accept=".key" id="key" required name="key" value="{{old('key')}}"
                                class="dropify" data-max-file-size="1M" />
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="card-box">

                            <label for="userName">Contraseña del certificado<span class="text-danger">*</span></label>
                            <input class="form-control" type="password" value="{{old('password')}}" required=""
                                name="password" id="password" placeholder="Ingresa una contraseña">
                        </div>
                    </div><!-- end col -->

                </div>
                
                
                            <div class="form-group text-right mb-0">
                                <button class="btn btn-primary waves-effect waves-light mr-1" id="submit" type="submit">
                                    Guardar
                                </button>
                                <button type="reset" class="btn btn-secondary waves-effect">
                                    Cancelar
                                </button>
                            </div>




                </div>
            </div>
        </div>
        <!-- end row -->




    </form>

</div> <!-- end container-fluid -->

@stop