<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$datos->num_expediente}}</title>
    <link rel="stylesheet" href="../assets/css/style.css" media="all" /> 
    <style media="screen">
		@page { size: 1344px 816px landscape; }
	</style>

</head>

<body id="img_marca_agua">

    <header class="clearfix">
        
       

       

    </header>
   
    <main>
    <div id="project" align="center">
            <h1>
            @if($datos->tipo== 'NULIDAD')
                <b>JUICIO CONTENCIOSO ADMINISTRATIVO</b>
            @elseif($datos->tipo== 'RAG') 
                <b>RESPONSABILIDADES ADMINISTRATIVAS</b>
            @endif   
            </h1>
        </div>
 <br>       
<hr>
<hr>

<!-- <div style="padding-top:80px;" align="center">
<div style="padding-rigth:20px;" align="center">
 <img src="../public/img/imgportada.png"  width="350" height="350">
 <div>

 <div  style="padding-top:295px; padding-left:185; font-size:large" align="center" class='folio'>
 <hr>

 </div> 
 </div> -->

<div>
<br>
    <div style='float:left;margin-left:80;'>
    <img src="../public/img/imgportada.png" >
    </div>
    <br>
    @if($datos->tipo== 'NULIDAD')
        <div class='folio' style='float:right;margin-top:85; font-size:large;'>
        <h1>{{$datos->num_expediente}}</h1>
        </div>
    @elseif($datos->tipo== 'RAG')
    <br>
    <br> 
    <div class='folio' style='float:right;margin-top:85;margin-right:-20;font-size:medium;'>
        <h1>{{$datos->num_expediente}}</h1>
        </div>
    @endif   

   
</div>

<br><br><br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br><br><br> <br> <br> <br>

<hr><hr>
@if( $datos->tipo== 'NULIDAD')
<div align ='center'>
    <br><br><br>
    <div style=''>
   
    <b>ACTOR:</b>
                <?php $count = 0; $countactors = count($actor); ?>
          
                @foreach($actor as $actors)
                    <?php if($count == 5) break; ?>
                    
                    @if($actors === end($actor))
                    {{$actors->nombre}} {{$actors->apellido_paterno}}@if($count > 3 )
                    Y OTROS
                    @else
                    .
                    @endif
                    @else
                    {{$actors->nombre}} {{$actors->apellido_paterno}},
                    @endif

                  

                    <?php $count++; ?>
                @endforeach
    
    </div>

    <br><br><br>
    <div style=''>
    
    <b>AUTORIDAD:</b>
       
        <?php $countdemandado = 0; ?>

            @foreach($demandados as $demandado)
                <?php if($countdemandado == 5) break; ?> 
                 
                @if($demandado === end($demandados))
                    {{$demandado->nombre}}@if($countdemandado > 3 )
                    Y OTROS
                    @else
                    .
                    @endif
                    @else
                    {{$demandado->nombre}},
                    @endif


                <?php $countdemandado++; ?>
            @endforeach
        </div>

        <br><br><br>
        <div style=''>
        <b>TIPO DE JUICIO:</b> 
        JUICIO DE {{$datos->tipo}}
    </div>

    <br><br><br>
    <div style=''>
    <b>INICIO:</b> 
    {{$datos->fecha}}
    </div>

    <br><br><br>
    <div  style='text-transform: uppercase;'>
    <b>OBSERVACIONES:</b> 
    {{$datos->observaciones}}
    </div>      
