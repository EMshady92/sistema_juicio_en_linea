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
                        <li class="breadcrumb-item active">Edición de autoridades demandadas</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar autoridad demandada</h4>

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
                            Formulario para editar : {{$demandado->nombre}} .
                            </p>




                            <form action="{{url('/demandados', [$demandado->id])}}" method="post" id="formulario_demandado" onsubmit="return valida_nombreAutoridad('{{$demandado->nombre}}');" class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8" >
                            {{csrf_field()}}

							<input type="hidden" name="_method" value="PUT">

                            

                              

                                    <div class="form-group">
                                        <label for="userName">Nombre<span class="text-danger">*</span></label>
                                        <input type="text" name="nombre" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        onkeypress="return soloLetras(event)" onchange="valida_nombreAutoridad('{{$demandado->nombre}}');" required maxlength="60" minlength="1"  parsley-trigger="change" 
                                            placeholder="Ingresar el nombre" class="form-control" value="{{$demandado->nombre}}" id="nombre">
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