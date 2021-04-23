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
                <h4 class="page-title"><p class="text-success">La firma coincide con el documento</p> </h4>




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
                    <h4 class="header-title">Datos:</h4>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card-box">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">




                                        <tr class="bg-light text-dark">
                                            <th>Folio de la firma:</th>
                                            <td><select class="form-control" style="width: 100%" name="nombre"
                                                    id="nombre" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->num_firma}}
                                                    </option>
                                                </select></td>

                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Clave alfanumérica :</th>
                                            <td><select class="form-control" style="width: 100%" name="clave" id="clave"
                                                    data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->clave_alfanumerica}}
                                                    </option>
                                                </select></td>

                                        </tr>


                                        <tr class="bg-light text-dark">
                                            <th>Estado:</th>
                                            <td><select class="form-control" style="width: 100%" name="email" id="email"
                                                    data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->estado}}
                                                    </option>
                                                </select></td>

                                        </tr>

                                        <tr class="bg-light text-dark">
                                            <th>Modificada por:</th>
                                            <td><select class="form-control" style="width: 100%" name="puesto"
                                                    id="puesto" data-toggle="select2" multiple="multiple" disabled>
                                                    <option selected>
                                                        {{$firma->captura}}
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
                                            <th>Descarga XML: </th>
                                            <td id="hojas_anexos">

                                                <div class="mb-2">
                                                    <a href="../FIRMASEMITIDAS/XML/{{$firma->xml}}"
                                                        download="{{$firma->xml}}"
                                                        class="btn btn-outline-danger waves-effect waves-light"
                                                        role="button">
                                                        <i class="mdi mdi-xml"> Descargar .xml</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>


                                        <tr class="bg-white text-dark">
                                            <th>Descargar PDF: </th>
                                            <td id="hojas_anexos">

                                                <div class="mb-2">
                                                    <a href="../FIRMASEMITIDAS/PDF/{{$firma->pdf}}"
                                                        download="{{$firma->pdf}}"
                                                        class="btn btn-outline-danger waves-effect waves-light"
                                                        role="button">
                                                        <i class="mdi mdi-file-pdf-outline"> Descargar .pdf</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr class="bg-white text-dark">
                                            <th>Descargar Firma: </th>
                                            <td id="hojas_anexos">

                                                <div class="mb-2">
                                                    <a href="../FIRMASEMITIDAS/FIRMA/{{$firma->firma_ruta}}"
                                                        download="{{$firma->firma_ruta}}"
                                                        class="btn btn-outline-danger waves-effect waves-light"
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
                                                    <a href="../FIRMASEMITIDAS/ZIP/{{$firma->zip}}"
                                                        download="{{$firma->zip}}"
                                                        class="btn btn-outline-danger waves-effect waves-light"
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-box">
                                <h4 class="header-title">Información del expediente</h4>
                                <div class="form-group" class="table-responsive">
                                    <table id="data_table" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    </table>
                                </div>

                                <h4 class="header-title">Datos del documento</h4>
                                <div class="form-group" class="table-responsive">
                                    <table id="data_table2" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    </table>
                                </div>

                                <h4 class="header-title">Datos de la firma electronica</h4>
                                <div class="form-group" class="table-responsive">
                                    <table id="data_table3" class="table table-bordered dt-responsive nowrap"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                    </table>
                                </div>



                            </div>

                        </div>

                    </div>
                    <!--FIN ROW DETALLES FIRMA-->





                </div>
            </div>
        </div>
        <!-- end row -->




    </form>

</div> <!-- end container-fluid -->

@stop
@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            myFunction(this);
        }
    };
    xmlhttp.open("GET", '../FIRMASEMITIDAS/XML/{{$firma->xml}}', true);
    xmlhttp.send();
});


function myFunction(xml) {

    var i;
    var xmlDoc = xml.responseXML;
    var table =
        "<tr><th>Número de expediente</th><th>Tipo de juicio</th><th>Tipo</th><th>Fecha del expediente</th><th>Fecha de captura</th><th>Ultima actualización</th></tr>";
    var x = xmlDoc.getElementsByTagName("expediente");
    for (i = 0; i < x.length; i++) {
        table += "<tr><td>" +
            x[i].getElementsByTagName("num_expediente")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("tipo_juicio")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("tipo")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("fecha_expediente")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("fecha_captura")[0].childNodes[0].nodeValue +
            "</td><td>" +
            x[i].getElementsByTagName("ultima_actualizacion")[0].childNodes[0].nodeValue +
            "</td></tr>";
    }
    document.getElementById("data_table").innerHTML = table;
    var y = xmlDoc.getElementsByTagName("datos_documento");
    var table2 =
        "<tr><th>Tipo de documento</th><th>Folio del documento</th><th>Fecha de captura</th><th>Ultima actualización</th></tr>";
    for (i = 0; i < y.length; i++) {
        table2 += "<tr><td>" +
            y[i].getElementsByTagName("tipo_documento")[0].childNodes[0].nodeValue +
            "</td><td>" +
            y[i].getElementsByTagName("folio_documento")[0].childNodes[0].nodeValue +
            "</td><td>" +
            y[i].getElementsByTagName("fecha_captura")[0].childNodes[0].nodeValue +
            "</td><td>" +
            y[i].getElementsByTagName("ultima_actualizacion")[0].childNodes[0].nodeValue +
            "</td></tr>";
    }
    document.getElementById("data_table2").innerHTML = table2;

    var z = xmlDoc.getElementsByTagName("datos_firmante");
    var table3 =
        "<tr><th>Fecha de la firma</th><th>Hora de la firma</th><th>Firmante</th><th>Función o Puesto</th><th>Email</th><th>Folio de la firma</th></tr>";
    for (i = 0; i < x.length; i++) {
        table3 += "<tr><td>" +
            z[i].getElementsByTagName("fecha_firma")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("hora_firma")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("firmante")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("funcion_firmante")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("email_firmante")[0].childNodes[0].nodeValue +
            "</td><td>" +
            z[i].getElementsByTagName("num_firma")[0].childNodes[0].nodeValue +
            "</td></tr>";
    }
    document.getElementById("data_table3").innerHTML = table3;


}
</script>
@endsection