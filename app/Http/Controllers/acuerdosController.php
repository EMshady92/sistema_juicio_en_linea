<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\acuerdosModel;
use App\ExpedientesModel;
use App\controlVersionesAcuerdoModel;
use App\firmaElectronicaModel;
use App\firmasAplicadasModel;
use App\asignacionFirmasModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Dompdf\Dompdf;
use Dompdf\Options;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use \PDF;
use DateTime;
use DNS2D;
use ZipArchive;
use WordPHP\WordPHP;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Storage;
use Dompdf\FontMetrics;
use Html;


class acuerdosController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR"  || $user->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || $user->funcion == "PROYECTISTA" || $user->funcion == "SECRETARIO AUXILIAR" || $user->funcion == "ADMINISTRADOR"){  
    
        //VARIABLE CON TODOD LOS ACUERDOS RELACIONADOS CON UNA PROMOCION
        $expedientes=DB::table('acuerdosgenarados')
        ->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
        ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('amparos_promociones','amparos_promociones.id','=','acuerdosgenarados.id_promocion')
        ->join('users as us','us.id','=','expedientesala.id_asignacion')
        ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->select('acuerdosgenarados.estado as estado_acuerdo','catalogo_tipos_acuerdos.tipo as tipo_acuerdo','acuerdosgenarados.id as id_acuerdo','acuerdosgenarados.version','acuerdosgenarados.num_folio','acuerdosgenarados.captura as captura_acuerdo','acuerdosgenarados.created_at as created_acuerdo','acuerdosgenarados.updated_at as updated_acuerdo',
        'us.name as name_asig','us.apellido_p as apellido_pasig','us.apellido_m as apellido_masig','salamagistrado.num_sala','expedientes.*',
        'amparos_promociones.folio as folio_promocion','amparos_promociones.id as id_promo','amparos_promociones.tipo as tipo_promocion')->get();

        //VARIABLE CON TODOD LOS ACUERDOS RELACIONADOS SIN UNA PROMOCION
        $expedientes_sin=DB::table('acuerdosgenarados')
        ->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
        ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('users as us','us.id','=','expedientesala.id_asignacion')
        ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->where('acuerdosgenarados.id_promocion','=',null)
        ->select('acuerdosgenarados.estado as estado_acuerdo','catalogo_tipos_acuerdos.tipo as tipo_acuerdo','acuerdosgenarados.id as id_acuerdo','acuerdosgenarados.version','acuerdosgenarados.num_folio','acuerdosgenarados.captura as captura_acuerdo','acuerdosgenarados.created_at as created_acuerdo','acuerdosgenarados.updated_at as updated_acuerdo',
        'us.name as name_asig','us.apellido_p as apellido_pasig','us.apellido_m as apellido_masig','salamagistrado.num_sala','expedientes.*')->get();
        //
        
        $mis_acuerdos_revisar=count(DB::table('acuerdosgenarados')
        ->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
        ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')
        ->where('personalsala.funcion','=','MAGISTRADO')
        ->where('personalsala.id_user','=',$user->id)
        ->orwhere('personalsala.funcion','=','COORDINADOR')
        ->where('personalsala.id_user','=',$user->id)
        ->orwhere('personalsala.funcion','=','SECRETARIO DE ESTUDIO Y CUENTA')
        ->where('personalsala.id_user','=',$user->id)
        ->orwhere('personalsala.funcion','=','PROYECTISTA')
        ->where('personalsala.id_user','=',$user->id)
        ->where('acuerdosgenarados.estado','=','ACUERDO_GENERADO')
        ->select('expedientes.*')->get());
     
        setlocale(LC_ALL, 'es_ES');
        $mes=date("m");
        $date = date('Y-m-d');
        $year = date("Y");
        //resto 1 año
        $year_menos=date("Y",strtotime($date."- 1 year"));
        $mes_menos=date("m",strtotime($date."- 1 month"));
        $mes_letra = strftime("%B", strtotime($date));

        $mes_letra = strftime("%B", strtotime($date));
        $acuerdos_mes=count(DB::table('acuerdosgenarados')->whereMonth('created_at','=',$mes)->get());
        $acuerdos_year=count(DB::table('acuerdosgenarados')->whereYear('created_at','=',$year)->get());
        $acuerdos_mes_menos=count(DB::table('acuerdosgenarados')->whereMonth('created_at','=',$mes_menos)->get());
        $acuerdos_year_menos=count(DB::table('acuerdosgenarados')->whereYear('created_at','=',$year_menos)->get());
        $total_acuerdos=count(DB::table('acuerdosgenarados')->get());
        
       return view ('acuerdos.index',['year'=>$year,'mes_letra'=>$mes_letra,'total_acuerdos'=>$total_acuerdos,'acuerdos_year_menos'=>$acuerdos_year_menos,'acuerdos_mes_menos'=>$acuerdos_mes_menos,'acuerdos_year'=>$acuerdos_year,'acuerdos_mes'=>$acuerdos_mes,'expedientes_sin'=>$expedientes_sin,'mis_acuerdos_revisar'=>$mis_acuerdos_revisar,'expedientes'=>$expedientes]);
    }else{
        return Redirect::to('acuerdos')->with('errors', 'No cuenta con suficientes persmisos para entrar a este módulo');
    }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
       
        $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$id)->get();        
        $tipos=DB::table('catalogo_tipos_acuerdos')->where('estado','=','ACTIVO')->get();
        $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
        ->where('acuerdosgenarados.id','=',$id)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
        $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->where('expedientes.id','=',$id)->select('expedientes.*','detalle_expediente.escaneo_escrito','detalle_expediente.num_anexos',
        'detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.created_at as created_detalle')->first();
        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$id)->get();

        $tipo_juicio=DB::table('tipos_juicios')->where('estado','=','ACTIVO')->get();
        $tipo_documentos=DB::table('tipodocumento')->where('estado','=','ACTIVO')->get();        
        $users=DB::table('users')->where('estado','=','ACTIVO')->orderBy('funcion','ASC')->get();

        $ponente=DB::table('expedientesala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')
        ->join('users','users.id','=','personalsala.id_user')
        ->where('expedientes.id','=',$id)
        ->where('personalsala.funcion','=','MAGISTRADO')
        ->select('salamagistrado.id as id_sala','salamagistrado.num_sala','users.name','users.apellido_p','users.apellido_m')->first();
      
     
       return view ('acuerdos.create',['ponente'=>$ponente,'users'=>$users,'tipo_documentos'=>$tipo_documentos,'tipo_juicio'=>$tipo_juicio,'amparos'=>$amparos,'expediente'=>$expediente,'tipos'=>$tipos,
       'acuerdos'=>$acuerdos,'expediente'=>$expediente,'amparos'=>$amparos,'escaneos'=>$escaneos]);
        //
    }


    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $user=Auth::user();

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  
        //GENERA LA CLAVE ALFANUMERICA PARA LA ASIGNACION
        for($a=0; $a < 100; $a++){
        $clave_alfa_asig= substr(str_shuffle($permitted_chars), 0, 30);
          $valida_clave=DB::table('asignaciones_firma')->where('clave_alfanumerica','==',$clave_alfa_asig)->get();
           if($valida_clave == null){
               $clave_alfa_asig=$clave_alfa_asig;
               break;
           }
       }
        //GENERA EL NUMERO DE ASIGNACION
        $num_asignacion=DB::table('asignaciones_firma')->orderBy('num_asignacion','DESC')->first();
        if($num_asignacion <> null){       
         $num_asignacion=intval($num_asignacion->num_asignacion)+1;
         }else{
         $num_asignacion=1;
     }


        $acuerdo = new acuerdosModel;       
        $acuerdo->id_expediente=$id;
        $valida=DB::table('acuerdosgenarados')->where('id_expediente','=',$id)->orderBy('num_folio','DESC')->first();
        if($valida <> null){
            $folio=intval($valida->num_folio)+1;
        }else{
            $folio=1;           
        }
        $version=1;
        $acuerdo->num_folio=$folio;
        $acuerdo->estado="ACUERDO_GENERADO";
        $acuerdo->id_tipo_acuerdo=$request->get('tipoAcuerdo');      
        $acuerdo->tiempo_contestacion=$request->get('tiempo_contestacion');
        //
        if($request->get('radioInline') == "SI"){    
            $acuerdo->id_promocion=$request->get('promocion');    
        }


        
        $acuerdo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;        
        $nombreArchivo =  "ACUERDO-".$acuerdo->num_folio."-VERSION-".$version.".pdf";
        $nombreArchivoWord =  "ACUERDO-".$acuerdo->num_folio."-VERSION-".$version.".docx";
        $acuerdo->acuerdo=$nombreArchivo;
        $acuerdo->observaciones=$request->get('observaciones');
        $acuerdo->version=$version;
        $acuerdo->acuerdo_text=$request->get('acuerdo');
        $acuerdo->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","acuerdosgenarados","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).' "," ","El usuario genero un acuerdo")');    
    
        
        //GUARDA LA VERSION DEL ACUERDO
        $controlVersion = new controlVersionesAcuerdoModel;
        $controlVersion->id_acuerdo=$acuerdo->id;
        $controlVersion->acuerdo_text=$request->get('acuerdo');
        $controlVersion->acuerdo=$nombreArchivo;
        $controlVersion->observaciones=$request->get('observaciones');
        $controlVersion->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;    
        $controlVersion->version=$version;
        $controlVersion->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","controlversionesacuerdo","'.$controlVersion->id.'","'.base64_encode(json_encode($controlVersion)).'"," ","El usuario genero la versión '.$version.' del acuerdo.")');   


        //SE ACTUALIZA EL ESTADO DEL EXPEDIENTE
        $expediente=ExpedientesModel::findOrfail($acuerdo->id_expediente);
        $expediente->estado="ACUERDO_GENERADO";
        $expediente->ubicacion="SALA";
        $expediente->captura=$acuerdo->captura;
        $expediente->update();

       

        $contenido = $request->get('acuerdo');
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->isHtml5ParserEnabled(true);
        $options->set('isPhpEnabled', 'true');
        $aux="<style type='text/css'> @page { text-align:justify; margin-right:3cm; margin-left:3cm; margin-top:3cm; margin-bottom:3cm; width: 21.59cm;
            inline-block; line-height: 150%;
            height: 33.02cm; line-height:1em;}  img {
                      height:800px!important;
                      width:620px!important;
                    }
                    .logo {
                      height:200px!important;
                      width:200px!important;
                    }
                    </style>";
        
        $firma_1 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS "; // devuelve "d"
        $firma_2 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"
        $firma_3 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"  	    

        $tipo_acuerdo=DB::table('catalogo_tipos_acuerdos')->where('id','=',$request->get('tipoAcuerdo'))->first(); 
       
        $actores=DB::table('expediente_actor')->join('personas','personas.id','=','expediente_actor.id_actor')->where('expediente_actor.id_expediente','=',$id)->get();
       $actores_aux="";      
        if($actores){
            foreach($actores as $act){
            if($act->tipo == "AUTORIDAD"){
                $nombre=$act->nombre;
            }elseif($act->tipo == "FISICA"){
                $nombre=$act->nombre." ".$act->apellido_paterno." ".$act->apellido_materno;
            }elseif($act->tipo == "MORAL"){
                $nombre=$act->razon_social;
            }
            if($actores_aux == ""){
                $actores_aux=$nombre;
            }else{
                $actores_aux=$actores_aux.",".$nombre;                
            }
        }
       }



        $encabezado= '<p></p>
        <table style="border:none;">
        <tbody style="border:none;">
        <tr style="border:none;">
        <td style="border:none;">
        <div class="logo"><img class="logo" src="https://www.sijel.com.mx/img/logo_tja.png" width="200" height="200" alt="" style="border:none;" /></div>
        </td>
        <span style="font-family: "Arial"; font-size: 14pt;"> 
        <td style="border:none;">      
        <h4>Expediente: <strong>'.$request->get('num_exp').'</strong></h4>
        <h4>AUTO:'.$tipo_acuerdo->tipo.'.</h4>
        <h4>ACTOR:'.$actores_aux.' .</strong></h4>     
        </td>
        </tr>
        </tbody>
        </table>
        <p></p>';

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($aux.$encabezado.$contenido);
        $dompdf->render();
        $dompdf->setPaper('letter', 'portrait');
        $canvas = $dompdf->getCanvas();
   // $canvas->set_opacity(.5,'Multiply');//Multiply means apply to all pages.
    // Specify watermark text
    $sello_marca="Clave alfanumerica:".$clave_alfa_asig;

    // Instantiate font metrics class
    $fontMetrics = new FontMetrics($canvas, $options);
    $font = $fontMetrics->getFont('times');

    //$x = (($w-$textWidth)/2);42.68
    $canvas->page_text(10, 770, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    //page_text method applies text to all pages.
    $canvas->page_text(580, 50, $firma_1, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0);  
    $canvas->page_text(575, 50, $firma_2, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0);       
    $canvas->page_text(570, 50, $firma_3, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0);               
            $canvas->set_opacity(.5,'Multiply'); 
             $canvas->page_text(10, 50, $sello_marca, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0); 
            $canvas->page_script('
            $pdf->set_opacity(.5,"Multiply");
           $pdf->image("img/logo_extendido.png","png", 300,600,200,700);
          ');
    
        $output = $dompdf->output();
        file_put_contents('SALAS/acuerdos/'. $nombreArchivo, $output);

       
        
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $html = $contenido;
      //  Html::addHtml($section, $html);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $cacheDir = 'public/DOCUMENTOSPARAFIRMA/';
        $objWriter->save($cacheDir. $nombreArchivoWord);

        //GENERA LAS ASIGNACIONES
        $tabla = $request->get('array');
        if($tabla){
              foreach($tabla as $_aux){
              $elements = explode(",", $_aux);
              for ($i = 0; $i < count($elements); $i++) {                
              $asignacion = new asignacionFirmasModel;
              $asignacion->id_user=$elements[$i];
              $asignacion->id_acuerdo=$acuerdo->id;
              $asignacion->id_solicita=$user->id;
              $asignacion->num_expediente=$request->get('num_exp');
              $asignacion->num_asignacion=$num_asignacion;
              $asignacion->clave_alfanumerica=$clave_alfa_asig;
              $asignacion->txt=$contenido;
              $asignacion->docx=$nombreArchivoWord;
              $asignacion->tipo_documento=$request->get('tipoDocumento');
              $asignacion->tipo_expediente=$request->get('tipoExpediente');
              $asignacion->tipo_juicio=$request->get('tipoJuicio');
              $asignacion->sala=$request->get('sala');
              $asignacion->ponente=$request->get('ponente');
              $asignacion->proyectista=$request->get('proyectista');
              $asignacion->auto=$tipo_acuerdo->tipo;
              $asignacion->actores=$actores_aux;
              $asignacion->observaciones="";
              $asignacion->estado="POR_VALIDAR";
              $asignacion->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
              $asignacion->save();            
              DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","asignaciones_firma","'.$asignacion->id.'","'.base64_encode(json_encode($asignacion)).'"," ","El usuario asigno el documento para revisión y firma.")');  

            }
        }
        }

        //$dompdf->stream("sample.pdf");
        return Redirect::to('/guardado/'.$acuerdo->id)->with('errors', 'Se ha enviado el acuerdo al Coordinador y Magistrado de tu Sala, para su revisión.');
        
       // $data=$request->get('acuerdo');

        //$view =  \View::make('acuerdos.invoice', compact('acuerdo','data'))->render();
        //->setPaper($customPaper, 'landscape');        
        //Nombre del Documento.
       
       // $pdf->loadHTML($view)->save('SALAS/acuerdos/'. $nombreArchivo);
        //return redirect::to('guardado',[$acuerdo->id]);
       // return Redirect::to('/guardado/'.$acuerdo->id);
        //return $pdf->stream($nombreArchivo);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $versiones=DB::table('controlversionesacuerdo')
        ->join('acuerdosgenarados','acuerdosgenarados.id','=','controlversionesacuerdo.id_acuerdo')
        ->where('acuerdosgenarados.id','=',$id)
        ->select('controlversionesacuerdo.*')->get();

        $acuerdos=DB::table('acuerdosgenarados')
        ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
        ->where('acuerdosgenarados.id','=',$id)
        ->select('acuerdosgenarados.*','catalogo_tipos_acuerdos.tipo','expedientes.num_expediente')->first();

        $promocion_relacionada=DB::table('acuerdosgenarados')
        ->join('amparos_promociones','amparos_promociones.id','=','acuerdosgenarados.id_promocion')
        ->where('acuerdosgenarados.id','=',$id)
        ->select('amparos_promociones.*')->first();

       return view ('acuerdos.detalle',['promocion_relacionada'=>$promocion_relacionada,'versiones'=>$versiones,'acuerdos'=>$acuerdos]);
        //
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $acuerdo= acuerdosModel::findOrFail($id);
        $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$acuerdo->id_expediente)->get();        
        $tipos=DB::table('catalogo_tipos_acuerdos')->where('estado','=','ACTIVO')->get();
        $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
        ->where('acuerdosgenarados.id','=',$id)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
        $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->where('expedientes.id','=',$acuerdo->id_expediente)->select('expedientes.*','detalle_expediente.escaneo_escrito','detalle_expediente.num_anexos',
        'detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.created_at as created_detalle')->first();
        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$acuerdo->id_expediente)->get();
        
        $users=DB::table('users')->where('estado','=','ACTIVO')->orderBy('funcion','ASC')->get();
        $asignaciones=DB::table('asignaciones_firma')->join('users','users.id','=','asignaciones_firma.id_user')
        ->select('asignaciones_firma.*','users.name','users.apellido_p','users.apellido_m','users.funcion','users.id as id_user')
        ->where('asignaciones_firma.id_acuerdo','=',$acuerdo->id)->get();
      
       
     return view('acuerdos.edit', ['asignaciones'=>$asignaciones,'users'=>$users,'amparos'=>$amparos,'expediente'=>$expediente,'acuerdo'=>$acuerdo,'tipos'=>$tipos,
     'acuerdos'=>$acuerdos,'expediente'=>$expediente,'amparos'=>$amparos,'escaneos'=>$escaneos]);


        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=Auth::user();
        $acuerdo= acuerdosModel::findOrFail($id);
        $acuerdo_ant=acuerdosModel::findOrFail($id);
   
        //ACTUALIZA EL NUMERO DE VERSION DEL ACUERDO
        $valida=DB::table('acuerdosgenarados')->where('id','=',$id)->orderBy('num_folio','DESC')->first();
        if($valida <> null){       
            $version=intval($valida->version)+1;
        }else{
            $version=1;
        }
        $nombreArchivo =  "ACUERDO-".$acuerdo->num_folio."-VERSION-".$version.".pdf";
        $nombreArchivoWord =  "ACUERDO-".$acuerdo->num_folio."-VERSION-".$version.".docx";
        $acuerdo->acuerdo=$nombreArchivo;
        $acuerdo->acuerdo_text=$request->get('acuerdo');
        $acuerdo->observaciones=$request->get('observaciones');
        $acuerdo->id_tipo_acuerdo=$request->get('tipoAcuerdo');
        $acuerdo->tiempo_contestacion=$request->get('tiempo_contestacion');
        $acuerdo->version=$version;
   
        //GENERA EL NUEVO PDF DE LA VERSION
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->isHtml5ParserEnabled(true);
        $options->set('isPhpEnabled', 'true');
        $aux="<style type='text/css'> @page { text-align:justify; margin-right:3cm; margin-left:3cm; margin-top:3cm; margin-bottom:3cm; width: 21.59cm;
            height: 33.02cm; inline-block; line-height: 150%;}  img {
                      height:800px!important;
                      width:620px!important;
                    }
                    .logo {
                      height:200px!important;
                      width:200px!important;
                    }
                    </style>";
        
        $firma_1 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS "; // devuelve "d"
        $firma_2 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"
        $firma_3 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"  	 
        $tipo_acuerdo=DB::table('tipoAcuerdo')->where('id','=',$request->get('tipoAcuerdo')); 
        $auto=mb_convert_encoding($tipo_acuerdo,'HTML-ENTITIES','UTF-8');  
        $encabezado= '<p></p>
        <table style="border:none;">
        <tbody style="border:none;">
        <tr style="border:none;">
        <td style="border:none;">
         <div class="logo"><img class="logo" src="https://www.sijel.com.mx/img/logo_tja.png" width="200" height="200" alt="" style="border:none;" /></div>
        </td>
        <span style="font-family: "Arial"; font-size: 14pt;"> 
        <td style="border:none;">      
        <h4>Expediente: <strong>'.$request->get('num_exp').'</strong></h4>
        <h4>AUTO:'.$auto.'.</h4>
        <h4>ACTOR: .</strong></h4>     
        </td>
        </tr>
        </tbody>
        </table>
        <p></p>';

         //GENERA EL NUEVO ACUERDO PDF
         $options = new Options();
         $options->setIsRemoteEnabled(true);
         $options->isHtml5ParserEnabled(true);
         $options->set('isPhpEnabled', 'true');
         $dompdf = new Dompdf($options);
         $dompdf->loadHtml($aux.$encabezado.$acuerdo->acuerdo_text);
         $dompdf->render();
         $dompdf->setPaper('letter', 'portrait');
         $canvas = $dompdf->getCanvas();
    // $canvas->set_opacity(.5,'Multiply');//Multiply means apply to all pages.
     // Specify watermark text
     $sello_marca="Clave alfanumerica: DOCUMENTO NO VALIDO - FALTAN FIRMAS";
 
     // Instantiate font metrics class
     $fontMetrics = new FontMetrics($canvas, $options);
     $font = $fontMetrics->getFont('times');
 
     //$x = (($w-$textWidth)/2);42.68
     $canvas->page_text(10, 770, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
     //page_text method applies text to all pages.
     $canvas->page_text(580, 50, $firma_1, $font, 5,$color = array(0,0,0), 
             $word_space = 0.0, $char_space = 0.0, $angle = 90.0);  
     $canvas->page_text(575, 50, $firma_2, $font, 5,$color = array(0,0,0), 
             $word_space = 0.0, $char_space = 0.0, $angle = 90.0);       
     $canvas->page_text(570, 50, $firma_3, $font, 5,$color = array(0,0,0), 
             $word_space = 0.0, $char_space = 0.0, $angle = 90.0);               
             $canvas->set_opacity(.5,'Multiply'); 
              $canvas->page_text(10, 50, $sello_marca, $font, 5,$color = array(0,0,0), 
             $word_space = 0.0, $char_space = 0.0, $angle = 90.0); 
             $canvas->page_script('
             $pdf->set_opacity(.5,"Multiply");
            $pdf->image("img/logo_extendido.png","png", 300,600,200,700);
           ');
     
         $output = $dompdf->output();
         file_put_contents('SALAS/acuerdos/'. $nombreArchivo, $output);
   

        $acuerdo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
        $acuerdo->estado="ACUERDO_GENERADO";
        $acuerdo->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","acuerdosgenarados","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).'","'.base64_encode(json_encode($acuerdo_ant)).'","El usuario modifico el acuerdo.")');   

       
        //GUARDA LA NUEVA VERSION DEL ACUERDO
        $controlVersion = new controlVersionesAcuerdoModel;
        $controlVersion->id_acuerdo=$acuerdo->id;
        $controlVersion->acuerdo_text=$request->get('acuerdo');
        $controlVersion->acuerdo=$nombreArchivo;
        $controlVersion->observaciones=$request->get('observaciones');
        $controlVersion->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;    
        $controlVersion->version=$version;

        $controlVersion->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","controlversionesacuerdo","'.$controlVersion->id.'","'.base64_encode(json_encode($controlVersion)).'"," ","El usuario genero una nueva versión de el acuerdo.")');   



        //GENERA EL NUEVO WORD PARA LAS ASIGNACIONES
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $html = $acuerdo->acuerdo_text;
         //  Html::addHtml($section, $html);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $cacheDir = 'public/DOCUMENTOSPARAFIRMA/';
        $objWriter->save($cacheDir. $nombreArchivoWord);

          //ACTUALIZA tTEMPORALMENTE EL ESTADO DE LAS ASIGNACIONES
          $_asignaciones=DB::table('asignaciones_firma')->where('id_acuerdo','=',$acuerdo->id)->get();
          if($_asignaciones){
                foreach($_asignaciones as $asignacion){
                  $asig=asignacionFirmasModel::findOrFail($asignacion->id);                
                  $asig->estado="REVOCADA";
                  $asig->update();   
                  DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","asignaciones_firma","'.$asig->id.'","'.base64_encode(json_encode($asig)).'"," ","El usuario revoco la firma del usuario.")');   

  
                  $clave_alfa_asig=$asignacion->clave_alfanumerica;   
                  $num_asignacion=$asignacion->num_asignacion;            
          }
          }
                //GENERA LAS ASIGNACIONES NUEVAS Y ACTUALIZA LAS QUE SE QUEDARON
                $tabla = $request->get('array');
                if($tabla){
                      foreach($tabla as $_aux){
                      $elements = explode(",", $_aux);
                      for ($i = 0; $i < count($elements); $i++) {       
                     $comprueba=DB::table('asignaciones_firma')->where('id_acuerdo','=',$acuerdo->id)->where('id_user','=',$elements[$i])->get(); 
                     if($comprueba){
                        $asig=asignacionFirmasModel::findOrFail($comprueba[0]->id);
                        $asig_ant=asignacionFirmasModel::findOrFail($comprueba[0]->id);
                        $asig->docx=$nombreArchivoWord;
                        $asig->estado="POR_VALIDAR";
                        $asig->update();     
                        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","asignaciones_firma","'.$asig->id.'","'.base64_encode(json_encode($asig)).'","'.base64_encode(json_encode($asig_ant)).'","El usuario actualizo el estado de la asignación de la firma del acuerdo.")');   
            

                     } else{
                        $asignacion = new asignacionFirmasModel;
                        $asignacion->id_user=$elements[$i];
                        $asignacion->id_acuerdo=$acuerdo->id;
                        $asignacion->id_solicita=$user->id;
                        $asignacion->num_expediente=$request->get('num_exp');
                        $asignacion->num_asignacion=$num_asignacion;
                        $asignacion->clave_alfanumerica=$clave_alfa_asig;
                        $asignacion->txt=$request->get('acuerdo');;
                        $asignacion->docx=$nombreArchivoWord;
                        $asignacion->tipo_documento=$request->get('tipoDocumento');
                        $asignacion->tipo_expediente=$request->get('tipoExpediente');
                        $asignacion->tipo_juicio=$request->get('tipoJuicio');
                        $asignacion->sala=$request->get('sala');
                        $asignacion->ponente=$request->get('ponente');
                        $asignacion->proyectista=$request->get('proyectista');     
                        $asignacion->estado="POR_VALIDAR";
                        $asignacion->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
                        $asignacion->save();       
                        DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","asignaciones_firma","'.$asignacion->id.'","'.base64_encode(json_encode($asignacion)).'"," ","El usuario asigno el documento para revisión y firma.")');  
     
                     }       
                      
                    }
                }
                }
              


      return Redirect::to('acuerdos')->with('errors', 'Se ha enviado nuevamente el acuerdo al Coordinador y Magistrado de tu Sala, para su revisión.');

        //
    }

    //FUNCION PARA UNA VEZ GUARDADO EL ACUERDO, MUESTRE LA INFORMACION Y SE PUEDA IMPRIMIR 
    public function guardado ($id){
        $acuerdo= acuerdosModel::findOrFail($id);
        
        $DetalleExp=DB::table('detalle_expediente')->where('id_expediente','=',$acuerdo->id_expediente)->first();
        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$acuerdo->id_expediente)->get();
        $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$acuerdo->id_expediente)->get();

      
              
      
       
        $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->where('expedientes.id','=',$acuerdo->id_expediente)->select('expedientes.*','detalle_expediente.escaneo_escrito','detalle_expediente.num_anexos',
        'detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.created_at as created_detalle')->first();

        $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
        ->where('acuerdosgenarados.id_expediente','=',$expediente->id)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
        
        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$acuerdo->id_expediente)->get();


        $expediente_sala=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('expedientesala.id_expediente','=',$acuerdo->id_expediente)->select('salamagistrado.num_sala','users.*')->first();
       
        return view('acuerdos.guardado', ['acuerdos'=>$acuerdos,'acuerdo'=>$acuerdo,'expediente_sala'=>$expediente_sala,'expediente'=>$expediente,
        'DetalleExp'=>$DetalleExp,'amparos'=>$amparos,'escaneos'=>$escaneos])->with('errors', 'Se ha mandado el expediente:'.$expediente->num_expediente.' para su revisión.');


    }

    public function invoice($id){

        $user=Auth::user();
        $acuerdo= acuerdosModel::findOrFail($id);      
        $options = new Options();
        $options->setIsRemoteEnabled(true);
        $options->isHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($acuerdo->acuerdo_text);
        $dompdf->render();
         $dompdf->stream('SALAS/acuerdos/'. $acuerdo->$acuerdo, array("Attachment" => false));
         

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function revisarAcuerdos(){
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->funcion == "ADMINISTRADOR"){  
    
        //VARIABLE CON TODOD LOS ACUERDOS RELACIONADOS CON UNA PROMOCION
        $expedientes=DB::table('acuerdosgenarados')->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
        ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')
        ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->where('personalsala.id_user','=',$user->id)
        ->select('acuerdosgenarados.estado as estado_acuerdo','catalogo_tipos_acuerdos.tipo as tipo_acuerdo','acuerdosgenarados.id as id_acuerdo','acuerdosgenarados.version','acuerdosgenarados.num_folio','acuerdosgenarados.captura as captura_acuerdo','acuerdosgenarados.created_at as created_acuerdo','acuerdosgenarados.updated_at as updated_acuerdo',
        'salamagistrado.num_sala','expedientes.*')->get();

        
        //
        $mis_acuerdos_revisar=count(DB::table('acuerdosgenarados')
        ->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
        ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')
        ->where('acuerdosgenarados.estado','=','ACUERDO_GENERADO')
        ->where('personalsala.id_user','=',$user->id)
        ->where('personalsala.funcion','=','MAGISTRADO')
        ->orwhere('personalsala.funcion','=','COORDINADOR')   
        ->where('personalsala.id_user','=',$user->id)
         ->select('expedientes.*')->get());
     
        setlocale(LC_ALL, 'es_ES');
        $mes=date("m");
        $date = date('Y-m-d');
        $year = date("Y");
        //resto 1 año
        $year_menos=date("Y",strtotime($date."- 1 year"));
        $mes_menos=date("m",strtotime($date."- 1 month"));
        $mes_letra = strftime("%B", strtotime($date));

        $mes_letra = strftime("%B", strtotime($date));
        $acuerdos_mes=count(DB::table('acuerdosgenarados')->whereMonth('created_at','=',$mes)->get());
        $acuerdos_year=count(DB::table('acuerdosgenarados')->whereYear('created_at','=',$year)->get());
        $acuerdos_mes_menos=count(DB::table('acuerdosgenarados')->whereMonth('created_at','=',$mes_menos)->get());
        $acuerdos_year_menos=count(DB::table('acuerdosgenarados')->whereYear('created_at','=',$year_menos)->get());
        $total_acuerdos=count(DB::table('acuerdosgenarados')->get());

        return view ('acuerdos.acuerdosRevisar',['year'=>$year,'mes_letra'=>$mes_letra,'total_acuerdos'=>$total_acuerdos,'acuerdos_year_menos'=>$acuerdos_year_menos,
        'acuerdos_mes_menos'=>$acuerdos_mes_menos,'acuerdos_year'=>$acuerdos_year,'acuerdos_mes'=>$acuerdos_mes,'mis_acuerdos_revisar'=>$mis_acuerdos_revisar,'expedientes'=>$expedientes]);
    }else{
        return Redirect::to('acuerdos')->with('errors', 'No cuenta con suficientes persmisos para entrar a este módulo');
    }
        
    }
        



    //ENVIA EL ACUERDO SELECCIONADO
    public function revisarAcuerdo($id){
              

         $acuerdo_aux=DB::table('acuerdosgenarados')
        ->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
        ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('users as us','us.id','=','expedientesala.id_asignacion')
        ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->where('acuerdosgenarados.id','=',$id)
        ->select('catalogo_tipos_acuerdos.tipo','us.name as name_asig','us.apellido_p as apellido_pasig','us.apellido_m as apellido_masig','salamagistrado.num_sala','acuerdosgenarados.*')->get();
        
        
        $expediente= ExpedientesModel::findOrFail($acuerdo_aux[0]->id_expediente);
        $DetalleExp=DB::table('detalle_expediente')->where('id_expediente','=',$acuerdo_aux[0]->id_expediente)->first();
        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$acuerdo_aux[0]->id_expediente)->get();
        $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$acuerdo_aux[0]->id_expediente)->get();
        $expediente_sala=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('expedientesala.id_expediente','=',$acuerdo_aux[0]->id_expediente)->select('salamagistrado.num_sala','users.*')->first();

        $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->where('acuerdosgenarados.id_expediente','=',$acuerdo_aux[0]->id_expediente)
        ->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
        
         $tipos=DB::table('catalogo_tipos_acuerdos')->where('estado','=','ACTIVO')->get();

     return view('acuerdos.acuerdoRevisado', ['tipos'=>$tipos,'acuerdos'=>$acuerdos,'acuerdo_aux'=>$acuerdo_aux,'expediente_sala'=>$expediente_sala,'expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'amparos'=>$amparos,'escaneos'=>$escaneos])->with('errors', 'Mostrando datos del expediente:'.$expediente->num_expediente);
        
    }

     public function guardarAcuerdoRev(request $request,$id){

     $option = $request->get('correcto');
     $user=Auth::user();
     $acuerdo= acuerdosModel::findOrFail($id);
     $acuerdo_ant=acuerdosModel::findOrFail($id);

     //manda el acuerdo a firma si es correcto actualiza su estado a pendiente
     if($option=="ACUERDO_CORRECTO" || $option =="ACUERDO_CON_CORRECCIONES_APLICADAS"){   
    $asignaciones=DB::table('asignaciones_firma')->where('id_acuerdo','=',$acuerdo->id)->where('estado','=','POR_VALIDAR')->get();   
     if($asignaciones){
         foreach($asignaciones as $asignacion){
             $asig=asignacionFirmasModel::findOrFail($asignacion->id);
             $asig->estado="PENDIENTE";
             //$asig->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
             $asig->update();           
           }        

     }
    }

     if($option=="ACUERDO_CON_CORRECCIONES" || $option =="ACUERDO_CON_CORRECCIONES_APLICADAS"){              
    //ACTUALIZA EL NUMERO DE VERSION DEL ACUERDO
     $valida=DB::table('acuerdosgenarados')->where('id','=',$id)->orderBy('num_folio','DESC')->first();
     if($valida <> null){       
         $version=intval($valida->version)+1;
     }else{
         $version=1;
     }
     $nombreArchivo =  "ACUERDO-".$acuerdo->num_folio."-VERSION-".$version.".pdf";
     $nombreArchivoWord =  "ACUERDO-".$acuerdo->num_folio."-VERSION-".$version.".docx";
     $acuerdo->acuerdo=$nombreArchivo;
     $acuerdo->acuerdo_text=$request->get('acuerdo');
     $acuerdo->observaciones=$request->get('observaciones');
     $acuerdo->id_tipo_acuerdo=$request->get('tipoAcuerdo');
     $acuerdo->tiempo_contestacion=$request->get('tiempo_contestacion');
     $acuerdo->version=$version;

        //GENERA EL NUEVO WORD PARA LAS ASIGNACIONES
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
        $html = $acuerdo->acuerdo_text;
         //  Html::addHtml($section, $html);
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $cacheDir = 'public/DOCUMENTOSPARAFIRMA/';
        $objWriter->save($cacheDir. $nombreArchivoWord);

                //ACTUALIZA EL WORD DE  LAS ASIGNACIONES
                $_asignaciones=DB::table('asignaciones_firma')->where('id_acuerdo','=',$acuerdo->id)->get();
                if($_asignaciones){
                      foreach($_asignaciones as $asignacion){
                        $asig=asignacionFirmasModel::findOrFail($asignacion->id);
                        $asig->docx=$nombreArchivoWord;
                        $asig->update();         
                        $num_expediente=$asignacion->num_expediente; 
                        $clave_alfanumerica=$asignacion->clave_alfanumerica;               
                }
                }

       //GENERA EL NUEVO PDF DE LA VERSION
       $options = new Options();
       $options->setIsRemoteEnabled(true);
       $options->isHtml5ParserEnabled(true);
       $options->set('isPhpEnabled', 'true');
       $aux="<style type='text/css'> @page { text-align:justify; margin-right:3cm; margin-left:3cm; margin-top:3cm; margin-bottom:3cm; width: 21.59cm;
           height: 33.02cm; inline-block; line-height: 150%;}  img {
                     height:800px!important;
                     width:620px!important;
                   }
                   .logo {
                     height:200px!important;
                     width:200px!important;
                   }
                   </style>";
       
       $firma_1 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS "; // devuelve "d"
       $firma_2 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"
       $firma_3 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"  	    
       $encabezado= '<p></p>
       <table style="border:none;">
       <tbody style="border:none;">
       <tr style="border:none;">
       <td style="border:none;">
        <div class="logo"><img class="logo" src="https://www.sijel.com.mx/img/logo_tja.png" width="200" height="200" alt="" style="border:none;" /></div>
       </td>
       <span style="font-family: "Arial"; font-size: 14pt;"> 
       <td style="border:none;">      
       <h4>Expediente: <strong>'.$request->get('num_exp').'</strong></h4>
       <h4>AUTO: Causa ejecutoria la sentencia y se requiere cumplimiento.</h4>
       <h4>ACTOR: .</strong></h4>     
       </td>
       </tr>
       </tbody>
       </table>
       <p></p>';          

      //GENERA EL NUEVO ACUERDO PDF
      $options = new Options();
      $options->setIsRemoteEnabled(true);
      $options->isHtml5ParserEnabled(true);
      $options->set('isPhpEnabled', 'true');
      $dompdf = new Dompdf($options);
      $dompdf->loadHtml($aux.$encabezado.$acuerdo->acuerdo_text);
      $dompdf->render();
      $dompdf->setPaper('letter', 'portrait');
      $canvas = $dompdf->getCanvas();
 // $canvas->set_opacity(.5,'Multiply');//Multiply means apply to all pages.
  // Specify watermark text
  $sello_marca="Clave alfanumerica:".$clave_alfa_asig;

  // Instantiate font metrics class
  $fontMetrics = new FontMetrics($canvas, $options);
  $font = $fontMetrics->getFont('times');

  //$x = (($w-$textWidth)/2);42.68
  $canvas->page_text(10, 770, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
  //page_text method applies text to all pages.
  $canvas->page_text(580, 50, $firma_1, $font, 5,$color = array(0,0,0), 
          $word_space = 0.0, $char_space = 0.0, $angle = 90.0);  
  $canvas->page_text(575, 50, $firma_2, $font, 5,$color = array(0,0,0), 
          $word_space = 0.0, $char_space = 0.0, $angle = 90.0);       
  $canvas->page_text(570, 50, $firma_3, $font, 5,$color = array(0,0,0), 
          $word_space = 0.0, $char_space = 0.0, $angle = 90.0);               
          $canvas->set_opacity(.5,'Multiply'); 
           $canvas->page_text(10, 50, $sello_marca, $font, 5,$color = array(0,0,0), 
          $word_space = 0.0, $char_space = 0.0, $angle = 90.0); 
          $canvas->page_script('
          $pdf->set_opacity(.5,"Multiply");
         $pdf->image("img/logo_extendido.png","png", 300,600,200,700);
        ');
  
      $output = $dompdf->output();
      file_put_contents('SALAS/acuerdos/'. $nombreArchivo, $output);

     }
     $acuerdo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
     $acuerdo->estado=$request->get('correcto');
     $acuerdo->update();
     DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","acuerdosgenarados","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).'","'.base64_encode(json_encode($acuerdo_ant)).'","El usuario actualizo el acuerdo.")');  

    
     if($option=="ACUERDO_CON_CORRECCIONES" || $option =="ACUERDO_CON_CORRECCIONES_APLICADAS"){  
     //GUARDA LA NUEVA VERSION DEL ACUERDO
     $controlVersion = new controlVersionesAcuerdoModel;
     $controlVersion->id_acuerdo=$acuerdo->id;
     $controlVersion->acuerdo_text=$request->get('acuerdo');
     $controlVersion->acuerdo=$nombreArchivo;
     $controlVersion->observaciones=$request->get('observaciones');
     $controlVersion->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;    
     $controlVersion->version=$version;
     }

    //REGRESA LA INFORMACION EL ACUERDO   
     $acuerdo=DB::table('expedientes')->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
     ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
     ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')
     ->join('users as us','us.id','=','expedientesala.id_asignacion')
     ->join('acuerdosgenarados','acuerdosgenarados.id_expediente','=','expedientes.id')
     ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
     ->where('acuerdosgenarados.id','=',$id)->
     select('expedientes.ubicacion','expedientes.num_expediente','catalogo_tipos_acuerdos.tipo','us.name as name_asig','us.apellido_p as apellido_pasig','us.apellido_m as apellido_masig','salamagistrado.num_sala',
     'acuerdosgenarados.*')->first();

    
      if($option=="ACUERDO_CON_CORRECCIONES"){
              //GUARDA LA VERSION DEL ACUERDO      
        $controlVersion->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","controlversionesacuerdo","'.$controlVersion->id.'","'.base64_encode(json_encode($controlVersion)).'"," ","El usuario genero una nueva versión del acuerdo.")');  


      return Redirect::to('revisarAcuerdos')->with('errors', 'Se han enviado las correciónes al asignado del expediente');
       }elseif($option =="ACUERDO_CON_CORRECCIONES_APLICADAS" || $option =="ACUERDO_CORRECTO"){
           //SI TUVO CORRECIONES GUARDA LA VERSION DEL ACUERDO
           if($option =="ACUERDO_CON_CORRECCIONES_APLICADAS"){
            $controlVersion->save(); 
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","controlversionesacuerdo","'.$controlVersion->id.'","'.base64_encode(json_encode($controlVersion)).'"," ","El usuario genero una nueva versión del acuerdo.")');  


           }
                   
 //TRAEMOS EL NUM DE EXPEDIENTE Y CLAVE ALFA
 $_asignaciones=DB::table('asignaciones_firma')->where('id_acuerdo','=',$acuerdo->id)->first();
 $num_expediente=$_asignaciones->num_expediente; 
 $clave_alfanumerica=$asignacion->clave_alfanumerica;         

    //VRIABLE PARA TRAER EL NUMERO DE ASIGNACION
    $firma_aux_aplicada=DB::table('asignaciones_firma')->where('id_user','=',$user->id)->where('num_expediente','=',$num_expediente)->where('clave_alfanumerica','=',$clave_alfanumerica)->first();
    //VALIDA SI SE ASIGNO LA FIRMA A ESE USUARIO- SI ES ASI PROCEDE A LA FIRMA , SI NO SOLO LO REDIRECCIONA Y ASIGNA LAS FIRMAS
      if($firma_aux_aplicada <> null){
        return Redirect::to('firmarAsignacion/'.$firma_aux_aplicada->id)->with('errors','Acuerdo generado correctamente, Favor de ingresar sus credenciales, para continuar con el proceso de firma');
     }else{
       return Redirect::to('misFirmas')->with('errors','Acuerdo generado correctamente, Se ha enviado el acuerdo para la firma');
        
     }

       }
}


