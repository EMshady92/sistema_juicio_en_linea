<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ACUSE {{$datos->num_expediente}}</title>
    <link rel="stylesheet" href="../assets/css/style.css" media="all" /> 
    

</head>

<body id="img_marca_agua">

    <header class="clearfix">
        <div id="logo">
            <img src="../img/LogoTJA.png" width="200" height="40" />
        </div>


        <div id="project" align="center">
            <h1>
                <b>Tribunal de Justicia Administrativa del Estado de Zacatecas</b>
            </h1>
        </div>

    </header>
    <main>
        <div>

            <h2 id="fecha">Guadalupe, Zac., a {{$fecha}}.</h2>
            <h2><b>Acuse de ingreso<br>
                    Oficialia de Partes<br>
					N° de expediente asignado: {{$datos->num_expediente}}</b></h2>
					<br><br>
			<h2> Por medio de la presente, se hace constar, que se recibio <b>"texto por definir......................................................."</b>
		de tipo <b>{{$datos->tipo}}</b> el cual contiene <b>{{$datos->num_anexos }}</b> anexos, <b>{{$datos->hojas_escrito}}</b> hoja(s) de escrito, y <b>{{$datos->hojas_traslados}}</b> hoja(s) de traslados, asignandole el numéro de expediente <b>{{$datos->num_expediente}}.</b> </h2>
		</div>
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

        <div>
            <h2> <b>Actores</b< /h2>
        </div>
        <div class="tg-wrap">
            <div class="row">
                @foreach($actores as $actor)
                <div class="col-lg-4">
                    <table class="tg">
                        <tr>
                            <td class="tg-0pky">Tipo de persona</td>
                            <td class="tg-0pky">
                                <b>{{$actor->tipo_persona}}</b>

                            </td>

                        </tr>
                        @if($actor->tipo_persona == "FISICA")
                        <tr>
                            <td class="tg-0pky">Nombre</td>
                            <td class="tg-0pky">
                                <b>{{$actor->nombre}} {{$actor->apellido_paterno}} {{$actor->apellido_materno}}</b>

                            </td>
                        </tr>
                        @else
                        <tr>
                            <td class="tg-0pky">Razón social</td>
                            <td class="tg-0pky">
                                <b>{{$actor->razon_social}} </b>

                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="tg-0pky">Email</td>
                            <td class="tg-0pky">
                                <b>{{$actor->email}}</b>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
		<br>
		
		<div>
            <h2> <b>Autoridades demandadas</b< /h2>
        </div>
        <div class="tg-wrap">
            <div class="row">
                @foreach($demandados as $demandado)
                <div class="col-lg-4">
                    <table class="tg">
                        <tr>
                            <td class="tg-0pky">Nombre</td>
                            <td class="tg-0pky">
                                <b>{{$demandado->nombre}}</b>
                            </td>
                        
                    </table>
                </div>
                @endforeach
            </div>
        </div>
		<br>
		
		@if($abogados)
			<div>
            <h2> <b>Abogados</b< /h2>
        </div>
        <div class="tg-wrap">
            <div class="row">
                @foreach($abogados as $abogado)
                <div class="col-lg-4">
                    <table class="tg">                     
                        <tr>
                            <td class="tg-0pky">Nombre</td>
                            <td class="tg-0pky">
                                <b>{{$abogado->nombre}} {{$abogado->apellido_paterno}} {{$abogado->apellido_materno}}</b>

                            </td>
                        </tr>                   
                    </table>
                </div>
                @endforeach
            </div>
        </div>
		<br>
		@endif

		@if($terceras)
		<div>
            <h2> <b>Terceros interesados</b< /h2>
        </div>
        <div class="tg-wrap">
            <div class="row">
                @foreach($terceras as $tercera)
                <div class="col-lg-4">
                    <table class="tg">
                        <tr>
                            <td class="tg-0pky">Tipo de persona</td>
                            <td class="tg-0pky">
                                <b>{{$tercera->tipo_persona}}</b>

                            </td>

                        </tr>
                        @if($tercera->tipo_persona == "FISICA")
                        <tr>
                            <td class="tg-0pky">Nombre</td>
                            <td class="tg-0pky">
                                <b>{{$tercera->nombre}} {{$tercera->apellido_paterno}} {{$tercera->apellido_materno}}</b>

                            </td>
                        </tr>
                        @else
                        <tr>
                            <td class="tg-0pky">Razón social</td>
                            <td class="tg-0pky">
                                <b>{{$tercera->razon_social}} </b>

                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="tg-0pky">Email</td>
                            <td class="tg-0pky">
                                <b>{{$tercera->email}}</b>
                            </td>
                        </tr>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
		<br>

		@endif



        <div><?php echo DNS2D::getBarcodeHTML($num_exp, "QRCODE",3,3);?></div>
</body>

</html>