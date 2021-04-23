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
                        <li class="breadcrumb-item"><a href="/firmaElectronica">Firma electrónica</a></li>
                        <li class="breadcrumb-item active">Detalles de firma electrónica</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalles del documento firmado por: {{$datos_firma['firmante']}} . </h4>
                  <div class="row">
                @if($_validaAsig == 0)
                
                        <div class="col-xl-3 col-md-6">
                             <a href="../FIRMASEMITIDAS/PDF/{{$firma_a->pdf}}" target="_blank" class="button-list">
                            <div class="card-box widget-user position-relative">
                              <i class="mdi mdi-file-pdf-box font-22 avatar-title text-muted"></i>
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">PDF</h5>
                                    <p class="text-muted mb-0 font-13">Imprimir documento con firma electronica.</p>
                                    <div class="user-position">
                                        <span class="text-danger font-weight-bold">FIEL</span>
                                    </div>
                                </div>
                            </div></a>
                        </div>
                @else
                <div class="wid-u-info">
                     <h6 class="text-success  mt-3 mb-1 font-16">Firma aplicada correctamente.</h6>
                                    <h7 class="text-danger  mt-3 mb-1 font-16">El documento aún no se puede imprimir hasta que estén completas todas las firmas.</h7>
                                </div>
                
                @endif
                        @if($version_ant <> "")
                        <div class="col-xl-3 col-md-6">
                            <a href="../SALAS/acuerdos/{{$version_ant}}" target="_blank" class="button-list">
                            <div class="card-box widget-user position-relative">
                               <i class="mdi mdi-file-pdf-box font-22 avatar-title text-muted"></i>
                                <div class="wid-u-info">
                                    <h5 class="mt-3 mb-1 font-16">PDF</h5>
                                    <p class="text-muted mb-0 font-13">Imprimir documento sin firma electronica.</p>
                                    <div class="user-position">
                                        <span class="text-danger font-weight-bold">Firma</span>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                        @endif

                        



                    </div>


               

            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="" id="form" method="post" files="true" enctype="multipart/form-data"
        class="form-horizontal parsley-examples">
        {{csrf_field()}}

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <h4 class="header-title">Datos de la firma:</h4>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">

                                     

                                        
                                        <tr class="bg-light text-dark">
                                            <th>Nombre del firmante:</th>
                                            <td><select class="form-control" style="width: 100%" name="nombre"
                                                    id="nombre" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                       {{$datos_firma['firmante']}}
                                                    </option>
                                                </select></td>

                                        </tr>  

                                        <tr class="bg-light text-dark">
                                            <th>Email:</th>
                                            <td><select class="form-control" style="width: 100%" name="email"
                                                    id="email" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$datos_firma['email_firmante']}}
                                                    </option>
                                                </select></td>

                                        </tr>     

                                        <tr class="bg-light text-dark">
                                            <th>Puesto o función:</th>
                                            <td><select class="form-control" style="width: 100%" name="puesto"
                                                    id="puesto" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$datos_firma['funcion_firmante']}}
                                                    </option>
                                                </select></td>

                                        </tr>   
                                        
                                         <tr class="bg-white text-dark">
                                            <th>Número de serie de la firma: </th>
                                            <td ><select class="form-control " style="width: 100%"
                                                    name="serial" id="serial" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                       {{$datos_firma['num_firma']}}
                                                    </option>

                                                </select></td>
                                        </tr>


                                        <tr class="bg-light text-dark">
                                            <th>Generado por : </th>
                                            <td><select class="form-control" style="width: 100%" name="captura"
                                                    id="captura" data-toggle="select2" multiple="multiple"
                                                    disabled>

                                                    <option value="{$amparo->captura}}" selected>
                                                       {{$datos_firma['firmante']}}
                                                    </option>
                                                </select></td>

                                        </tr>


                                      
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">



                                        <tr class="bg-white text-dark">
                                            <th>Fecha de emisión:</th>
                                            <td id="num_exp2"><select class="form-control " style="width: 100%"
                                                    name="created_amparo" id="created_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>

                                                    <option selected>
                                                       {{$datos_firma['fecha_firma']}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Hora de emisión: </th>
                                            <td> <select class="form-control s " style="width: 100%"
                                                    name="updated_amparo[]" id="updated_amparo" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option selected>
                                                       {{$datos_firma['hora_firma']}}
                                                    </option>

                                                </select></td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Algoritmo de firma: </th>
                                            <td> <select class="form-control s " style="width: 100%"
                                                    name="tipo_cifrado" id="tipo_cifrado" data-toggle="select2"
                                                    multiple="multiple" disabled>
                                                    <option selected>
                                                       {{$datos_firma['algoritmo_firma']}}
                                                    </option>

                                                </select></td>
                                        </tr>
                                        
                                         <tr class="bg-white text-dark">
                                            <th>Descarga XML: </th>
                                            <td id="hojas_anexos">
                                           
                                            <div class="mb-2">                                         
                                                <a href="../FIRMASEMITIDAS/XML/{{$firma_a->xml}}" download="{{$firma_a->xml}}"  class="btn btn-outline-danger waves-effect waves-light" 
                                                role="button">
                                                <i class="mdi mdi-xml"> Descargar .xml</i>
                                                </a>
                                                </div>                                                                                            
                                            </td>                                            
                                        </tr>
                                        
                                        @if($_validaAsig == 0)
                                         <tr class="bg-white text-dark">
                                            <th>Descargar PDF: </th>
                                            <td id="hojas_anexos">
                                           
                                            <div class="mb-2">                                         
                                                <a href="../FIRMASEMITIDAS/PDF/{{$firma_a->pdf}}"   download="{{$firma_a->pdf}}" class="btn btn-outline-danger waves-effect waves-light" 
                                                role="button">
                                                <i class="mdi mdi-file-pdf-outline"> Descargar .pdf</i>
                                                </a>
                                                </div>                                                                                            
                                            </td>                                            
                                        </tr>
                                        @endif
                                        
                                          <tr class="bg-white text-dark">
                                            <th>Descargar Firma: </th>
                                            <td id="hojas_anexos">
                                           
                                            <div class="mb-2">                                         
                                                <a href="../FIRMASEMITIDAS/FIRMA/{{$firma_a->fir}}"   download="{{$firma_a->pdf}}" class="btn btn-outline-danger waves-effect waves-light" 
                                                role="button">
                                                <i class="mdi mdi-file-pdf-outline"> Descargar .dat</i>
                                                </a>
                                                </div>                                                                                            
                                            </td>                                            
                                        </tr>
                                        
                                           <tr class="bg-white text-dark">
                                            <th>Descargar ZIP: </th>
                                            <td id="hojas_anexos">
                                           
                                            <div class="mb-2">                                         
                                                <a href="../FIRMASEMITIDAS/ZIP/{{$name_zip}}"  download="{{$name_zip}}" class="btn btn-outline-danger waves-effect waves-light" 
                                                role="button">
                                                <i class="ti-zip"> Descargar .zip</i>
                                                </a>
                                                </div>                                                                                            
                                            </td>                                            
                                        </tr>
                                        
                                        
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <!--Fin del row -->





                </div>
            </div>
        </div>
        <!-- end row -->




    </form>

</div> <!-- end container-fluid -->

@stop