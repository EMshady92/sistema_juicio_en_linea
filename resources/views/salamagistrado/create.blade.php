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
                        <li class="breadcrumb-item"><a href="/salasMagistrado">Salas-magistrados</a></li>
                        <li class="breadcrumb-item active">Registro de salas-magistrados</li>
                    </ol>
                </div>
                <h4 class="page-title">Registrar nuevo usuario</h4>

            </div>
        </div>
    </div>
    <!-- end page title -->


    <form action="{{route('salasMagistrado.store')}}" id="formsalamagistrado" method="post"
        class="form-horizontal parsley-examples">
        <div class="row">
            <div class="col-12">
                <div class="card-box">

                    <div class="row">

                        {{csrf_field()}}
                        <div class="col-lg-6">
                            <div>
                                <h4 class="header-title">Formulario de registro para nuevas salas-magistrados</h4><br>



                                <div class="form-group">
                                        <label for="userName">Sala<span class="text-danger">*</span></label>
                                        <input type="text" name="sala" id="sala" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                        o onchange="validaSalaMagistrado('sala');" maxlength="30" minlength="1"  parsley-trigger="change" required
                                            placeholder="Ingresar el número de sala" class="form-control">
                                            <div class="text-danger" id='error_sala' name="error_sala"></div>
                                    </div>


                                <br><br>
                                <div class="form-group text-right mb-0">
                                    <button class="btn btn-primary waves-effect waves-light mr-1"
                                        onsubmit="return validaSalaMagistrado('sala');" id="submit" type="submit">
                                        Guardar
                                    </button>
                                    <button type="reset" class="btn btn-secondary waves-effect">
                                        Cancelar
                                    </button>
                                </div>

                            </div>




                        </div>


                    </div>

                </div>


            </div> <!-- end row -->
    </form>








</div> <!-- end container-fluid -->
@stop
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
       
                 let fmr =  document.getElementById("formsalamagistrado");
                 const submitFormFunction = Object.getPrototypeOf(fmr).submit ;
                 submitFormFunction.call(formsalamagistrado);
                 Swal.fire('Guardado!', '', 'success')
               } else if (result.isDenied) {
                 Swal.fire('Cancelado', '', 'info')
               }
             })
              
       });


       

</script>
@endsection