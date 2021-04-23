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
                        <li class="breadcrumb-item"><a href="/tiposDocumentos">Tipos de Documentos</a></li>
                        <li class="breadcrumb-item active">Edición tipo de documento</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar tipo de documento </h4>

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
                                Formulario para editar : {{$tipo->tipo_documento}} 
                            .
                            </p>




                            <form action="{{url('/tiposDocumentos', [$tipo->id])}}" id="formulario" method="post" class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8" >
                            {{csrf_field()}}

							<input type="hidden" name="_method" value="PUT">

                            <div class="form-group" >
                                    <label for="AcuerdoName">Tipo de documento<span class="text-danger">*</span></label>
                                    <input type="text" name="tipo"  parsley-trigger="change" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                     value="{{$tipo->tipo_documento}}" class="form-control" id="tipo">
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