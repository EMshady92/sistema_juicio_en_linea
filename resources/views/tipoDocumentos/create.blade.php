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
                        <li class="breadcrumb-item"><a href="/tiposDocumentos">Documentos</a></li>
                        <li class="breadcrumb-item active">Registro de tipos de docuemntos</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo tipo de documento</h4>

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
                                Formulario para registrar nuevos tipos de docuemntos.
                            </p>




                            <form action="{{route('tiposDocumentos.store')}}" method="post" id="formulario" class="form-horizontal parsley-examples">
                            {{csrf_field()}}


                               

                             

                                <div class="form-group" >
                                    <label for="AcuerdoName">Tipo de documento<span class="text-danger">*</span></label>
                                    <input type="text" name="tipo"  parsley-trigger="change" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                     placeholder="Ingrese el nombre del tipo de documento" class="form-control" id="tipo">
                                </div>
                                 </div>

            

                                


                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1" id="submit"  type="submit">
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