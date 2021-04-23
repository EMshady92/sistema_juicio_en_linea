<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <link rel="stylesheet" href="" media="all" /> 
    <style media="screen">
		@page { size: 816px 1344px landscape; }
	</style>

</head>

<body id="img_marca_agua">

    <header class="clearfix">
    

    </header>
    <main>
        
		<br><br>



        <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            font-family: Arial, sans-serif;
            font-size: 10px;
            padding: 5px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg th {
            font-family: Arial, sans-serif;
            font-size: 10px;
            font-weight: normal;
            padding: 5px 5px;
            border-style: solid;
            border-width: 1px;
            overflow: hidden;
            word-break: normal;
            border-color: black;
        }

        .tg .tg-0pky {
            border-color: inherit;
            text-align: left;
            vertical-align: top
        }

        @media screen and (max-width: 767px) {
            .tg {
                width: auto !important;
            }

            .tg col {
                width: auto !important;
            }

            .tg-wrap {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
        </style>
<?php 
$fecha = date('Y-m-d');
?>
    
        <div style="margin-left:130px;" class="tg-wrap">
            <div class="row">
                <div  class="col-lg-4">
                    <table class="tg">
                        <thead>
                            <tr>
                                
                               <th style='border-right: 0px;' boder='1' cellspacing="0" scope="col">
                                <img style="width: 80px; height:80px; text-align:left" src="../public/img/logo.png" >
                               </th>
                                <th scope="col" style="text-transform:uppercase" COLSPAN="5">
                                    <b class=""><h1>Tribunal de Justicia Administrativa del Estado de Zacatecas</h1></b>
                                </th>
                               
                            </tr>
                            <tr>
                               
                                <th scope="col" COLSPAN="5"><b class=""><h2>OFICIALIA DE PARTES</h2></b></th>
                                <th scope="col">FECHA {{$fecha}}</th>
                            </tr>
                            <tr>
                                <th scope="col"><b class=""><h2>FORMATO</h2></b></th>
                                <th scope="col" COLSPAN="4"><b><h2>CONTROL DE TURNO DE DOCUMENTOS JURISDICCIONALES</h2></b></th>
                                <th scope="col"> <b class=""><h2>CLAVE</h2></b> </th>
                            </tr>
                            <tr>
                                <th scope="col"><b>FECHA DE RECEPCIÓN</b> </th>
                                <th scope="col"><b>No. EXPEDIENTE</b></th>
                                <th scope="col"> <b>FOLIO DE PROMOCIÓN</b> </th>
                                <th scope="col"> <b>AREA A LA QUE SE TURNA EL DOCUMENTO</b> </th>
                                <th scope="col"> <b>DEMANDA O TIPO DE PROMOCIÓN</b> </th>
                                <th scope="col"> <b>DESCRIPCIÓN DE ANEXOS</b> </th>
                            </tr>
                            @foreach($datos as $dato)
                            <tr>
                                <th scope="col">{{$dato->fecha}}</th>
                                <th scope="col">{{$dato->num_expediente}}</th>
                                <th scope="col">{{$dato->folio}}</th>
                                <th scope="col">AREA A LA QUE SE TURNA EL DOCUMENTO</th>
                                <th scope="col">{{$dato->tipo}}</th>
                                <th scope="col">DESCRIPCIÓN DE ANEXOS</th>
                            </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>
            </div>
        </div>
		
		
        <br><br>
        <div style="margin-left:300px;">

            <br><br><br>
            <div> __________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;__________________________</div>
    
            <br>
    
            <div> <b>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;Entrega &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   &nbsp;&nbsp; Recibe</b></div>
        </div>



		



       
</body>

</html>