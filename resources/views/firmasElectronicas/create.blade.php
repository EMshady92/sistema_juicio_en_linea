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
                        <li class="breadcrumb-item"><a href="/firmaElectronica">Firmas electrónica</a></li>
                        <li class="breadcrumb-item active">Registro de firmas electrónica</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nueva firma electrónica</h4>

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
                                Formulario para registrar nueva firma electrónica (Certificado y llave privada).
                            </p>




                            <form action="{{route('firmaElectronica.store')}}" method="post" id="formulario_firma"  class="form-horizontal parsley-examples">
                            {{csrf_field()}}

                            

                              

                                    <div class="form-group">
                                        <label for="userName">Nombre del usuario<span class="text-danger">*</span></label>
                                        <select class="form-control" data-toggle="select2" name="usuario"
                                                    id="usuario"
                                                    data-placeholder="Seleccione una opción ..." onchange="validaFirma(this.value)" style="width: 100%"
                                                    required>
                                                    <option value="" selected>Seleccione una opción...</option>
                                                    @foreach($usuarios as $usuario)
                                                    <option value="{{$usuario->id}}">{{$usuario->name}}- {{$usuario->email}}</option>
                                                    @endforeach
                                                </select>
                                            <div class="text-danger" id='error_usuario' name="error_usuario" ></div>
                                    </div>

                                    
                                <div class="form-group">
                                    <label for="userName">Contraseña del certificado<span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" value="{{old('password')}}" required="" name="password" id="password"
                                        placeholder="Ingresa una contraseña">
                                </div>

                                <div class="form-group">
                                    <label for="userName">Confirma tu contraseña<span
                                            class="text-danger">*</span></label>
                                    <input class="form-control" type="password" value="{{old('password')}}" required="" id="password_confirmation"
                                        name="password_confirmation" onKeyUp="valida_contra();"
                                        placeholder="Repite la contraseña">
                                    <div class="text-danger" id='error_pass' name="error_pass"></div>
                                </div>
                                 
                                                           

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
@stop