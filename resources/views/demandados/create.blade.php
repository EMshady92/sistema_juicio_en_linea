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
                        <li class="breadcrumb-item"><a href="/demandados">Autoridades</a></li>
                        <li class="breadcrumb-item active">Registro de autoridades publicas demandadas</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nueva autoridad publica demandada</h4>

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
                                Formulario para registrar nueva dependencia publica demandada.
                            </p>




                            <form action="{{route('demandados.store')}}" method="post" id="formulario_demandado" onsubmit="return valida_nombreAutoridad('0');" class="form-horizontal parsley-examples">
                            {{csrf_field()}}

                            

                              

                                    <div class="form-group">
                                        <label for="userName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" onchange="valida_nombreAutoridad('0');" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" maxlength="60" minlength="1"  required parsley-trigger="change" 
                                            placeholder="Ingresar el nombre de la dependencia publica demandada" class="form-control" id="nombre">
                                            <div class="text-danger" id='error_nombre' name="error_nombre" ></div>
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