public function firmarAcuerdo(request $request, $id){
     $user=Auth::user();
    require_once('./tcpdf/tcpdf.php');
    
     // TRAEMOS TODOS LOS DATOS DEL EXPEDIENTE Y ACUERDO
      $acuerdo=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')->select('acuerdosgenarados.*','catalogo_tipos_acuerdos.tipo')
      ->where('acuerdosgenarados.id','=',$id)->first();
      $expediente=DB::table('expedientes')->where('id','=',$acuerdo->id_expediente)->first();
    $text_string=strval($acuerdo->acuerdo_text);//CONVERTIMOS EL ACUERDO EN STRING
    $text_setiquetas = strip_tags($text_string);//CONVERTIMOS EL ACUERDO SIN ETIQUETAS
    $text = html_entity_decode($text_setiquetas);//CONVERTIMOS EL ACUERDO A TEXTO PLANO
   // $text= $this->philsXMLClean($text);
  //  print_r($text);
      
    $certificado=$request->file('certificado');
    $llave=$request->file('llaveprivada');
    $file=$request->file('certificado');
    $pass=$request->get('password');
    ////TIMESTAMP
    $fecha = new DateTime();
    $fecha_firma=$fecha->format('Y-m-d');
    $fecha_hora= $fecha->format('H:i:s');
    $fecha_unix=$fecha->format('U');

     
    
    //CARGAMOS EL CERTIFICADO
     $certFile = file_get_contents($certificado);
     $keyFile = file_get_contents($llave);
     $keyPassphrase = $pass;
     $keyCheckData = array(0=>$keyFile,1=>$keyPassphrase);
     $result = openssl_x509_check_private_key($certFile,$keyCheckData);
     
     if($result == true){
        // echo 'firma correcta';
    //DESECRIPTA LA CONTRASEÑA DE LA FIRMA
     $firma=DB::table('firmaelectronica')->where('id_usuario','=',$user->id)->first();
    
     //VALIDA SI HAY FIRMA REGISTRADA CON ESE USUARIO
     if($firma <> null){
         $decrypted = Crypt::decrypt($firma->password);
         if($certFile == $firma->certificado){
        if($decrypted == $pass){
    //EJEMPLO DE FIRMA 
        //Datos que se quieren firmar:
        $datos_firma=['fecha_firma'=>$fecha_firma,'hora_firma'=>$fecha_hora,'num_firma'=>'0001','algoritmo_firma'=>'SHA256','email_firmante'=>$user->email,'funcion_firmante'=>$user->funcion,
        'firmante'=>$user->name." ".$user->apellido_p." ".$user->apellido_m];
        
    //OBETENEMOS EL ULTIMO FOLIO DE LA FIRMA Y DATOS GENERALES PARA GUARDAR LA FIRMA
       $firma_aux=DB::table('firmasaplicadas')->orderBy('num_firma','DESC')->first();
       $firma_user=DB::table('firmaelectronica')->where('id_usuario','=',$user->id)->first();
          if($firma_aux <> null){
       $folio_firma=$firma_aux->num_firma+1;
       
   }else{
       $folio_firma="0001";
   }
   
      //SE GENERA UNA CLAVE ALFANUMERICA
   $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   // Output: 54esmdr0qf
    for($a=0; $a < 100; $a++){
    $clave_alfa= substr(str_shuffle($permitted_chars), 0, 30);
      $valida_clave=DB::table('firmasaplicadas')->where('clave_alfanumerica','==',$clave_alfa)->get();
       if($valida_clave == null){
           $clave_alfa=$clave_alfa;
           break;
       }
   }
   
          //OBTENEMOS LA LLAVE PUBLICA DEL CERTIFICADO
   $pub_key = openssl_pkey_get_public(file_get_contents($certificado));
    $keyData = openssl_pkey_get_details($pub_key);
    $key_public=$keyData['key'];
    
    
    //SE GENERA EL SELLO
    //openssl_seal($data, $txt, $ekeys, array($key_public));
    $iv = openssl_random_pseudo_bytes(32);
    $Long= openssl_seal($text, $sealed, $ekeys, array($key_public),"AES256",$iv);
    $envelopeKey = $ekeys[0];
    $sello_original = base64_encode($envelopeKey);
    
   
   
            $xmlstr ="<?xml version='1.0'  encoding='utf-8'?>
<Datos>
    <expediente>
        <num_expediente>$expediente->num_expediente</num_expediente>
        <tipo_juicio>POR DEFINIR</tipo_juicio>
        <tipo>$expediente->tipo</tipo>
        <fecha_expediente>$expediente->fecha</fecha_expediente>
        <fecha_captura>$expediente->created_at</fecha_captura>
        <ultima_actualizacion>$expediente->updated_at</ultima_actualizacion>
    </expediente>

    <datos_documento>
        <tipo_documento>Acuerdo</tipo_documento>
        <folio_documento>$acuerdo->num_folio</folio_documento>
        <tiempo_contestacion>$acuerdo->tiempo_contestacion</tiempo_contestacion>
         <capturo>$acuerdo->captura</capturo>
        <fecha_captura>$acuerdo->created_at</fecha_captura>
        <ultima_actualizacion>$acuerdo->updated_at</ultima_actualizacion>
        <documento_text>$text</documento_text>

    </datos_documento>
    <datos_firmante>
        <fecha_firma>$fecha_firma</fecha_firma>
        <hora_firma>$fecha_hora</hora_firma>
         <marca_tiempo>$fecha_unix</marca_tiempo>
        <firmante>$user->name $user->apellido_p $user->apellido_m</firmante>
        <num_firma>$folio_firma</num_firma>
        <clave_alfanumerica>$clave_alfa</clave_alfanumerica>
        <algoritmo_firma>SHA256</algoritmo_firma>
        <email_firmante>$user->email</email_firmante>
        <funcion_firmante>$user->funcion</funcion_firmante>
        <sello_original>$sello_original</sello_original>
    </datos_firmante>

</Datos>";
    
    $Mensaje = $xmlstr;

    $certificado=$request->file('certificado');
    $certFile = file_get_contents($certificado);
    $llave=$request->file('llaveprivada');
    $keyFile = file_get_contents($llave);
    $pass=$request->get('password');



    //crear la firma dentro de la variable $firma (la cual es pasada por referencia)
    if (!openssl_sign($Mensaje, $firma, $keyFile, OPENSSL_ALGO_SHA256)) {
    //echo openssl_error_string(); //en el caso que la función anterior de openssl arrojará algun error, este sería visualizado gracias a esta línea
    exit;
    }
    $firma_64 = base64_encode($firma); //APLICABASE64

    if (openssl_verify($Mensaje, $firma, $key_public, 'sha256WithRSAEncryption') === 1) {
    //echo 'la firma es valida y los datos son confiables';
    } else {
    //echo 'la firma es invalida y/o los datos fueron alterados';
    }

    //GENERAMOS EL CODIGO QR
    $qr= DNS2D::getBarcodeHTML('https://www.sijel.com.mx/validadoc/'.$clave_alfa, 'QRCODE',2,2);
    

     	    	//AGREGAMOS LA FIRMA AL DOCUMENTO
	  $firma_text="	<style>
h6 {
font-family: sans-serif;
  font-weight: normal;
  font-size:0.7em;
    text-align : justify;
   word-wrap: break-word;
}

</style>
<br><br>
	  
	    <p text-align:justify>
	   <h6>
	    Fecha y hora de la firma: ".$fecha_firma." ".$fecha_hora."<br>
	    Firmante:".$user->name." ".$user->apellido_p." ".$user->apellido_m." <br>
	    Número de Folio: $folio_firma <br>
	    Clave alfanumerica: $clave_alfa <br>
	    Email : ".$user->email." <br>
	    Función : ".$user->funcion."<br><br>
	    
	    Firma: <br>".
	    $firma_64."<br>
	    Algoritmo de firmado: SHA256, resultado codificado en Base64. <br><br><br>
	    Sello original <br>".
	    $sello_original."<br>
	    <a href='https://www.sijel.com.mx/validadoc'>Url de validación del documento: https://www.sijel.com.mx/validadoc </a>".
	     $qr."<br><br>
	 
	    </h6>
     	<p>";
     	
	
    $text_aux=$text_string.$firma_text;
    
    
     //ACTUALIZA EL NUMERO DE VERSION DEL ACUERDO
     $valida=DB::table('acuerdosgenarados')->where('id','=',$id)->orderBy('num_folio','DESC')->first();
     if($valida <> null){       
         $version=intval($valida->version)+1;
     }else{
         $version=1;
     }
     
    //ACTUALIZA LA NUEVA VERSION DEL ACUERDO CON LA FIRMA
      $acuerdo= acuerdosModel::findOrFail($id);
      $acuerdo_ant= acuerdosModel::findOrFail($id);
      $nombreArchivo =  "ACUERDO-".$acuerdo->num_folio."-VERSION-".$version.".pdf";
      $acuerdo->observaciones="ACUERDO FIRMADO CON FIRMA ELECTRONICA";
      $acuerdo->version=$version;
      $acuerdo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
      $acuerdo->estado="ACUERDO FIRMADO";
      $acuerdo->acuerdo=$nombreArchivo;
      $acuerdo->acuerdo_text=$text_aux;
      $acuerdo->update();
      DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","acuerdosgenarados","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).'","'.base64_encode(json_encode($acuerdo_ant)).'","El usuario actualizo la versión del acuerdo con firma electronica.")');  

      
      //GUARDAMOS EL HISTORIAL DE LA NUEVA VERSION
     $controlVersion = new controlVersionesAcuerdoModel;
     $controlVersion->id_acuerdo=$acuerdo->id;
     $controlVersion->acuerdo_text=$text_aux;
     $controlVersion->acuerdo=$nombreArchivo;
     $controlVersion->observaciones="ACUERDO FIRMADO CON FIRMA ELECTRONICA";
     $controlVersion->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;    
     $controlVersion->version=$version;
     $controlVersion->save();
     DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","controlversionesacuerdo","'.$controlVersion->id.'","'.base64_encode(json_encode($controlVersion)).'"," ","El usuario genero la nueva versión del acuerdo con firma electronica.")');  

     
     //VERSION ANTERIOR SIN FIRMA
     $version_ant=intval($version) - 1;
     $version_ant="ACUERDO-".$acuerdo->num_folio."-VERSION-".$version_ant.".pdf";
      
      //GENERA EL PDF PARA EL ACUERDO
     $options = new Options();
    $options->setIsRemoteEnabled(true);
    $options->isHtml5ParserEnabled(true);
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($text_aux);
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents('SALAS/acuerdos/'.$nombreArchivo, $output);
   

    
    //NOMBRE DEL XML Y PDF
   $nombre_xml=$user->email."_".$fecha_firma."_".$fecha_hora;

   

   // Nos aseguramos de que la cadena que contiene el XML esté en UTF-8
    $textoXML = mb_convert_encoding($xmlstr, "UTF-8");
    // Grabamos el XML en el servidor como un fichero plano, para
	// poder ser leido por otra aplicación.
	$gestor = fopen('FIRMASEMITIDAS/XML/'.$nombre_xml.".xml", 'w');
	fwrite($gestor, $textoXML);//ESCRIBIMOS EL XML
	fclose($gestor);

    file_put_contents('FIRMASEMITIDAS/PDF/'.$nombre_xml.".pdf", $output); //GUARDAMOS EL PDF
    file_put_contents('FIRMASEMITIDAS/FIRMA/'.$nombre_xml.".dat", $firma);

     $firma_a= new firmasAplicadasModel;
     $firma_a->id_firma=$firma_user->id;
     $firma_a->num_firma=$folio_firma;
     $firma_a->firma=$firma;
     $firma_a->firma_64=$firma_64;
     $firma_a->firma_ruta=$nombre_xml.".dat";
     $firma_a->xml=$nombre_xml.".xml";
     $firma_a->pdf=$nombre_xml.".pdf";
     $firma_a->estado="ACTIVA";
     $firma_a->clave_alfanumerica=$clave_alfa;
     $firma_a->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;

     
     
   
   //////////////////////////COMPRIMIMOS EL XML Y PDF
   $zip = new ZipArchive();
   $name_zip=$nombre_xml.".zip";
 
$filename = 'FIRMASEMITIDAS/ZIP/'.$name_zip;
 
if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
        $zip->addFile("FIRMASEMITIDAS/PDF/".$nombre_xml.".pdf",$nombre_xml.".pdf");
        $zip->addFile("FIRMASEMITIDAS/XML/".$nombre_xml.".xml",$nombre_xml.".xml");
        $zip->addFile("FIRMASEMITIDAS/FIRMA/".$nombre_xml.".dat",$nombre_xml.".dat");
        $zip->close();
        $firma_a->zip=$name_zip;
        //echo 'Creado '.$filename;
}
else {
        echo 'Error creando '.$filename;
}
   
$firma_a->save();
DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","firmasaplicadas","'.$firma_a->id.'","'.base64_encode(json_encode($firma_a)).'"," ","El usuario creo una nueva firma electronica en el documento.")');  

    
   return view('firmaDocumentos.detalle',['firma_a'=>$firma_a,'datos_firma'=>$datos_firma,'name_zip'=>$name_zip,'version_ant'=>$version_ant]);
         
    }else{
    //echo 'pass incorrecto';
        return Redirect::to('acuerdos')->with('errors','Contraseña incorrecta ');
    }

    }else{
    //echo 'el certificado ingresado no coicide con el registrado en el sistema';
    return Redirect::to('acuerdos')->with('errors','El certificado ingresado no corresponde al suyo, favor de cargar las credenciales correctas o ponerse en contacto con el administrador ');
    }


    }else{
   // echo 'este usuario no tiene firma registrada';
   return Redirect::to('acuerdos')->with('errors','No tiene una firma registrada en el sistema, favor de comunicarse con el administrador');
    }


    }elseif($result == false){
    //echo 'firma incorrecta';
    return Redirect::to('acuerdos')->with('errors','El certificado y su llave privada no coicide,  favor de cargar las credenciales correctas o ponerse en contacto con el administrador ');
    }

    }


function philsXMLClean($strin) {
        $strout = null;

        for ($i = 0; $i < strlen($strin); $i++) {
                $ord = ord($strin[$i]);

                if (($ord > 0 && $ord < 32) || ($ord >= 127)) {
                        $strout .= "&amp;#{$ord};";
                }
                else {
                        switch ($strin[$i]) {
                                case '<':
                                        $strout .= '&lt;';
                                        break;
                                case '>':
                                        $strout .= '&gt;';
                                        break;
                                case '&':
                                        $strout .= '&amp;';
                                        break;
                                case '"':
                                        $strout .= '&quot;';
                                        break;
                                default:
                                        $strout .= $strin[$i];
                        }
                }
        }

        return $strout;
}



    
    }