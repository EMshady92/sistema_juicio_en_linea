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
                        <li class="breadcrumb-item"><a href="/">Actos</a></li>
                        <li class="breadcrumb-item"><a href="/actores">Actos</a></li>
                        <li class="breadcrumb-item active">Edición tipos de Actos</li>
                    </ol>
                </div>
                <h4 class="page-title">Editar Acto</h4>

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
                                Formulario para editar : {{$promociones->tipo_promocion}} 
                            .
                            </p>




                            <form action="{{url('/tipos_promociones', [$promociones->id])}}" id="formulario" method="post" class="form-horizontal parsley-examples" enctype="multipart/form-data" accept-charset="UTF-8" >
                            {{csrf_field()}}

							<input type="hidden" name="_method" value="PUT">

                            <div class="form-group" >
                                    <label for="AcuerdoName">Nombre<span class="text-danger">*</span></label>
                                    <input type="text" name="tipo_promocion"  parsley-trigger="change" required onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                     value="{{$promociones->tipo_promocion}}" class="form-control" id="tipo_promocion">
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