</div>
@elseif($datos->tipo== 'RAG')
<div align ='center'>
    <br>
    <br>
    <br>
        <div style=''>
        <b>PRESUNTO RESPONSABLE:</b> 
                        
                        <?php $count_pres_res = 0; ?>

                @foreach($presunto_resp as $presunto_respx)
                    <?php if($count_pres_res == 5) break; ?> 
                    
                    @if($presunto_respx === end($presunto_resp))
                        {{$presunto_respx->nombre}} {{$presunto_respx->apellido_paterno}}@if($count_pres_res > 3 )
                        Y OTROS
                        @else
                        .
                        @endif
                        @else
                        {{$presunto_respx->nombre}} {{$presunto_respx->apellido_paterno}},
                        @endif


                    <?php $count_pres_res++; ?>
                @endforeach


        </div>
    <br>
    <br>
    <br>
        <div style=''>
        <b>PATICULAR VINCULADO:</b> 
                        <?php $count_part_vin = 0; ?>

                @foreach($particular_vinc as $particular_vincx)
                    <?php if($count_part_vin == 5) break; ?> 
                    
                    @if($particular_vincx === end($particular_vinc))
                        {{$particular_vincx->nombre}} {{$particular_vincx->apellido_paterno}}@if($count_part_vin > 3 )
                        Y OTROS
                        @else
                        .
                        @endif
                        @else
                        {{$particular_vincx->nombre}} {{$particular_vincx->apellido_paterno}},
                        @endif


                    <?php $count_part_vin++; ?>
                @endforeach
        
        </div>
    <br>
    <br>
    <br>
        <div style=''>
        <b>DENUNCIANTE:</b> 
                            <?php $count_denun = 0; ?>

                    @foreach($denunciante as $denunciantex)
                        <?php if($count_denun == 5) break; ?> 
                        
                        @if($denunciantex === end($denunciante))
                            {{$denunciantex->nombre}} {{$denunciantex->apellido_paterno}}@if($count_denun > 3 )
                            Y OTROS
                            @else
                            .
                            @endif
                            @else
                            {{$denunciantex->nombre}} {{$denunciantex->apellido_paterno}},
                            @endif


                        <?php $count_denun++; ?>
                    @endforeach

        </div>
    <br>
    <br>
    <br>
        <div style=''>
        <b>AUTORIDAD INVESTIGADORA:</b> 
    
        <?php $count_aut_inv = 0; ?>

                @foreach($autoridad_inv as $aut_investigadora)
                    <?php if($count_aut_inv == 5) break; ?> 
                    
                    @if($aut_investigadora === end($autoridad_inv))
                        {{$aut_investigadora->nombre}}@if($count_aut_inv > 3 )
                        Y OTROS
                        @else
                        .
                        @endif
                        @else
                        {{$aut_investigadora->nombre}},
                        @endif


                    <?php $count_aut_inv++; ?>
                @endforeach

        </div>
    <br>
    <br>
    <br>
        <div style=''>
        <b>AUTORIDAD SUBSTANCIADORA:</b> 
       
                        <?php $count_aut_sust = 0; ?>

                @foreach($autoridad_sust as $aut_sust)
                    <?php if($count_aut_inv == 5) break; ?> 
                    
                    @if($aut_sust === end($autoridad_sust))
                        {{$aut_sust->nombre}}@if($count_aut_sust > 3 )
                        Y OTROS
                        @else
                        .
                        @endif
                        @else
                        {{$aut_sust->nombre}},
                        @endif


                    <?php $count_aut_sust++; ?>
                @endforeach


        </div>
    <br>
    <br>
    <br>
        <div style=''>
        <b>TIPO DE FALTA:</b> 
      {{$tipo_falta->tipo_falta}}
        </div>
    <br>
    <br>
    <br>
    <div  style='text-transform: uppercase;'>
        <b>OBSERVACIONES:</b> 
        {{$datos->observaciones}}
        </div>
            
</div>
@endif

        <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .folio {-webkit-transform: rotate(90deg); }


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

        .watermark {
                position: fixed;

                /** 
                    Establece una posición en la página para tu imagen
                    Esto debería centrarlo verticalmente
                **/
                bottom:   10cm;
                left:     -8cm;

                /** Cambiar las dimensiones de la imagen **/
                width:    8cm;
                height:   10cm;

                /** Tu marca de agua debe estar detrás de cada contenido **/
                z-index:  -1000;
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

      
</body>

</html>