@extends('layouts.principal')
@section('contenido')

<div class="wrapper">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="/acuerdos">Acuerdos</a></li>
                            <li class="breadcrumb-item active">Generar Acuerdo</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Generar acuerdo para el expediente: {{$expediente->num_expediente}}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        @include('users.modalPassword')
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="header-title">Formulario para generar acuerdos</h4>


                            <form id="wizard-validation-form" name="formulario"
                                onsubmit="return valida_envio_firma();recorre_tabla();"
                                action="{{ url('generar_acuerdo',[$expediente->id]) }}" method="post" files="true"
                                enctype="multipart/form-data">

                                {{csrf_field()}}

                                <div>
                                    <h3>Información del expediente</h3>
                                    <section>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-lg-7">
                                                    <div class="card-box">
                                                        <h4 class="header-title">Información del expediente</h4>

                                                        <div class="table-responsive">
                                                            <table class="table table-borderless mb-0">

                                                                <tr class="bg-light text-dark">
                                                                    <th scope="row">Número de expediente : </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="num_expediente[]"
                                                                            id="num_expediente" multiple="multiple"
                                                                            disabled>

                                                                </tr>

                                                                <tr class="bg-white text-dark">
                                                                    <th>Tipo:</th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="tipo_aux[]"
                                                                            id="tipo_aux" multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>

                                                                <tr class="bg-white text-dark">
                                                                    <th>Tipo de juicio:</th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="tipo_juicio[]"
                                                                            id="tipo_juicio" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>

                                                                @if($expediente->tipo == "RAG" || $expediente->tipo ==
                                                                "GENERALIDAD")
                                                                <tr class="bg-white text-dark">
                                                                    <th>Tipo de falta:</th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="tipo_falta[]"
                                                                            id="tipo_falta" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>


                                                                <tr class="bg-light text-dark">
                                                                    <th>Presunto responsable: </th>
                                                                    <td id="num_exp"> <select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="presunto_resp_aux[]"
                                                                            id="presunto_resp_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-white text-dark">
                                                                    <th>Autoridad Investigadora: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="autoridad_inv_aux[]"
                                                                            id="autoridad_inv_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th>Autoridad Sustanciadora: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="autoridad_sust_aux[]"
                                                                            id="autoridad_sust_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr lass="bg-white text-dark">
                                                                    <th>Denunciante: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="denunciante_aux[]"
                                                                            id="denunciante_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>

                                                                <tr lass="bg-white text-dark">
                                                                    <th>Particular vinculado con faltas administrativas
                                                                        graves: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="particular_aux[]"
                                                                            id="particular_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                @elseif($expediente->tipo == "NULIDAD" ||
                                                                $expediente->tipo
                                                                == "GENERALIDAD")
                                                                <tr class="bg-light text-dark">
                                                                    <th>Actores: </th>
                                                                    <td id="num_exp"> <select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="actor_aux[]"
                                                                            id="actor_aux" multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-white text-dark">
                                                                    <th>Demandados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="demandados_aux[]"
                                                                            id="demandados_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th>Abogados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="abogados_aux[]"
                                                                            id="abogados_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr lass="bg-white text-dark">
                                                                    <th>Terceros Interesados: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="terceros_aux[]"
                                                                            id="terceros_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>
                                                                @endif



                                                                <tr class="bg-light text-dark">
                                                                    <th>Fecha: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="fecha_aux[]"
                                                                            id="fecha_aux" multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>

                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Fin de la columna de datos 1 -->

                                                <div class="col-lg-5">
                                                    <div class="card-box">
                                                        <h4 class="header-title">Datos</h4>
                                                        <div class="table-responsive">
                                                            <table class="table table-borderless mb-0">


                                                                <tr class="bg-white text-dark">
                                                                    <th>Ultima actualización:</th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="ultima_ac[]"
                                                                            id="ultima_ac" multiple="multiple" disabled>

                                                                        </select></td>
                                                                </tr>
                                                                <tr class="bg-light text-dark">
                                                                    <th scope="row">Fecha de captura : </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="fecha_captura[]"
                                                                            id="fecha_captura" multiple="multiple"
                                                                            disabled>

                                                                </tr>
                                                                <tr class="bg-white text-dark">
                                                                    <th>Modificado por: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%" name="modificado[]"
                                                                            id="modificado" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>

                                                                <tr class="bg-white text-dark">
                                                                    <th>Observaciónes: </th>
                                                                    <td id="num_exp"><select
                                                                            class="form-control select2-multiple "
                                                                            style="width: 100%"
                                                                            name="observaciones_aux[]"
                                                                            id="observaciones_aux" multiple="multiple"
                                                                            disabled>

                                                                        </select></td>
                                                                </tr>








                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Fin de la columna de datos 2 -->


                                            </div>
                                            <!--Fin del row -->

                                            <!--Fin de la columna de datos 1 -->


                                            <!--Fin de la columna de datos 2 -->
                                        </div>
                                        <!--Fin del row -->




                                    </section>
                                    <h3>Historial</h3>
                                    <section>
                                        @include('expedientes.modal_escritoInicial')
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card-box">
                                                    <h4 class="header-title">Historial del expediente</h4>
                                                    <div class="form-group" class="table-responsive">
                                                        <table id="datatable"
                                                            class="table table-bordered dt-responsive nowrap"
                                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                            <thead>
                                                                <tr>
                                                                    <th>Tipo Expediente</th>
                                                                    <th>Tipo</th>
                                                                    <th>Folio</th>
                                                                    <th>Estado</th>
                                                                    <th>Fecha de captura</th>
                                                                    <th>Modificado por</th>
                                                                    <th>Ver</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{$expediente->tipo}}</td>
                                                                    <td>INGRESO DE EXPEDIENTE</td>
                                                                    <td>{{$expediente->num_expediente}}</td>
                                                                    <td><span
                                                                            class="badge badge-danger">{{$expediente->estado}}</span>
                                                                    </td>
                                                                    <td>{{$expediente->created_at}}</td>
                                                                    <td>{{$expediente->captura}}</td>
                                                                    <td>
                                                                        <a href="{{URL::action('ExpedientesController@show',$expediente->id)}}"
                                                                            class="btn waves-effect waves-light btn-info btn-sm"
                                                                            role="button" target="_blank"><i
                                                                                class="mdi mdi-eye"></i></a>
                                                                    </td>
                                                                </tr>
                                                                <tr>

                                                                    <td>{{$expediente->tipo}}</td>
                                                                    <td>ESCRITO INICIAL DE DEMANDA</td>
                                                                    <td>{{$expediente->num_expediente}}</td>
                                                                    <td><span
                                                                            class="badge badge-danger">{{$expediente->estado}}</span>
                                                                    </td>
                                                                    <td>{{$expediente->created_detalle}}</td>
                                                                    <td>{{$expediente->captura}}</td>
                                                                    <td><button type="button"
                                                                            class="btn waves-effect waves-light btn-info btn-sm"
                                                                            data-toggle="modal"
                                                                            data-target="#modalEscrito{{$expediente->id}}"
                                                                            data-dismiss="modal" role="button">
                                                                            <i class="mdi mdi-eye"></i></button></td>
                                                                </tr>
                                                                @foreach($amparos as $amparo)
                                                                <tr>
                                                                    <td></td>
                                                                    <td>{{$amparo->tipo}}</td>
                                                                    <td>{{$amparo->folio}}</td>
                                                                    <td><span
                                                                            class="badge badge-danger">{{$amparo->estado}}</span>
                                                                    </td>
                                                                    <td>{{$amparo->created_at}}</td>
                                                                    <td>{{$amparo->captura}}</td>
                                                                    <td><a href='/ver_amparo/{{$amparo->id}}'
                                                                            class="btn waves-effect waves-light btn-info btn-sm"
                                                                            role="button" target="_blank">
                                                                            <i class="mdi mdi-eye"></i></a></td>
                                                                </tr>
                                                                @endforeach
                                                                @foreach($acuerdos as $acuerdo)
                                                                <tr>
                                                                    <td></td>
                                                                    <td>ACUERDO</td>
                                                                    <td>{{$acuerdo->num_folio}}</td>
                                                                    <td><span
                                                                            class="badge badge-danger">{{$acuerdo->estado}}</span>
                                                                    </td>
                                                                    <td>{{$acuerdo->created_at}}</td>
                                                                    <td>{{$acuerdo->captura}}</td>
                                                                    <td> <a href="{{URL::action('acuerdosController@show',$acuerdo->id)}}"
                                                                            class="btn waves-effect waves-light btn-info btn-sm"
                                                                            role="button" target="_blank"><i
                                                                                class="mdi mdi-eye"></i></a></td>
                                                                </tr>
                                                                @endforeach

                                                            </tbody>
                                                        </table>
                                                    </div>



                                                </div>

                                            </div>

                                        </div>
                                        <!--FIN ROW ANEXOS-->
                                    </section>
                                    <h3>Generar acuerdo</h3>
                                    <section>
                                        <div class="row" id="padre">


                                            <div class="col-3 mr-auto mr-4 mb-4">
                                                <div class="form-group">
                                                    <label for="userName">Tipo de acuerdo<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%" name="tipoAcuerdo"
                                                        id="tipoAcuerdo" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="" selected>Seleccione una opción</option>
                                                        @foreach($tipos as $tipo)
                                                        <option value="{{$tipo->id}}">
                                                            {{$tipo->tipo}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>

                                                </div>
                                            </div>



                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="contestacion">Tiempo de contestación<span
                                                            class="text-danger">*</span></label>
                                                    <input type="number" name="tiempo_contestacion"
                                                        parsley-trigger="change" min='1' max="99" value="15" required
                                                        placeholder="Ingrese el tiempo de contestación en número de días"
                                                        class="form-control" id="tiempo_contestacion">
                                                    <div class="text-danger" id='error_dias' name="error_dias"></div>

                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="contestacion">Desea relacionarlo a una promoción<span
                                                            class="text-danger">* </span></label>
                                                    <div class="form-group">
                                                        <div class="radio radio-info form-check-inline">
                                                            <input type="radio"
                                                                onclick="cambia_display_acuerdo(this.value);"
                                                                id="radioInline" value="SI" name="radioInline">
                                                            <label for="inlineRadio1">Si </label>
                                                        </div>
                                                        <div class="radio form-check-inline">
                                                            <input type="radio"
                                                                onclick="cambia_display_acuerdo(this.value);"
                                                                id="radioInline" value="NO" name="radioInline" checked>
                                                            <label for="inlineRadio2">No </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-3 mr-auto mr-4 mb-4">
                                                <div class="form-group" id='display_promocion'
                                                    style='display:none;width: 100%'>
                                                    <div class="form-group">
                                                        <label for="userName">Seleccione promocion<span
                                                                class="text-danger">*</span></label>
                                                        <select class="form-control" style="width: 100%"
                                                            name="promocion" id="promocion"
                                                            data-placeholder="Seleccione una opción ...">
                                                            <option value="" selected>Seleccione una opción</option>
                                                            @foreach($amparos as $promocion)
                                                            <option value="{{$promocion->id}}">
                                                                Folio: {{$promocion->folio}} Tipo: {{$promocion->tipo}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <div class="text-danger" id='error_promocion'
                                                            name="error_promocion"></div>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="exampleTextarea">Observaciónes</label>
                                                </div>
                                                <div class="form-group">
                                                    <textarea name="observaciones" id="observaciones" cols="60"
                                                        rows="10" maxlength="255"></textarea>

                                                </div>

                                            </div><!-- end row -->



                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="exampleTextarea">Redactar acuerdo</label>
                                                    <textarea class="ckeditor" id="acuerdo" name="acuerdo" rows="20">
                                                    <!DOCTYPE html>
<html lang="en">
<body id="img_marca_agua">

    <header class="clearfix">
        <div id="logo">
            <img src="https://www.sijel.com.mx/img/marca_agua_tja.png" width="200" height="100" />
        </div>


        <div id="project" align="center">
            <h1>
                <b>Expediente: {{$expediente->num_expediente}}</b>
            </h1>
        </div>

    </header>
    <main>
    AUTO. Guadalupe, Zacatecas; a veintidós de octubre de dos mil veinte. ----------------------------------------------------------------------------------VISTO. El escrito recibido mediante el buzón electrónico de este Tribunal el dieciséis de octubre del año en curso, mediante el cual, Luis Ángel Zapata Bermudez, por propio derecho, promueve Juicio Contencioso Administrativo en contra del acto que hace consistir en la resolución del procedimiento para el fincamiento de responsabilidades resarcitorias, de fecha veintiuno de septiembre de dos mil veinte, en el expediente número ASE-PFRR-080/2015; en donde señala como autoridades  demandadas al Auditor Superior del Estado de Zacatecas y la Notificadora adscrita a la Auditoría Superior del Estado, Erika Vargas Carrillo; con fundamento en lo dispuesto por los numerales 1º fracción I, 4, 12 fracción II, 20 apartado A, fracción XIII, 62 segundo párrafo, 73, 85 fracción I, 86, 87, 90 y 104 de la Ley de Justicia Administrativa del Estado de Zacatecas; SE ADMITE A TRÁMITE LA DEMANDA DE NULIDAD, que promueve Luis Ángel Zapata Bermudez, en contra de las autoridades señaladas líneas arriba, regístrese en el Libro de Gobierno bajo el número TJA/343/2020-P3 que fue el que por orden legalmente le correspondió y fórmese el expediente respectivo.--------
Con las copias simples del citado escrito y anexos, EMPLÁCESE a las autoridades demandadas, en sus domicilios oficiales y hágaseles saber que cuentan con el término de QUINCE (15) DÍAS HÁBILES contados a partir del día siguiente a aquel al en que surta efectos la notificación del presente auto, para que remitan a este Tribunal de Justicia Administrativa del Estado de Zacatecas, su contestación de demanda con sendas copias de su escrito y anexos para cada una de las partes; APERCIBIÉNDOLAS que en caso de no presentar las copias requeridas, de conformidad a lo dispuesto en el artículo 70 fracción I inciso a) y 72 de la ley que rige el procedimiento, como medida de apremio, les será aplicada una multa de $1,303.20 (un mil trescientos tres pesos con 20/100, M.N.) que equivale a QUINCE VECES el valor diario de la Unidad de Medida y Actualización (UMA) a razón de $86.88 (Ochenta y seis pesos 88/100, moneda nacional) que es la cantidad establecida por el Instituto Nacional de Estadística y Geografía (INEGI), publicada en el Diario Oficial de la Federación del diez de enero del dos mil veinte; además, según lo establecido en el artículo 148, tercer párrafo del Código de Procedimientos Civiles para el Estado de Zacatecas, de aplicación supletoria a la materia de conformidad al artículo 63 de la Ley de Justicia Administrativa del Estado de Zacatecas, se ordenará expedir a su costa las copias necesarias para su traslado.---------------De igual manera se le apercibe, que en el caso de no contestar dentro del plazo señalado anteriormente, se les tendrán por ciertos los hechos que se les imputan de manera directa, salvo prueba en contrario como lo establece el artículo 93 fracción I de la Ley de Justicia Administrativa del Estado de Zacatecas.---------------------------- Se tienen por ofrecidas y admitidas las pruebas señaladas por el actor como: 1. LA DOCUMENTAL PÚBLICA. Consistente en copia simple de la credencial para votar expedida por el Instituto Nacional Electoral a nombre de Luis Ángel Zapata Bermudez, con número de clave de elector ZPBRLS80012732H000; 2. LA DOCUMENTAL PÚBLICA. Consistente en el expediente administrativo con número ASE-PFRR-080/2015, del cual emana la resolución impugnada, por lo que de conformidad con el artículo 93 fracción III, de la Ley de Justicia Administrativa del Estado de Zacatecas, SE REQUIERE al Auditor Superior del Estado de Zacatecas para que a más tardar al contestar la demanda, remita a este Tribunal, el original o copia certificada legible del expediente administrativo anteriormente mencionado; apercibiéndolo que en caso de no hacerlo, se presumirán de ciertos los hechos que el actor le impute de manera directa y que pretende acreditar con dicha probanza; 3. LA DOCUMENTAL PÚBLICA. Consistente en copia simple de la resolución contenida dentro del expediente número ASE-PFRR-080/2015, de fecha veintiuno de septiembre de dos mil veinte; 4. LA DOCUMENTAL PÚBLICA. Consistente en copia simple de la cedula de notificación del procedimiento para el fincamiento de responsabilidades resarcitorias de fecha veintitrés de septiembre de dos mil veinte; 5. LA INSTRUMENTAL DE ACTUACIONES. En los términos ofrecida; 6. LA PRESUNCIONAL LEGAL Y HUMANA. En los términos ofrecida. 
En cuanto a la CONFESIONAL EXPRESA ofrecida por el actor, de conformidad con los artículos 72 y 104 de la Ley de Justicia Administrativa, así como lo señalado en el artículo 259 fracción IV, del Código de Procedimientos Civiles para el Estado de Zacatecas, de aplicación supletoria a la materia, SE DESECHA POR IMPROCEDENTE, lo anterior en razón de que por disposición expresa en la ley que regula el procedimiento contencioso administrativo, es admisible toda clase de pruebas, excepto la testimonial y la confesional a cargo de las autoridades demandadas.-
Téngase como domicilio para oír y recibir notificaciones el ubicado en Calle Médicos Veterinarios número ciento dos (102), interior 2, Colonia Médicos Veterinarios; en términos del artículo 74 de la ley en comento y téngase como autorizadas a Yanett Sánchez Escobedo y Ma. de Lourdes Rosales Gutiérrez. ---------------------------------------------
Hágase del conocimiento de la parte actora que el uso de sus datos personales es exclusivamente para cumplir con las finalidades de este Tribunal de Justicia Administrativa, según lo dispuesto en el artículo 16 fracciones II, III, y IV de la Ley de Protección de Datos Personales en Posesión de Sujetos Obligados del Estado de Zacatecas. No obstante, lo anterior, queda a su discreción ejercer sus derechos para solicitar el acceso, rectificación, cancelación u oposición (ARCO), sobre el tratamiento de sus datos personales. El aviso de privacidad integral podrá consultarlo en la página de internet www.trijazac.gob.mx.---------------------------------------------------------------NOTIFÍQUESE PERSONALMENTE A LA PARTE ACTORA Y POR OFICIO A LA AUTORIDAD DEMANDADA. CÚMPLASE.
Así lo proveyó y firma el Magistrado Instructor del Tribunal de Justicia Administrativa del Estado de Zacatecas, licenciado Gabriel Sandoval Lara, ante la Coordinadora licenciada Nancy Frías Pérez, quién autoriza con su firma y da fe. - DOY FE.

                   L´ACCP/AAMM                                                                                                   FR: 0024
         
</body>

</html></textarea>
                                                    <div class="text-danger" id='error_acuerdo' name="error_acuerdo">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Firmas necesarias</h3>
                                    <section>
                                        <div class="row">
                                            <div class="col-3 mr-auto mr-4 mb-4">

                                                <div class="form-group">

                                                    <label for="userName">Tipo de documento<span
                                                            class="text-danger">*</span></label>

                                                    <select class="form-control" style="width: 100%"
                                                        name="tipoDocumento" id="tipoDocumento" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        @foreach($tipo_documentos as $tipo)
                                                        @if($tipo->tipo_documento == "ACUERDO")
                                                        <option value="{{$tipo->tipo_documento}}" selected>
                                                            {{$tipo->tipo_documento}}
                                                        </option>
                                                        @else
                                                        <option value="{{$tipo->tipo_documento}}">
                                                            {{$tipo->tipo_documento}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="userName">Tipo de expediente<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%"
                                                        name="tipoExpediente" id="tipoExpediente" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="{{$expediente->tipo}}">
                                                            {{$expediente->tipo}}
                                                        </option>

                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>

                                            </div>


                                            <div class="col-3 mr-auto mr-4 mb-4">
                                                <div class="form-group">
                                                    <label for="userName">Tipo de juicio<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" style="width: 100%" name="tipoJuicio"
                                                        id="tipoJuicio" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        @foreach($tipo_juicio as $tipo_juicio)
                                                        @if($expediente->id_juicio == $tipo_juicio->id)
                                                        <option value="{{$tipo_juicio->tipo}}">
                                                            {{$tipo_juicio->tipo}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="contestacion">Número de expediente<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="num_exp" parsley-trigger="change" required
                                                        placeholder="Ingrese el número de expediente"
                                                        value=" {{$expediente->num_expediente}}" class="form-control"
                                                        id="num_exp" readonly>
                                                </div>
                                            </div>
                                            <div class="col-3 mr-auto mr-4 mb-4">
                                                <div class="form-group">
                                                    <label for="userName">Sala<span class="text-danger">*
                                                        </span></label>
                                                    <select class="form-control" style="width: 100%" name="sala"
                                                        id="sala" required data-placeholder="Seleccione una opción ...">
                                                        <option value="{{$ponente->num_sala}}" selected>
                                                            {{$ponente->num_sala}}</option>
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="userName">Proyectista<span class="text-danger">*
                                                        </span></label>
                                                    <select class="form-control" style="width: 100%" name="proyectista"
                                                        id="proyectista" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="" selected>Seleccione una opción</option>
                                                        @foreach($users as $user)
                                                        @if($user->funcion == "PROYECTISTA" || $user->funcion ==
                                                        "SECRETARIO
                                                        AUXILIAR" ||
                                                        $user->funcion == "SECRETARIA GENERAL DE ACUERDOS" )
                                                        <option
                                                            value="{{$user->name}} {{$user->apellido_p}} {{$user->apellido_m}}">
                                                            {{$user->funcion}} {{$user->name}} {{$user->apellido_p}}
                                                            {{$user->apellido_m}}
                                                        </option>
                                                        @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo"></div>
                                                </div>
                                            </div>
                                            <div class="form-group col-12">
                                                <label for="contestacion">Ponente<span
                                                        class="text-danger">*</span></label>
                                                <input type="text" id="ponente" name="ponente" required
                                                    placeholder="Nombre del ponente"
                                                    value="{{$ponente->name}} {{$ponente->apellido_p}} {{$ponente->apellido_m}}"
                                                    onkeypress="return caracteres(event)" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 mr-auto mr-6 mb-6">
                                                <div class="form-group">
                                                    <label for="userName">Agregar firmantes<span class="text-danger">*
                                                            (En el
                                                            orden deseado para
                                                            su firma)</span></label>
                                                    <select class="form-control" style="width: 100%" name="firmantes"
                                                        id="firmantes" required
                                                        data-placeholder="Seleccione una opción ...">
                                                        <option value="" selected>Seleccione una opción</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}">
                                                            {{$user->funcion}}: {{$user->name}} {{$user->apellido_p}}
                                                            {{$user->apellido_m}}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    <div class="text-danger" id='error_tipo_acuerdo'
                                                        name="error_tipo_acuerdo">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <a class="btn waves-effect btn-secondary"
                                                        onclick="llenar_firmante();recorre_tabla();">Agregar </a>
                                                </div>
                                                <div class="porlets-content">
                                                    <div class="table-responsive">
                                                        <table class="display table table-bordered table-striped"
                                                            name="detalles[]" id="detalles" id="dynamic-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Eliminar </th>
                                                                    <th>Número de firma </th>
                                                                    <th>Usuario </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <!--/porlets-content-->
                                                </div>
                                                <!--/block-web-->
                                            </div>
                                        </div>
                                        <input id="array" name="array[]" type="hidden">
                                        <div class="row">
                                            <div class="col-6">






                                            </div>

                                        </div>


                                    </section>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div> <!-- end row -->



    </div> <!-- end container-fluid -->
</div>
<!-- end wrapper -->



@stop
@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $(".select2-multiple").select2({
        width: '100%'
    });
    $('.select2-multiple').val(null).trigger('change');

    id = '{{ $expediente->id }}';
    traerExpediente(id, 'detalle');

    //$('#tipoAcuerdo').select2({});
    //$('#promocion').select2({});
});

function pdf_acuerdo() {
    alert('hola mundo');
    document.getElementById('pdf').value = "1";
    alert(document.getElementById('pdf').value);


}
</script>
@endsection