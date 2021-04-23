<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use WordPHP\WordPHP;
use App\Http\Requests;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\ExpedientesModel;
use App\asignacionFirmasModel;
use App\ExpedienteAbogadoModel;
use App\ExpedienteDemandadoModel;
use App\ExpedienteActorModel;
use App\ExpedienteTerceraModel;
use App\DetalleExpedienteModel;
use App\AmparosPromocionesModel;
use App\ExpedienteJuicioModel;
use App\EscaneoAnexosModel;
use App\expedienteAutoridadInv;
use App\expedienteAutoridadSust;
use App\expedienteDenunciante;
use App\expedienteParticular;
use App\expedientePresuntoResp;
use App\EscaneoAnexosAmparosModel;
use App\expedienteSalaModel;
use App\HistorialExpedienteModel;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use \Crypt;


use DB;
use Illuminate\Support\Facades\Storage;
use Input;
use Illuminate\Support\Facades\Auth;
class ExpedientesController extends Controller
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
    {
        $funcion=Auth::user();
        if($funcion->funcion == "OFICIALIA PARTES" || $funcion->funcion == "ADMINISTRADOR"){
        $expedientes=DB::table('expedientes')
        ->join('tipos_juicios','tipos_juicios.id','=','expedientes.id_juicio')
        ->where('expedientes.tipo','=','RAG')->orwhere('expedientes.tipo','=','NULIDAD')
        ->select('expedientes.*','tipos_juicios.tipo as tipos')->get();
        return view('expedientes.index',['expedientes'=>$expedientes,'funcion'=>$funcion]);
    }else{
        return view('errors.permisos')->with('errors', 'Solo los miembros de una sala pueden acceder a este modulo');
       

    }
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //MANDA A LA VISTA EXPEDRIENTES.CREATE
        $date = date('Y-m-d');
        $personas = DB::table('personas')->where('estado', '=', 'ACTIVO')->get();
        $subdependencias = DB::table('subdependencias')->where('estado', '=', 'ACTIVO')->get();
        //$persub = array_merge( $personas,  $subdependencias);
        $juicios = DB::table('tipos_juicios')->where('estado', '=', 'ACTIVO')->get();      
        $faltas = DB::table('tipofalta')->where('estado', '=', 'ACTIVO')->get();      
        $expedientes= DB::table('expedientes')->where('tipo','=','NULIDAD')->orwhere('tipo','=','RAG')->get();
        return view('expedientes.create', ['faltas'=>$faltas,'expedientes'=>$expedientes,'personas' => $personas,'juicios'=>$juicios,'date'=>$date]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=Auth::user();

        $tipo = $request->get('tipoIngreso');
        $year = date("Y");
        if ($tipo == "NULIDAD" || $tipo == "RAG" || $tipo== "GENERALIDAD") {  //CUANDO EL EXPEDIENTE ES DE NULIDAD O RAG O GENERALIDAD GENERA UNO NUEVO           
            $expediente = new ExpedientesModel;
            $expediente->tipo = $request->get('tipoIngreso');
            $expediente->fecha= $request->get('fecha');
            $expediente->observaciones= $request->get('observaciones');
            $expediente->id_juicio= $request->get('id_juicio');
            $expediente->captura=$user->name. " ".$user->apellido_p." ".$user->apellido_m;
            $expediente->estado="POR_ASIGNAR";
            $expediente->ubicacion="OFICIALIA_PARTES";
            //$expediente->estado_ubicacion="ASIGNADO";
            //$expediente->id_recibe=$user->id;

            $ultimo_ex = DB::table('expedientes')->where('tipo', '=', $tipo)->orderBy('num_expediente', 'desc')->first();

            if ($tipo == "NULIDAD" && $ultimo_ex == null) {
                $num_aux="0001";
                $p="I";                                
                $expediente->num_expediente = "TJA/0001/".$year."-I";
            } elseif($tipo == "RAG" && $ultimo_ex == null) {
                $num_aux="0001";
                $p="III";
                $expediente->num_expediente = "TJA-RAG/0001/".$year."-III";
                $expediente->id_falta= $request->get('tipo_falta');    
            }else if($tipo == "NULIDAD" ){
                $name = explode("/", $ultimo_ex->num_expediente);             
                $num=$name[1]+1;     
                //GENERA EL NUM DE EXPEDIENTE SIGUIENTE Y SI LE FANTAN 0 LO RELLENA
                $num_aux= str_pad($num, 4, "0", STR_PAD_LEFT);                  
                //VALIDA EL ULTIMO P Y LE ASIGNA EL SIGUIENTE
                $name2= explode("-", $name[2]);
                $p=$name2[1];
                if($p == "I"){
                 $p="II";   
                }elseif($p == "II"){
                    $p="I"; 
                }               
            $expediente->num_expediente = "TJA/".$num_aux."/".$year."-".$p;                    
            }else if($tipo == "RAG"){                
                $p="III";
                $name = explode("/", $ultimo_ex->num_expediente);             
                $num=$name[1]+1;     
                //GENERA EL NUM DE EXPEDIENTE SIGUIENTE Y SI LE FANTAN 0 LO RELLENA
                $num_aux= str_pad($num, 4, "0", STR_PAD_LEFT);
                $expediente->num_expediente = "TJA-RAG/".$num_aux."/".$year."-III";
                $expediente->id_falta= $request->get('tipo_falta');    

            }else if ($tipo== "GENERALIDAD") {
                if($ultimo_ex == null){
                    $num_aux="0001";
                }else{
                    $name = explode("/", $ultimo_ex->num_expediente);             
                    $num=$name[1]+1;     
                    //GENERA EL NUM DE EXPEDIENTE SIGUIENTE Y SI LE FANTAN 0 LO RELLENA
                    $num_aux= str_pad($num, 4, "0", STR_PAD_LEFT);                  
                }
                $p="00";
                $expediente->num_expediente = "TJA-GENERALIDAD/".$num_aux."/".$year."-00";  
                # code...
            }
                
            //ASIGNAMOS EL EXPEDIENTE A UNA SALA(PONENCIA)
            $expediente->save();   
            $historial= new HistorialExpedienteModel;
            $historial->id_expediente=$expediente->id;
            $historial->id_user_recibe=$user->id;
            $historial->estado="ASIGNADO";
            $historial->tipo_movimiento="RECEPCION";
            $historial->ubicacion="OFICIALIA_PARTES";
            $historial->captura=$user->name. " ".$user->apellido_p." ".$user->apellido_m;
            $historial->observaciones="SE RECIBE EXPEDIENTE EN OFICIALIA DE PARTES";
            $historial->save();

            DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","expedientes","'.$expediente->id.'","'.base64_encode(json_encode($expediente)).'"," ","El usuario creo un expediente")');  

            $id_sala=DB::table('salamagistrado')->where('num_sala','=',$p)->first();
            if($id_sala){
                $sala= new expedienteSalaModel ;  
                $sala->id_expediente=$expediente->id;
                $sala->id_sala=$id_sala->id;
                $sala->estado="PENDIENTE";
                $sala->save();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","expedientesala","'.$sala->id.'","'.base64_encode(json_encode($sala)).'"," ","El sistema asigino el expediente a la sala correspondiente, derivado del movimiento del usuario.")');    
        
            }
            
         
        //GUARDA LOS DETALLES Y ARCHIVOS DEL EXPEDIENTE    
        $DetalleExp = new DetalleExpedienteModel;
        $DetalleExp->id_expediente=$expediente->id;
        $DetalleExp->num_anexos=$request->get('hojas_anexo');
        $DetalleExp->hojas_escrito=$request->get('hojas_escrito');
        $DetalleExp->hojas_traslados=$request->get('hojas_traslado');

        if($request->hasFile('escaneo_escrito')){
           
            $file=$request->file('escaneo_escrito');
            $file->move('OFICIALIA/archivos/ingresos/',$file->getClientoriginalName());
           // print_r($file->getClientoriginalName());
            $DetalleExp->escaneo_escrito=$file->getClientoriginalName();
            $path_info = pathinfo($DetalleExp->escaneo_escrito);
           $extension = $path_info['extension']; // "bill"
           //print_r($tabla->archivo);
           $nombre="Escaneo-Escrito-TJA-".$expediente->tipo."-".$num_aux."-".$year."-".$p.".".$extension;          
           rename("OFICIALIA/archivos/ingresos/".$DetalleExp->escaneo_escrito, "OFICIALIA/archivos/ingresos/".$nombre);
           $DetalleExp->escaneo_escrito=$nombre;
           $DetalleExp->save();
        }

        //Realiza un for segun el numero de hojas de anexo
        for ($i=1; $i <= $DetalleExp->num_anexos ; $i++) {     
            $escaneoAnexos= new EscaneoAnexosModel;        
            $escaneoAnexos->id_expediente=$expediente->id;
            $escaneoAnexos->tipo=$request->get('select'.$i);           
            $escaneoAnexos->forma=$request->get('select2'.$i); 
            $escaneoAnexos->num_hojas=$request->get('input2'.$i);            
            $escaneoAnexos->num_anexo=$i;
            if($request->hasFile('input'.$i)){
                $file=$request->file('input'.$i);
                $file->move('OFICIALIA/archivos/ingresos/',$file->getClientoriginalName());
                $escaneoAnexos->escaneo_anexos=$file->getClientoriginalName();
                $path_info = pathinfo($escaneoAnexos->escaneo_anexos);
               $extension = $path_info['extension']; // "bill"
               //print_r($tabla->archivo);
               $nombre="Escaneo-TJA-ANEXO-N-".$i."-".$expediente->tipo."-".$num_aux."-".$year."-".$p.".".$extension;          
               rename("OFICIALIA/archivos/ingresos/".$escaneoAnexos->escaneo_anexos, "OFICIALIA/archivos/ingresos/".$nombre);
               $escaneoAnexos->escaneo_anexos=$nombre;
               $escaneoAnexos->save();
            } //endif                   
        }//end for
        
               
        //GUARDAR EL EXPEDIENTE-ACTOR
        $actores = $request->get('actor');
        if($actores){
        foreach ($actores as $actor) {            
            $ActorExpe= new ExpedienteActorModel;
            $ActorExpe->id_expediente=$expediente->id;
            $ActorExpe->id_actor=$actor;
            $ActorExpe->save();
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_actor","'.$ActorExpe->id.'","'.base64_encode(json_encode($ActorExpe)).'"," ","El usuario ha creado una nueva relación de actor con el expediente.")'); 

        }
    }
        
        //EXPEDIENTE- DEMANDADO
        $demandados = $request->get('demandado');
        if($demandados){
            foreach ($demandados as $demandado) {
                $DemandadoExpe= new ExpedienteDemandadoModel;
                $DemandadoExpe->id_expediente=$expediente->id;
                $DemandadoExpe->id_demandado=$demandado;
                $DemandadoExpe->save();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_demandado","'.$DemandadoExpe->id.'","'.base64_encode(json_encode($DemandadoExpe)).'"," ","El usuario ha creado una nueva relación de autoridad demandada con el expediente.")'); 

            }

        }


        //EXPEDIENTE-ABOGADO
        $abogados = $request->get('abogado');
        if($abogados){
            foreach ($abogados as $abogado) {
                $AbogadoExpe= new ExpedienteAbogadoModel;
                $AbogadoExpe->id_expediente=$expediente->id;
                $AbogadoExpe->id_abogado=$abogado;
                $AbogadoExpe->save();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_abogado","'.$AbogadoExpe->id.'","'.base64_encode(json_encode($AbogadoExpe)).'"," ","El usuario ha creado una nueva relación de abogados con el expediente.")');   

            }
        }
 

        //EXPEDIENTE-TERCERA PERSONA
        $terceros = $request->get('tercero');
        if($terceros){
            foreach ($terceros as $tercero) {
                $TerceroExpe= new ExpedienteTerceraModel;
                $TerceroExpe->id_expediente=$expediente->id;
                $TerceroExpe->id_tercera=$tercero;
                $TerceroExpe->save();    
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_tercera_persona","'.$TerceroExpe->id.'","'.base64_encode(json_encode($TerceroExpe)).'"," ","El usuario ha creado una nueva relación de terceras personas con el expediente.")');               
            
            }

        }

        //EXPEDIENTE-AUTORIDAD INV
                $autoridad_inv = $request->get('autoridad_inv');
                if($autoridad_inv){
                    foreach ($autoridad_inv as $autoridad_i) {
                        $autoridadInv= new expedienteAutoridadInv;
                        $autoridadInv->id_expediente=$expediente->id;
                        $autoridadInv->id_autoridadinv=$autoridad_i;
                        $autoridadInv->save();   
                         DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_autoridadinv","'.$autoridadInv->id.'","'.base64_encode(json_encode($autoridadInv)).'"," ","El usuario ha creado una nueva relación de la autoridad investigadora con el expediente.")');              
             
                    }
        
                }

          //EXPEDIENTE-AUTORIDAD SUST
                        $autoridad_sust = $request->get('autoridad_sust');
                        if($autoridad_sust){
                            foreach ($autoridad_sust as $autoridad_s) {
                                $autoridadSust= new expedienteAutoridadSust;
                                $autoridadSust->id_expediente=$expediente->id;
                                $autoridadSust->id_autoridadsust=$autoridad_s;
                                $autoridadSust->save();  
                                DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_autoridadsust","'.$autoridadSust->id.'","'.base64_encode(json_encode($autoridadSust)).'"," ","El usuario ha creado una nueva relación de la autoridad sustanciadora con el expediente.")');                      
              
                            }
                
                        }     
        
          //EXPEDIENTE-PRESUNTO RESP
          $presunto_resp = $request->get('presunto_resp');
          if($presunto_resp){
              foreach ($presunto_resp as $presunto_r) {
                  $PresuntoResponsable= new expedientePresuntoResp;
                  $PresuntoResponsable->id_expediente=$expediente->id;
                  $PresuntoResponsable->id_presuntoresp=$presunto_r;
                  $PresuntoResponsable->save();   
                  DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_presuntoresp","'.$PresuntoResponsable->id.'","'.base64_encode(json_encode($PresuntoResponsable)).'"," ","El usuario ha creado una nueva relación del presunto responsable con el expediente.")');                        
             
              }
  
          }
          
        //EXPEDIENTE-DENUNCIANTE
        $denunciante = $request->get('denunciante');
         if($denunciante){
            foreach ($denunciante as $denunc) {
                   $denunciante= new expedienteDenunciante;
                   $denunciante->id_expediente=$expediente->id;
                   $denunciante->id_deunciante=$denunc;
                   $denunciante->save();       
                   DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_deunciante","'.$denunciante->id.'","'.base64_encode(json_encode($denunciante)).'"," ","El usuario ha creado una nueva relación del denunciante con el expediente.")');                        
         
            }
          
         }
         
         //EXPEDIENTE-PARTICULAR
        $particular_vinculado = $request->get('particular');
        if($particular_vinculado){
           foreach ($particular_vinculado as $particular) {
                  $particularVinculado= new expedienteParticular;
                  $particularVinculado->id_expediente=$expediente->id;
                  $particularVinculado->id_particularvinc=$particular;
                  $particularVinculado->save();    
                  DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_particularvinc","'.$particularVinculado->id.'","'.base64_encode(json_encode($particularVinculado)).'"," ","El usuario ha creado una nueva relación del particular vinculado con el expediente.")');                           
           }
         
        }  

        if ($tipo == "NULIDAD" || $tipo == "RAG" ) { // CUANDO FUE NULIDAD O RAG LOS RETORNA A LA VISTA DEL DETALLE DEL EXPEDIENTE CREADO
           // $amparos=[];
          //  $acuerdos=[];
            //return Redirect::route('expedientes.show, $expediente->$id')->with( ['expediente' => $expediente] );
           // return view('expedientes.detalle')->with('errors', 'guardado correctamente!');
         //  $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$expediente->id)->get();
          // $expediente_sala=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')->where('expedientesala.id','=',$sala->id)->where('personalsala.funcion','=','MAGISTRADO')->select('salamagistrado.num_sala','users.*')->first();
           
           return Redirect::to('ver_expediente/'.$expediente->id)->with('errors', 'Expediente guardado correctamente');
         //  return view('expedientes.detalle', ['acuerdos'=>$acuerdos,'expediente_sala'=>$expediente_sala,'expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'amparos'=>$amparos,'escaneos'=>$escaneos])->with('errors', 'Expediente guardado correctamente ,Nº Expediente asignado:'.$expediente->num_expediente);
           
        }else{// SI NO LO MANDA A LA VISTA DE LA NULIDAD
        //    $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$expediente->id)->get();
            // return view('generalidades.detalle', ['expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'escaneos'=>$escaneos])->with('errors', 'Expediente guardado correctamente ,Nº Expediente asignado:'.$expediente->num_expediente);
             return Redirect::to('ver_generalidades/'.$expediente->id)->with('errors', 'Generalidad guardada correctamente');
        }
       

        }else{//if el tipo es amparo o promocion

            //VALIDA SI ES AMPARO Y ASIGNA EL NUMERO DE FOLIO
            if($tipo== "AMPARO"){
                $folio=DB::table('amparos_promociones')->where('tipo','=','AMPARO')->orderBy('folio','desc')->first();
            }elseif($tipo == "PROMOCION"){
                $folio=DB::table('amparos_promociones')->where('tipo','=','PROMOCION')->orderBy('folio','desc')->first();

            }
            //SI EL NUMERO DE FOLIO ES VACIO LE ASIGNA EL 1, SI NO LE SUMA 1
            if($folio == null){
                $folio="0001";             

            }else{                                
                $folio= str_pad($folio->folio+1, 4, "0", STR_PAD_LEFT);   
            }
                $amparo = new AmparosPromocionesModel;
                $amparo->tipo=$tipo;
                $amparo->id_expediente=$request->get('expediente');
                $amparo->num_anexos=$request->get('hojas_anexo');
                $amparo->hojas_escrito=$request->get('hojas_escrito');             
                $amparo->fecha=$request->get('fecha');
                $amparo->estado="ACTIVO";
                $amparo->folio=$folio;
                $amparo->ubicacion="OFICIALIA_PARTES";
                $amparo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
                if($request->hasFile('escaneo_escrito')){
                    $file=$request->file('escaneo_escrito');
                    $file->move('OFICIALIA/archivos/amparos_promociones/',$file->getClientoriginalName());
                    $amparo->escaneo_escrito=$file->getClientoriginalName();
                    $path_info = pathinfo($amparo->escaneo_escrito);
                   $extension = $path_info['extension']; // "bill"
                   $nombre="Escaneo-Escrito-".$tipo."-".$amparo->id_expediente."-".$year.".".$extension;          
                   rename("OFICIALIA/archivos/amparos_promociones/".$amparo->escaneo_escrito, "OFICIALIA/archivos/amparos_promociones/".$nombre);
                   $amparo->escaneo_escrito=$nombre;
                }
                $amparo->save();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","amparos_promociones","'.$amparo->id.'"," "," ","El usuario genero una promocion")');    
                
                //Realiza un for segun el numero de hojas de anexo
        for ($i=1; $i <= $amparo->num_anexos ; $i++) {     
            $escaneo_amparo= new EscaneoAnexosAmparosModel;        
            $escaneo_amparo->id_amparo=$amparo->id;
            $escaneo_amparo->tipo=$request->get('select'.$i);           
            $escaneo_amparo->forma=$request->get('select2'.$i);
            $escaneo_amparo->num_hojas=$request->get('input2'.$i);
            
            $escaneo_amparo->num_anexo=$i;
            if($request->hasFile('input'.$i)){
                $file=$request->file('input'.$i);
                $file->move('OFICIALIA/archivos/amparos_promociones/',$file->getClientoriginalName());
                $escaneo_amparo->escaneo_anexos=$file->getClientoriginalName();
                $path_info = pathinfo($escaneo_amparo->escaneo_anexos);
               $extension = $path_info['extension']; // "bill"
               //print_r($tabla->archivo);
               $nombre="Escaneo-Anexo-N".$i."-".$tipo."-".$amparo->id_expediente."-".$year.".".$extension;          
               rename("OFICIALIA/archivos/amparos_promociones/".$escaneo_amparo->escaneo_anexos, "OFICIALIA/archivos/amparos_promociones/".$nombre);
               $escaneo_amparo->escaneo_anexos=$nombre;
               $escaneo_amparo->save();
            }                        
        }//end for          
        //manda el detalle expediente con todos los datos                         
                $escaneos=DB::table('escaneo_anexos_amparos')->where('id_amparo','=',$amparo->id)->get();
               // $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')->select('expedientes.*','detalle_expediente.num_anexos','detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.escaneo_escrito')->where('expedientes.id','=',$amparo->id_expediente)->first();
                $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->where('expedientes.id','=',$amparo->id_expediente)->select('expedientes.*','detalle_expediente.escaneo_escrito','detalle_expediente.num_anexos',
        'detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.created_at as created_detalle')->first();
         $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$amparo->id_expediente)->get();
          $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
        ->where('acuerdosgenarados.id_expediente','=',$amparo->id_expediente)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
        
                return view('amparos.detalle', ['acuerdos'=>$acuerdos,'expediente'=>$expediente,'amparo'=>$amparo,'escaneos'=>$escaneos,'amparos'=>$amparos])->with('errors', 'Expediente guardado correctamente ,Nº Expediente asignado:'.$expediente->num_expediente);
               


         
          
        }//end if            
    }//end function



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->join('tipos_juicios','tipos_juicios.id','=','expedientes.id_juicio')
        ->where('expedientes.id','=',$id)->select('expedientes.*','detalle_expediente.escaneo_escrito','detalle_expediente.num_anexos',
        'detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.created_at as created_detalle','tipos_juicios.tipo as tipo_juicio')->first();


        $DetalleExp=DB::table('detalle_expediente')->where('id_expediente','=',$id)->first();
        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$id)->get();
        $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$id)->get();
        $expediente_sala=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('personalsala.funcion','=','MAGISTRADO')
        ->where('expedientesala.id_expediente','=',$id)->select('salamagistrado.num_sala','users.*')->first();

        $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
        ->where('acuerdosgenarados.id_expediente','=',$id)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();


     
        return view('expedientes.detalle', ['acuerdos'=>$acuerdos,'expediente_sala'=>$expediente_sala,'expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'amparos'=>$amparos,'escaneos'=>$escaneos]);

        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {       $user=Auth::user();
        $tipo_usuario = Auth::user()->funcion;
        $funcion=DB::table('personalsala')->join('users','users.id','=','personalsala.id_user')
        ->where('users.id','=',$user->id)
        ->select('personalsala.funcion')->first();
       
        if($user->funcion == "OFICIALIA PARTES" || $user->funcion == "ADMINISTRADOR"){
            
            

            $personas = DB::table('personas')->where('estado', '=', 'ACTIVO')->get(); 
            $faltas = DB::table('tipofalta')->where('estado', '=', 'ACTIVO')->get();   
            $juicios = DB::table('tipos_juicios')->where('estado', '=', 'ACTIVO')->get();
            $expediente= ExpedientesModel::findOrFail($id);
            $DetalleExp=DB::table('detalle_expediente')->where('id_expediente','=',$id)->first();
            $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$id)->get();
            $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$id)->get();
            $expedientes= DB::table('expedientes')->where('tipo','=','NULIDAD')->orwhere('tipo','=','RAG')->get();
            $options=['SELECCIONE UNA OPCIÓN', 'ACTA DE NACIMIENTO', 'CURP', 'IFE', 'PASAPORTE MEXICANO', 'CÉDULA PROFESIONAL', 'TITULO PROFESIONAL', 'CARTILLA DEL SERVICIO MILITAR', 'INAPAM', 'CREDENCIAL IMSS', 'CREDENCIAL ISSSTE', 'LICENCIA DE CONDUCIR', 'CARTA DE NATURALIZACIÓN'];
            $options2=['SELECCIONE UNA OPCIÓN', 'ORIGINAL', 'COPIA CERTIFICADA', 'COPIA SIMPLE'];
    
    
            return view('expedientes.edit', ['expedientes'=>$expedientes,'faltas'=>$faltas,'personas'=>$personas,'options2'=>$options2,'options'=>$options,'expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'amparos'=>$amparos,'escaneos'=>$escaneos,'juicios'=>$juicios]);
        
  /*       }else if($funcion == "COORDINADOR" || $funcion->funcion == "MAGISTRADO" ) {
            
            $actores = DB::table('actor')->where('estado', '=', 'ACTIVO')->get();

            $actores_aux=DB::table('expedientes')->join('expediente_actor','expediente_actor.id_expediente','=','expedientes.id')->join('actor',
            'actor.id','=','expediente_actor.id_actor')->select('actor.*')->where('expedientes.id','=',$id)->get();
            $juicios = DB::table('tipos_juicios')->where('estado', '=', 'ACTIVO')->get();
            $demandados = DB::table('demandado')->where('estado', '=', 'ACTIVO')->get();
            $terceros = DB::table('tercera_persona')->where('estado', '=', 'ACTIVO')->get();
            $abogados = DB::table('abogado')->where('estado', '=', 'ACTIVO')->get();
            $expediente= ExpedientesModel::findOrFail($id);
            $DetalleExp=DB::table('detalle_expediente')->where('id_expediente','=',$id)->first();
            $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$id)->get();
            $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$id)->get();
            $options=['SELECCIONE UNA OPCIÓN', 'ACTA DE NACIMIENTO', 'CURP', 'IFE', 'PASAPORTE MEXICANO', 'CÉDULA PROFESIONAL', 'TITULO PROFESIONAL', 'CARTILLA DEL SERVICIO MILITAR', 'INAPAM', 'CREDENCIAL IMSS', 'CREDENCIAL ISSSTE', 'LICENCIA DE CONDUCIR', 'CARTA DE NATURALIZACIÓN'];
            $options2=['SELECCIONE UNA OPCIÓN', 'ORIGINAL', 'COPIA CERTIFICADA', 'COPIA SIMPLE'];
    
    
            return view('expedientes.edit', ['options2'=>$options2,'options'=>$options,'expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'amparos'=>$amparos,'escaneos'=>$escaneos,
                            'actores'=>$actores,'demandados'=>$demandados,'terceros'=>$terceros,'abogados'=>$abogados,'juicios'=>$juicios]);
         */
        }else{
            return view('errors.permisos');
        }
            


        } //
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    

        $year = date("Y");
        $user=Auth::user();
        $expediente= ExpedientesModel::findOrFail($id);
        $tipo=$request->get('tipoIngreso');
        
        $ultimo_ex = DB::table('expedientes')->where('tipo', '=', $tipo)->where('estado', '=', 'ACTIVO')->orderBy('num_expediente', 'desc')->first();
        if($expediente->tipo =="GENERALIDAD" && $tipo == "RAG" || $tipo == "NULIDAD"){//SI EL EXPEDIENTE ERA GENERALIDAD Y SE CAMBIO A NULIDAD O RAG SE DEBE DE ASIGNAR A UNA SALA            
            if ($tipo == "NULIDAD" && $ultimo_ex == null) {
                $num_aux="0001";
                $p="I";                                
                $expediente->num_expediente = "TJA/0001/".$year."-I";
            } elseif($tipo == "RAG" && $ultimo_ex == null) {
                $num_aux="0001";
                $p="III";
                $expediente->num_expediente = "TJA-RAG/0001/".$year."-III";
            }else if($tipo == "NULIDAD" ){
                $name = explode("/", $ultimo_ex->num_expediente);             
                $num=$name[1]+1;     
                //GENERA EL NUM DE EXPEDIENTE SIGUIENTE Y SI LE FANTAN 0 LO RELLENA
                $num_aux= str_pad($num, 4, "0", STR_PAD_LEFT);                  
                //VALIDA EL ULTIMO P Y LE ASIGNA EL SIGUIENTE
                $name2= explode("-", $name[2]);
                $p=$name2[1];
                if($p == "I"){
                 $p="II";   
                }elseif($p == "II"){
                    $p="I"; 
                }             
            $expediente->num_expediente = "TJA/".$num_aux."/".$year."-".$p;                    
            }else if($tipo == "RAG"){

                $p="III";
                $name = explode("/", $ultimo_ex->num_expediente);             
                $num=$name[1]+1;     
                //GENERA EL NUM DE EXPEDIENTE SIGUIENTE Y SI LE FANTAN 0 LO RELLENA
                $num_aux= str_pad($num, 4, "0", STR_PAD_LEFT);
                $expediente->num_expediente = "TJA-RAG/".$num_aux."/".$year."-III";   
                $expediente->id_falta= $request->get('tipo_falta');     

            }

            $id_sala=DB::table('salamagistrado')->where('num_sala','=',$p)->first();
            if($id_sala){
                $sala= new expedienteSalaModel ;  
                $sala->id_expediente=$expediente->id;
                $sala->id_sala=$id_sala->id;
                $sala->estado="PENDIENTE";
                $sala->save();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expedientesala","'.$sala->id.'","'.base64_encode(json_encode($sala)).'"," ","El usuario ha creado una nueva relación de sala con el expediente.")');   
            }

        }elseif($expediente->tipo =="NULIDAD" || $expediente->tipo =="RAG"  && $tipo == "GENERALIDAD"){//SI EL EXPEDIENTE ERA NULIDAD O RAG Y SE CAMBIO A GENERALIDAD SE DEBE DE BORRAR LA ASIGNACION A LA SALA Y ASIGNAR OTRO NOMBRE DE EXPEDIENTE          
            if($ultimo_ex == null){
                $num_aux="0001";
            }else{
                $name = explode("/", $ultimo_ex->num_expediente);             
                $num=$name[1]+1;     
                //GENERA EL NUM DE EXPEDIENTE SIGUIENTE Y SI LE FANTAN 0 LO RELLENA
                $num_aux= str_pad($num, 4, "0", STR_PAD_LEFT);                  
            }
            $p="00";
            $expediente->num_expediente = "TJA-GENERALIDAD/".$num_aux."/".$year."-00";   //CAMBIA EL NUM DE EXPEDIENTE

            $_sala=DB::table('expedientesala')->where('id_expediente','=',$id)->get();
            foreach ($_sala as $value) {
            $_deleteSala=expedienteSalaModel::findOrFail($value->id); 
            $_deleteSala->delete(); //ELIMINAMOS LOS EXPEDIENTES ASIGNADOS A LA SALA, YA QUE CAMBIO A GENERALIDAD
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expedientesala","'.$_deleteSala->id.'"," "," ","El usuario elimino el expediente asignado a una sala")');    
            }

        }      
        $expediente->tipo = $request->get('tipoIngreso');
        $expediente->fecha=   $request->get('fecha');
        $expediente->id_juicio= $request->get('id_juicio');
        $expediente->observaciones= $request->get('observaciones');
        $expediente->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
        $expediente->ubicacion="OFICIALIA_PARTES";
        $expediente->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","expedientes","'.$expediente->id.'"," "," ","El usuario edito el expediente")'); 

        
        $idExp=DB::table('detalle_expediente')->where('id_expediente','=',$id)->first()->id;
        $DetalleExp=DetalleExpedienteModel::findOrFail($idExp);  
        $DetalleExp->id_expediente=$expediente->id;
        $DetalleExp->num_anexos=$request->get('hojas_anexo');
        $DetalleExp->hojas_escrito=$request->get('hojas_escrito');
        $DetalleExp->hojas_traslados=$request->get('hojas_traslado');

        if($request->hasFile('escaneo_escrito')){
            $file=$request->file('escaneo_escrito');
            $file->move('OFICIALIA/archivos/ingresos/',$file->getClientoriginalName());        
           rename("OFICIALIA/archivos/ingresos/".$file->getClientoriginalName(), "OFICIALIA/archivos/ingresos/".$DetalleExp->escaneo_escrito);
           //$DetalleExp->escaneo_escrito=$nombre;
        }
        $DetalleExp->update();


        if($request->hasFile('input1')){//VALIDA SI SE CAMBIO EL ARCHIVO 
                    //ELIMINA LOS ANEXOS ACTUALES DEL EXPEDIENTE PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('escaneo_anexos')->where('id_expediente','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=EscaneoAnexosModel::findOrFail($value->id); 
        $_Delete->delete();
        }
                //Realiza un for segun el numero de hojas de anexo
                for ($i=1; $i <= $DetalleExp->num_anexos ; $i++) {     
                    $escaneoAnexos= new EscaneoAnexosModel;        
                    $escaneoAnexos->id_expediente=$expediente->id;
                    $escaneoAnexos->tipo=$request->get('select'.$i);           
                    $escaneoAnexos->forma=$request->get('select2'.$i);            
                    $escaneoAnexos->num_anexo=$i;
                    $escaneoAnexos->num_hojas=$request->get('input2'.$i);
                    if($request->hasFile('input'.$i)){
                        $file=$request->file('input'.$i);
                        $file->move('OFICIALIA/archivos/ingresos/',$file->getClientoriginalName());
                        $escaneoAnexos->escaneo_anexos=$file->getClientoriginalName();
                        $path_info = pathinfo($escaneoAnexos->escaneo_anexos);
                       $extension = $path_info['extension']; // "bill"

                       $name = explode("/",$expediente->num_expediente);//OBTENEMOS EL NUMERO DE EXP Y LO SEPARAMOS POR / PARA OBTENER SUS DATOS                    
                       $nombre="Escaneo-TJA-ANEXO-N-".$i."-".$expediente->tipo."-".$name[1]."-".$name[2].".".$extension;          
                       rename("OFICIALIA/archivos/ingresos/".$escaneoAnexos->escaneo_anexos, "OFICIALIA/archivos/ingresos/".$nombre);
                       $escaneoAnexos->escaneo_anexos=$nombre;
                       $escaneoAnexos->save();
                    } //endif                   
                }//end for
            }//END IF

        //ELIMINA LOS ACTORES ACTUALES DEL EXPEDIENTE PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('expediente_actor')->where('id_expediente','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=ExpedienteActorModel::findOrFail($value->id); 
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_actor","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación de actor con el expediente.")'); 
        $_Delete->delete();
        }
        
          //GUARDAR EL EXPEDIENTE-ACTOR
          $actores = $request->get('actor_aux');
          if($actores){
            foreach ($actores as $actor) {                      
                $ActorExpe= new ExpedienteActorModel;
                $ActorExpe->id_expediente=$expediente->id;
                $ActorExpe->id_actor=$actor;
                $ActorExpe->save();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_actor","'.$ActorExpe->id.'","'.base64_encode(json_encode($ActorExpe)).'"," ","El usuario ha creado una nueva relación de actor con el expediente.")'); 
            }

          }         
        

         //ELIMINA LOS ACTORES DEMANDADO DEL EXPEDIENTE PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('expediente_demandado')->where('id_expediente','=',$id)->get();
        if($_aux){
            foreach ($_aux as $value) {
                $_Delete=ExpedienteDemandadoModel::findOrFail($value->id); 
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_demandado","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación de autoridad demandada con el expediente.")'); 
                $_Delete->delete();                
                }          

        }
    
          //EXPEDIENTE- DEMANDADO
          $demandados = $request->get('demandados_aux');
          if($demandados){
              foreach ($demandados as $demandado) {
                  $DemandadoExpe= new ExpedienteDemandadoModel;
                  $DemandadoExpe->id_expediente=$expediente->id;
                  $DemandadoExpe->id_demandado=$demandado;
                  $DemandadoExpe->save();
                  DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_demandado","'.$DemandadoExpe->id.'","'.base64_encode(json_encode($DemandadoExpe)).'"," ","El usuario ha creado una nueva relación de autoridad demandada con el expediente.")'); 
              }
  
          }

        //ELIMINA LOS ABOGADOS DEMANDADO DEL EXPEDIENTE PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('expediente_abogado')->where('id_expediente','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=ExpedienteAbogadoModel::findOrFail($value->id); 
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_abogado","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación de abogados con el expediente.")'); 
        $_Delete->delete();
        }   

          //EXPEDIENTE-ABOGADO
          $abogados = $request->get('abogados_aux');
          if($abogados){
              foreach ($abogados as $abogado) {
                  $AbogadoExpe= new ExpedienteAbogadoModel;
                  $AbogadoExpe->id_expediente=$expediente->id;
                  $AbogadoExpe->id_abogado=$abogado;
                  $AbogadoExpe->save();
                  DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_abogado","'.$AbogadoExpe->id.'","'.base64_encode(json_encode($AbogadoExpe)).'"," ","El usuario ha creado una nueva relación de abogados con el expediente.")');   
              }
          }
   
  
        //ELIMINA LOS TERCEROS DEL EXPEDIENTE PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('expediente_tercera_persona')->where('id_expediente','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=ExpedienteTerceraModel::findOrFail($value->id); 
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_tercera_persona","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación de las terceras personas con el expediente.")'); 
        $_Delete->delete();
        }   

          //EXPEDIENTE-TERCERA PERSONA
          $terceros = $request->get('terceros_aux');
          if($terceros){
              foreach ($terceros as $tercero) {
                  $TerceroExpe= new ExpedienteTerceraModel;
                  $TerceroExpe->id_expediente=$expediente->id;
                  $TerceroExpe->id_tercera=$tercero;
                  $TerceroExpe->save();  
                  DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_tercera_persona","'.$TerceroExpe->id.'","'.base64_encode(json_encode($TerceroExpe)).'"," ","El usuario ha creado una nueva relación de terceras personas con el expediente.")');               
              }
  
          }

           //ELIMINA LOS EXPEDIENTE-AUTORIDAD INV DEL EXPEDIENTE PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('expediente_autoridadinv')->where('id_expediente','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=expedienteAutoridadInv::findOrFail($value->id);
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_autoridadinv","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación de la autoridad investigadora con el expediente.")'); 
        $_Delete->delete();
        }   


          //EXPEDIENTE-AUTORIDAD INV
          $autoridad_inv = $request->get('autoridad_inv_aux');
          if($autoridad_inv){
              foreach ($autoridad_inv as $autoridad_i) {
                  $autoridadInv= new expedienteAutoridadInv;
                  $autoridadInv->id_expediente=$expediente->id;
                  $autoridadInv->id_autoridadinv=$autoridad_i;
                  $autoridadInv->save();    
                  DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_autoridadinv","'.$autoridadInv->id.'","'.base64_encode(json_encode($autoridadInv)).'"," ","El usuario ha creado una nueva relación de la autoridad investigadora con el expediente.")');              
              }
  
          }

                     //ELIMINA LOS EXPEDIENTE-AUTORIDAD SUST PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('expediente_autoridadsust')->where('id_expediente','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=expedienteAutoridadSust::findOrFail($value->id); 
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_autoridadsust","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación de la autoridad sustanciadora con el expediente.")');
        $_Delete->delete();
        }   


    //EXPEDIENTE-AUTORIDAD SUST
                  $autoridad_sust = $request->get('autoridad_sust_aux');
                  if($autoridad_sust){
                      foreach ($autoridad_sust as $autoridad_s) {
                          $autoridadSust= new expedienteAutoridadSust;
                          $autoridadSust->id_expediente=$expediente->id;
                          $autoridadSust->id_autoridadsust=$autoridad_s;
                          $autoridadSust->save(); 
                          DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_autoridadsust","'.$autoridadSust->id.'","'.base64_encode(json_encode($autoridadSust)).'"," ","El usuario ha creado una nueva relación de la autoridad sustanciadora con el expediente.")');                      
                      }
          
                  }     
  
                    //ELIMINA LOS EXPEDIENTE-AUTORIDAD SUST PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('expediente_presuntoresp')->where('id_expediente','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=expedientePresuntoResp::findOrFail($value->id); 
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_presuntoresp","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación del presunto responsable con el expediente.")');
        $_Delete->delete();
        }   


    //EXPEDIENTE-PRESUNTO RESP
    $presunto_resp = $request->get('presunto_resp_aux');
    if($presunto_resp){
        foreach ($presunto_resp as $presunto_r) {
            $PresuntoResponsable= new expedientePresuntoResp;
            $PresuntoResponsable->id_expediente=$expediente->id;
            $PresuntoResponsable->id_presuntoresp=$presunto_r;
            $PresuntoResponsable->save();  
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_presuntoresp","'.$PresuntoResponsable->id.'","'.base64_encode(json_encode($PresuntoResponsable)).'"," ","El usuario ha creado una nueva relación del presunto responsable con el expediente.")');                        
        }

    }


        //ELIMINA LOS EXPEDIENTE-DENUNCIANTE PARA ASIGNAR LOS NUEVOS
          $_aux=DB::table('expediente_deunciante')->where('id_expediente','=',$id)->get();
         foreach ($_aux as $value) {
        $_Delete=expedienteDenunciante::findOrFail($value->id); 
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_deunciante","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación del denunciante con el expediente.")');      
         $_Delete->delete();
  }   
            
    
    
  //EXPEDIENTE-DENUNCIANTE
  $denunciante = $request->get('denunciante_aux');
   if($denunciante){
      foreach ($denunciante as $denunc) {
             $denunciante= new expedienteDenunciante;
             $denunciante->id_expediente=$expediente->id;
             $denunciante->id_deunciante=$denunc;
             $denunciante->save();       
             DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_deunciante","'.$denunciante->id.'","'.base64_encode(json_encode($denunciante)).'"," ","El usuario ha creado una nueva relación del denunciante con el expediente.")');                        
      }
    
   }
   
           //ELIMINA LOS EXPEDIENTE-PARTICULAR PARA ASIGNAR LOS NUEVOS
           $_aux=DB::table('expediente_particularvinc')->where('id_expediente','=',$id)->get();
           foreach ($_aux as $value) {
          $_Delete=expedienteParticular::findOrFail($value->id); 
          DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expediente_particularvinc","'.$_Delete->id.'","'.base64_encode(json_encode($_Delete)).'"," ","El usuario ha eliminado la relación del particular vinculado con el expediente.")');      
           $_Delete->delete();
    }   

   //EXPEDIENTE-PARTICULAR
  $particular_vinculado = $request->get('particular_aux');
  if($particular_vinculado){
     foreach ($particular_vinculado as $particular) {
            $particularVinculado= new expedienteParticular;
            $particularVinculado->id_expediente=$expediente->id;
            $particularVinculado->id_particularvinc=$particular;
            $particularVinculado->save();   
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","expediente_particularvinc","'.$particularVinculado->id.'","'.base64_encode(json_encode($particularVinculado)).'"," ","El usuario ha creado una nueva relación del particular vinculado con el expediente.")');               
     }
   
  }  
  
          $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
          ->where('acuerdosgenarados.id_expediente','=',$id)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
          
          if ($tipo == "NULIDAD" || $tipo == "RAG" ) { // CUANDO FUE NULIDAD O RAG LOS RETORNA A LA VISTA DEL DETALLE DEL EXPEDIENTE CREADO
            $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$expediente->id)->get();
            //return Redirect::route('expedientes.show, $expediente->$id')->with( ['expediente' => $expediente] );
           // return view('expedientes.detalle')->with('errors', 'guardado correctamente!'); 
           $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$expediente->id)->get();
          $expediente_sala=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')->where('expedientesala.id_expediente','=',$expediente->id)->where('personalsala.funcion','=','MAGISTRADO')->select('salamagistrado.num_sala','users.*')->first();
           return view('expedientes.detalle', ['expediente_sala'=>$expediente_sala,'acuerdos'=>$acuerdos,'expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'amparos'=>$amparos,'escaneos'=>$escaneos])->with('errors', 'Nº Expediente asignado:'.$expediente->num_expediente)->with('errors','Registro actualizado correctamente');
            
           
        }else{// SI NO LO MANDA A LA VISTA DE LA NULIDAD
            $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$expediente->id)->get();
             return view('generalidades.detalle', ['acuerdos'=>$acuerdos,'expediente'=>$expediente,'DetalleExp'=>$DetalleExp,'escaneos'=>$escaneos])->with('errors', 'Nº Expediente asignado:'.$expediente->num_expediente);
            
        }  

     //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=Auth::user();
        $expediente= ExpedientesModel::findOrFail($id);
        $expediente->estado="INACTIVO";
        $expediente->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","expedientes","'.$expediente->id.'"," "," ","El usuario elimino el expediente")'); 
        $expediente->update();
        //
    }

    public function traer_expediente(Request $request,$id_expediente){
        if ($request->ajax()) {        
        $datos=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->join('tipos_juicios','tipos_juicios.id','=','expedientes.id_juicio')
        ->select('expedientes.*','tipos_juicios.tipo as tipo_juicio')->where('expedientes.id','=',$id_expediente)->get();

        $juicios=DB::table('expedientes')->join('tipos_juicios','tipos_juicios.id','=','expedientes.id_juicio')->select('tipos_juicios.*')->where('expedientes.id','=',$id_expediente)->get();
        $actores=DB::table('expedientes')->join('expediente_actor','expediente_actor.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_actor.id_actor')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();
        $demandados=DB::table('expedientes')->join('expediente_demandado','expediente_demandado.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_demandado.id_demandado')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();
        $abogados=DB::table('expedientes')->join('expediente_abogado','expediente_abogado.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_abogado.id_abogado')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();
        $terceras=DB::table('expedientes')->join('expediente_tercera_persona','expediente_tercera_persona.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_tercera_persona.id_tercera')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();

        $autoridad_inv=DB::table('expedientes')->join('expediente_autoridadinv','expediente_autoridadinv.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_autoridadinv.id_autoridadinv')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();
        $autoridad_sust=DB::table('expedientes')->join('expediente_autoridadsust','expediente_autoridadsust.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_autoridadsust.id_autoridadsust')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();
        $denunciante=DB::table('expedientes')->join('expediente_deunciante','expediente_deunciante.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_deunciante.id_deunciante')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();
        $particular_vinc=DB::table('expedientes')->join('expediente_particularvinc','expediente_particularvinc.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_particularvinc.id_particularvinc')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();
        $presunto_resp=DB::table('expedientes')->join('expediente_presuntoresp','expediente_presuntoresp.id_expediente','=','expedientes.id')->join('personas',
        'personas.id','=','expediente_presuntoresp.id_presuntoresp')->select('personas.*')->where('expedientes.id','=',$id_expediente)->get();

        $tipo_falta=DB::table('expedientes')
        ->join('tipofalta','tipofalta.id','=','expedientes.id_falta')
        ->select('tipofalta.tipo_falta')->where('expedientes.id','=',$id_expediente)->first();

        return response()->json(['tipo_falta'=>$tipo_falta,'datos'=>$datos,'actores'=>$actores,'demandados'=>$demandados,'abogados'=>$abogados,'terceras'=>$terceras,'juicios'=>$juicios,'autoridad_inv'=>$autoridad_inv,
        'autoridad_sust'=>$autoridad_sust,'denunciante'=>$denunciante,'particular_vinc'=>$particular_vinc,'presunto_resp'=>$presunto_resp]);

    }}

    public function invoice($id){       
        $id = Crypt::decrypt($id); 
        setlocale(LC_ALL, 'es_ES');
        $date = date('Y-m-d');
        $fecha = strftime("%A %d de %B del %Y", strtotime($date));
        $datos=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')->select('expedientes.*','detalle_expediente.num_anexos','detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados')->where('expedientes.id','=',$id)->first();
        $actores=DB::table('expedientes')->join('expediente_actor','expediente_actor.id_expediente','=','expedientes.id')->join('actor',
        'actor.id','=','expediente_actor.id_actor')->select('actor.*')->where('expedientes.id','=',$id)->get();
        $demandados=DB::table('expedientes')->join('expediente_demandado','expediente_demandado.id_expediente','=','expedientes.id')->join('demandado',
        'demandado.id','=','expediente_demandado.id_demandado')->select('demandado.*')->where('expedientes.id','=',$id)->get();
        $abogados=DB::table('expedientes')->join('expediente_abogado','expediente_abogado.id_expediente','=','expedientes.id')->join('abogado',
        'abogado.id','=','expediente_abogado.id_abogado')->select('abogado.*')->where('expedientes.id','=',$id)->get();
        $terceras=DB::table('expedientes')->join('expediente_tercera_persona','expediente_tercera_persona.id_expediente','=','expedientes.id')->join('tercera_persona',
        'tercera_persona.id','=','expediente_tercera_persona.id_tercera')->select('tercera_persona.*')->where('expedientes.id','=',$id)->get();
        
        //mcrypt_encrypt($algorithm, $key, $cleartext, $mode, $iv)
        $num_exp= Crypt::encrypt($datos->num_expediente);
       // $num_exp = Crypt::decrypt($num_exp); 

     $invoice = "2222";
     //print_r($);
     $view =  \View::make('expedientes.invoice', compact('fecha','datos','actores','demandados','abogados','terceras','num_exp'))->render();
     //->setPaper($customPaper, 'landscape');
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($view);
     return $pdf->stream('ACUSE '.$datos->num_expediente.'pdf');


    }

    public function traerHistorialExpediente(Request $request,$id_expediente){
        if ($request->ajax()) {    
        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$id_expediente)->get(); 
        $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
        ->where('acuerdosgenarados.id_expediente','<>',$id_expediente)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
        $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->where('expedientes.id','=',$id_expediente)->select('expedientes.*','detalle_expediente.escaneo_escrito')->get();
        $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$id_expediente)->get();

        return response()->json(['amparos'=>$amparos,'acuerdos'=>$acuerdos,'expediente'=>$expediente,'escaneos'=>$escaneos]);




    }
}

public function portada($id){    
    $user=Auth::user();
    DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","expedientes","'.$id.'"," "," ","El usuario genero la portada de el expediente")'); 
    setlocale(LC_ALL, 'es_ES');
    $date = date('Y-m-d');
    $fecha = strftime("%A %d de %B del %Y", strtotime($date));
    $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
    ->where('expedientes.id','=',$id)->select('expedientes.*','detalle_expediente.escaneo_escrito','detalle_expediente.num_anexos',
    'detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.created_at as created_detalle')->first();
    $juicios = DB::table('tipos_juicios')->where('estado', '=', 'ACTIVO')->get();
    $DetalleExp=DB::table('detalle_expediente')->where('id_expediente','=',$id)->first();
    $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$id)->get();
    $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$id)->get();
    $expediente_sala=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
    ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
    ->where('personalsala.funcion','=','MAGISTRADO')
    ->where('expedientesala.id_expediente','=',$id)->select('salamagistrado.num_sala','users.*')->first();
    $actor=DB::table('expedientes')->join('expediente_actor','expediente_actor.id_expediente','=','expedientes.id')->join('personas',
    'personas.id','=','expediente_actor.id_actor')->select('personas.*')->where('expedientes.id','=',$id)->take(5)->get();
    $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
    ->where('acuerdosgenarados.id_expediente','=',$id)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();
    $demandados=DB::table('expedientes')->join('expediente_demandado','expediente_demandado.id_expediente','=','expedientes.id')->join('personas',
    'personas.id','=','expediente_demandado.id_demandado')->select('personas.*')->where('expedientes.id','=',$id)->take(5)->get();
    $datos=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')->select('expedientes.*','detalle_expediente.num_anexos','detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados')->where('expedientes.id','=',$id)->first();
   
    $autoridad_inv=DB::table('expedientes')->join('expediente_autoridadinv','expediente_autoridadinv.id_expediente','=','expedientes.id')->join('personas',
    'personas.id','=','expediente_autoridadinv.id_autoridadinv')->select('personas.*')->where('expedientes.id','=',$id)->take(5)->get();
    $autoridad_sust=DB::table('expedientes')->join('expediente_autoridadsust','expediente_autoridadsust.id_expediente','=','expedientes.id')->join('personas',
    'personas.id','=','expediente_autoridadsust.id_autoridadsust')->select('personas.*')->where('expedientes.id','=',$id)->take(5)->get();
    $denunciante=DB::table('expedientes')->join('expediente_deunciante','expediente_deunciante.id_expediente','=','expedientes.id')->join('personas',
    'personas.id','=','expediente_deunciante.id_deunciante')->select('personas.*')->where('expedientes.id','=',$id)->take(5)->get();
    $particular_vinc=DB::table('expedientes')->join('expediente_particularvinc','expediente_particularvinc.id_expediente','=','expedientes.id')->join('personas',
    'personas.id','=','expediente_particularvinc.id_particularvinc')->select('personas.*')->where('expedientes.id','=',$id)->take(5)->get();
    $presunto_resp=DB::table('expedientes')->join('expediente_presuntoresp','expediente_presuntoresp.id_expediente','=','expedientes.id')->join('personas',
    'personas.id','=','expediente_presuntoresp.id_presuntoresp')->select('personas.*')->where('expedientes.id','=',$id)->take(5)->get();

    $tipo_falta=DB::table('expedientes')
    ->join('tipofalta','tipofalta.id','=','expedientes.id_falta')
    ->select('tipofalta.tipo_falta')->where('expedientes.id','=',$id)->first();

 $invoice = "2222";
 //print_r($);
 $view =  \View::make('expedientes.portada', compact('expediente','datos','fecha','actor','demandados','autoridad_inv','autoridad_sust','denunciante','particular_vinc','presunto_resp','tipo_falta'))->render();
 //->setPaper($customPaper, 'landscape');
 $pdf = \App::make('dompdf.wrapper');
 $pdf->loadHTML($view);
 return $pdf->stream('Portada.pdf');


}

public function docs(){
  

 $phpWord = new \PhpOffice\PhpWord\PhpWord();


        $section = $phpWord->addSection();

        $aqui = 'aqui va la firmaaaaaaaaaaaaa';

        $description = "
        1.	El Pleno del Tribunal goza de autonomía para dictar las medidas necesarias para un eficiente manejo administrativo, así como dictar acuerdos, lineamientos, criterios, circulares, manuales operativos y de procedimientos y demás instrumentos que resulten necesarias para el eficaz desempeño de sus atribuciones, en términos de lo dispuesto por el artículo 112 de la Constitución Política del Estado Libre y Soberano del Zacatecas, artículos 1, fracción I, 19, apartado B), fracción I y SEXTO y OCTAVO Transitorios de la Ley de Justicia Administrativa del Estado de Zacatecas, publicada el dos de enero del dos mil veintiuno, mediante Decreto número 576, en el Periódico Oficial Órgano de Gobierno del Estado de Zacatecas, Suplemento número uno, Tomo CXXXI, además de los artículos 10 y 38 fracciones I, II del Reglamento Interior de este Órgano Jurisdiccional vigente a la fecha. 
        
        2.	Con la entrada en vigor la nueva Ley de Justicia Administrativa del Estado de Zacatecas y de conformidad con el Acuerdo de Pleno TJA-02-EXT-12/01/2021.7 aprobado en esta misma Sesión, en el que se aprueba la asignación de la competencia especializada de las Salas Unitarias del Tribunal en términos del artículo OCTAVO Transitorio de la ley vigente, debemos entender que se crea también una nueva estructura orgánica y competencial del Tribunal, pues además de la transición a Salas Unitarias, se establecen nuevas competencias a las áreas que integran este órgano jurisdiccional, por lo que es preciso adecuar la operatividad interna para no entorpecer el correcto funcionamiento; de manera particular, las actuaciones de registro por la Oficialía de Partes del Tribunal en los expedientes de nuevo ingreso, recursos para juicio ordinario, de responsabilidades administrativas, recursos e incidentes.
        
        
        3.	Si atendemos a la especialización de las Salas Unitarias, la Oficialía de Partes, ahora tendrá como objetivo la recepción física, registro y distribución de los escritos de demandas iniciales en las materias Contenciosa Administrativa y también de Responsabilidades Administrativas; mismas que deberán turnase a la Primera, Segunda y Tercera Salas según corresponda, lo que conlleva a que su registro sea diferente al que se venía empleando.
        
        Cabe precisar que la Tercera Sala Especializada en Responsabilidades Administrativas, requiere de un libro de registro único para dichos asuntos, a efecto de llevar un número consecutivo de sus expedientes y diferenciarlos del Juico Contencioso Administrativo, por lo que será necesario manejarlos de manera separada a los de Juicio Ordinario, pues en este último supuesto, las demandas que ingresen deberán turnarse a las Salas Primera y Segunda de manera alternada y en número consecutivo, lo que justifica un formato y registro diferente y único para cada competencia.
        
        Así también, para los cuadernillos auxiliares relativos a los recursos e incidentes establecidos en la ley vigente, así como en Ley General de Responsabilidades Administrativas, se sugiere que el número de registro en los libros correspondientes, contenga un formato que permita diferenciarlos de manera práctica.
        
        Por lo anteriormente expuesto, el Pleno del Tribunal emite el siguiente:
        
        ACUERDO DE PLENO POR EL QUE SE ESTABLECEN LAS REGLAS PARA LA NUMERACIÓN DE LOS EXPEDIENTES QUE INGRESEN A TRÁMITE.
        
        DISPOSICIONES GENERALES
        
        Primera. El presente acuerdo tiene por objeto establecer las REGLAS para el registro alfanumérico de expedientes de demandas, así como los cuadernillos de recursos e incidentes recibidos en la Oficialía de Partes del Tribunal atendiendo a la especialización de las Salas Unitarias en materia Contencioso Administrativa y de Responsabilidades Administrativas, de conformidad con los artículos 9 y 10 de la ley vigente. 
        Segunda. La Oficialía de Partes, como encargada de coordinar la recepción de los escritos iniciales de demanda, así como los escritos de recursos e incidentes que se interpongan ante el Tribunal, deberá cerciorarse de registrarlos y distribuirlos correctamente entre las Tres Salas Unitarias del Tribunal según sus respectivas competencias, de conformidad a lo dispuesto en el Acuerdo de Pleno TJA-02-EXT-12/01/2021.7
        Tercera. De conformidad con el artículo 10 del Reglamento Interior del Tribunal, la Oficialía de Partes registrará las demandas en los libros correspondientes bajo las siguientes reglas:
        a)	Libro de Gobierno para el Registro de los Expedientes de competencia ordinaria: 
        
        a). Deberá contener el siguiente formato: 
        
        TJA/0001/2021-I
        
        En donde, las siglas “TJA” hacen referencia al Tribunal de Justicia Administrativa, seguidas de una diagonal y cuatro dígitos para el número consecutivo que corresponde al expediente, después una diagonal seguida con el número correspondiente al año calendario de inicio de trámite y un guion para separar el número de la Sala Unitaria a la que corresponde conocer del expediente; es decir, a la Primera Sala corresponde el número uno romano (I) y a la Segunda Sala el número dos romano (II).
        
        b). Se asignará de manera progresiva el número de expediente atendiendo la fecha y hora de recepción de la promoción, sea mediante presentación directa de la promoción ante la Oficialía de Partes o presentación en Buzón Electrónico
        c). Para efectos de orden, los números impares corresponderán a la Primera Sala y los números pares a la Segunda Sala.
        
        b)	Libro de Responsabilidades Graves y Faltas de Particulares:
        
        a). Deberá contener el siguiente formato: 
        
        TJA/RAG/0001/2021-III
        
        En donde, las siglas “TJA” hacen Referencia al Tribunal de Justicia Administrativa, diagonal, seguidas las siglas “RAG” que corresponden a Responsabilidades Administrativas Graves, diagonal y cuatro dígitos para el número consecutivo que corresponde al expediente, diagonal seguida con el número correspondiente al año calendario de recepción del expediente, un guion para separarlo del número tres romano (III), que corresponde a la Tercera Sala Especializada en Responsabilidades Administrativas.
        
        
        Cuarta.  Con fundamento en lo dispuesto por el artículo 38, fracciones I, II, III, IV y V del Reglamento Interior del Tribunal, Oficialía de Partes del Tribunal deberá registrar de manera consecutiva los escritos iniciales de demanda en los libros correspondientes, en donde se asentará como datos mínimos de identificación los siguientes: 
        
        a)	Libro de Gobierno para el Registro de los Expedientes de competencia ordinaria:
        
        a) Número de expediente; 
        b) Actor; 
        c) Demandado; 
        d) Tipo de Juicio; 
        e) Inicio; y 
        f) Observaciones. 
        
        b)	Libro de Responsabilidades Administrativas Graves y Faltas de Particulares relacionadas:
        
        a) Número de expediente; 
        b) Presunto Responsable; demandado es el presunto responsable
        c) Particular vinculado con faltas administrativas graves; pueden ser físicas o morales
        d) Denunciante; se presenta en el inicio, puede ser un tercero, terceros, muchos
        e) Autoridad Investigadora; puede ser función pública o órganos internos de control. 
        f)  Autoridad Sustanciadora; remite el expediente 
        g) Tipo de Falta
        g) Observaciones. 
        
        c)	Libro de Recursos e incidentes:
        
        a) Número de expediente; 
        b) Expediente de origen
        b) Promovente; 
        c) Tipo de promoción; 
        d) Inicio; y 
        e) Observaciones. 
        
        Quinta. DEL REGISTRO DE RECUROS E INCIDENTES. De conformidad con los artículos 19, apartado A, fracciones I, II, VI, XI y XII y 34, apartado B, fracción IV de la Ley de Justicia Administrativa del Estado de Zacatecas, vigente, los Recurso de Reconsideración, Revisión, Queja, Reclamación, Apelación, Revisión e Inconformidad e incidentes, sea en vía ordinaria o en Responsabilidades Administrativas incluidas en este rubro, las medidas cautelares establecidas en Ley General, los que deberán registrarse bajo los formatos siguientes:
        
        Reconsideración (Juicio Ordinario): TJA/RR/0001/2021-P
        Revisión: (Juicio Ordinario): TJA/REV/0001/2021-P
        Queja (Juicio Ordinario): TJA/RQ/0001/2021-P
        Reclamación (RAG): TJA/LG/REC/0001/2021-P
        Apelación (RAG): TJA/LG/APEL/0001/2021-P
        Revisión (RAG): TJA/LG/REV/0001/2021-P
        Inconformidad (RAG): TJA/LG/INCO/0001/2021-III
        Incidentes: TJA/INCIDENTE/0001/2021-I
                        TJA/LG/INCIDENTE/0001/2021-III
        
        En donde, las siglas “TJA” hacen Referencia al Tribunal de Justicia Administrativa, diagonal, en el solo en caso los recursos establecidos en Ley General, las siglas “LG”, diagonal, seguidas las siglas que identifican al recurso o incidente, diagonal, seguido de cuatro dígitos para el número consecutivo que corresponde al cuadernillo de recurso, diagonal seguida con el número correspondiente al año calendario de recepción del recurso, un guion para separarlo de la letra “P” para Pleno y “I” para la Primera Sala, “II” para Segunda Sala y “III” para la Tercera Sala, esto atendiendo la competencia para resolución del recurso o incidente.
        
        
        Sexta. Para la identificación de los expedientes que se tramitan en el Tribunal, a cada asunto se asignará un color de Carátula que permita identificarlos, así como los datos de identificación que se asienten en el libro de registro, a saber:
        
        1. Datos de identificación para competencia ordinaria:
        a) Número de expediente; 
        b) Actor; 
        c) Demandado; 
        d) Tipo de Juicio; 
        e) Inicio; y 
        f) Observaciones. 
        
        2. Datos de identificación para Responsabilidades Administrativas:
        a) Número de expediente; 
        b) Presunto Responsable;
        c) Particular vinculado con faltas administrativas graves;
        d) Denunciante;
        e) Autoridad Investigadora; 
        f)  Autoridad Sustanciadora;
        g) Tipo de Falta
        g) Observaciones. 
        
        3. Datos de identificación para recursos e incidentes:
        a) Número de expediente; 
        b) Expediente de origen
        b) Promovente; 
        c) Tipo de promoción; 
        d) Inicio; y 
        e) Observaciones. 
        
        Séptima. La apertura de los libros de registro de expedientes se realizará en términos del Reglamento Interior.
        
        Octava. La Secretaria General de Acuerdos deberá supervisar las funciones de la Oficialía de Partes, para efecto de que el registro de las demandas, se realicen conforme a lo dispuesto en los artículos 41, fracciones VIII y XI de la Ley de Justicia Administrativa del Estado de Zacatecas, vigente, artículo 36 del  Reglamento Interior el Tribunal, así como en el presente acuerdo y los lineamientos que para tal efecto se expidan.
        
        El incumplimiento a tales disposiciones por parte de los servidores públicos obligados, será sancionado en términos de la Ley General de Responsabilidades Administrativas.
        
        Novena. Con fundamento en los artículos 19, apartado B, fracción I, 81 y SEXTO Transitorio de la Ley de Justicia Administrativa del Estado de Zacatecas, vigente, emítanse los lineamientos correspondientes.
        
        ";


        $section->addImage("http://itsolutionstuff.com/frontTheme/images/logo.png");
        $section->addText($description);
        $encabezado = $section->addHeader();
        $encabezado->addWatermark("../public/img/marca_agua_tja.png", [
            "width" => 200,
        ]);

       // $encabezado->addText();
       $section->addTextBox($aqui, array('textDirection'=>\PhpOffice\PhpWord\Style\Cell::TEXT_DIR_TBRL) );
        //$cell = $table->addCell(2000, array('textDirection'=>\PhpOffice\PhpWord\Style\Cell::TEXT_DIR_BTLR) );

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (Exception $e) {
        }


        return response()->download(storage_path('helloWorld.docx'));
    }






/////////////////////////////estadisticas ofi//////////////////////////////////////////////// 
public function estadisticas_ofi(){ 
        setlocale(LC_ALL, 'es_ES');
        $mes=date("m");
        $date = date('Y-m-d');
        $year = date("Y");

       
        //resto 1 a単o
        $year_menos=date("Y",strtotime($date."- 1 year"));
        $mes_menos=date("m",strtotime($date."- 1 month"));

        $mes_letra = strftime("%B", strtotime($date));
        
        $user=Auth::user();

        $expedientes=DB::table('expedientes')
        ->select('expedientes.*')->get();

        $amparos_promociones=DB::table('amparos_promociones')
        ->select('amparos_promociones.*')->get();
        $total_amp_prom=count($amparos_promociones);
       
        $total_expedientes=count($expedientes);
      
        $expedientes_mes=count(DB::table('expedientes')
        ->whereMonth('fecha','=',$mes)->select('expedientes.*')->get());
     
        $expedientes_year=count(DB::table('expedientes')
        ->whereYear('fecha','=',$year)->select('expedientes.*')->get());

        $expedientes_year_menos=count(DB::table('expedientes')
        ->whereYear('fecha','=',$year_menos)->select('expedientes.*')->get());

        $expedientes_mes_menos=count(DB::table('expedientes')
        ->whereMonth('fecha','=',$mes_menos)->select('expedientes.*')->get());

        //////////////////////////////////////////////////////////////////////////
        $amparos_mes=count(DB::table('amparos_promociones')
        ->whereMonth('fecha','=',$mes)->select('amparos_promociones.*')->get());
     
        $amparos_year=count(DB::table('amparos_promociones')
        ->whereYear('fecha','=',$year)->select('amparos_promociones.*')->get());

        $amparos_year_menos=count(DB::table('amparos_promociones')
        ->whereYear('fecha','=',$year_menos)->select('amparos_promociones.*')->get());

        $amparos_mes_menos=count(DB::table('amparos_promociones')
        ->whereMonth('fecha','=',$mes_menos)->select('amparos_promociones.*')->get());
        
        $all_mes_menos = $amparos_mes_menos + $expedientes_mes_menos;
        $all_year_menos = $amparos_year_menos + $expedientes_year_menos;
        $all_year = $expedientes_year + $amparos_year;
        $all_mes = $expedientes_mes + $amparos_mes;
        $all_exp = $total_amp_prom + $total_expedientes;
        
    return view('expedientes.estadisticas_oficialia',[
    'all_mes_menos'=>$all_mes_menos
    ,'all_year_menos'=>$all_year_menos
    ,'all_year'=>$all_year
    ,'all_exp'=>$all_exp
    ,'all_mes'=>$all_mes    
    ,'expedientes_mes_menos'=>$expedientes_mes_menos
    ,'expedientes_year_menos'=>$expedientes_year_menos
    ,'total_expedientes'=>$total_expedientes
    ,'expedientes_year'=>$expedientes_year
    ,'year'=>$year,"mes_letra"=>$mes_letra
    ,'expedientes_mes'=>$expedientes_mes
    ,'expedientes'=>$expedientes,'user'=>$user
    ]);
  }
  ///////////////////////////////Nulidad/////////////////////////////////////
  public function traer_exp_nul(Request $request,$fecha_inicio,$fecha_fin){   

    if ($request->ajax()) {         

        $expedientes_nul=count(DB::table('expedientes')
        ->where('tipo','=','NULIDAD')
        ->whereDate('fecha', '<=', $fecha_fin)
        ->whereDate('fecha', '>=', $fecha_inicio)
        ->select('expedientes.*')->get());

    return response()->json(['expedientes_nul'=>$expedientes_nul]);

    }

  }
  //////////////////////////////////////////////////////////////////////////

   ///////////////////////////////RAG/////////////////////////////////////
   public function traer_exp_rag(Request $request,$fecha_inicio,$fecha_fin){   

    if ($request->ajax()) {         

        $expedientes_rag=count(DB::table('expedientes')
        ->where('tipo','=','RAG')
        ->whereDate('fecha', '<=', $fecha_fin)
        ->whereDate('fecha', '>=', $fecha_inicio)
        ->select('expedientes.*')->get());

    return response()->json(['expedientes_rag'=>$expedientes_rag]);

    }

  }
  //////////////////////////////////////////////////////////////////////////

    ///////////////////////////////Generalidades/////////////////////////////////////
    public function traer_exp_gen(Request $request,$fecha_inicio,$fecha_fin){   

        if ($request->ajax()) {         
    
            $expedientes_gen=count(DB::table('expedientes')
            ->where('tipo','=','GENERALIDAD')
            ->whereDate('fecha', '<=', $fecha_fin)
            ->whereDate('fecha', '>=', $fecha_inicio)
            ->select('expedientes.*')->get());
    
        return response()->json(['expedientes_gen'=>$expedientes_gen]);
    
        }
    
      }
      //////////////////////////////////////////////////////////////////////////

       ///////////////////////////////Amparo/////////////////////////////////////
    public function traer_exp_amp(Request $request,$fecha_inicio,$fecha_fin){   

        if ($request->ajax()) {         
    
            $expedientes_amps=count(DB::table('amparos_promociones')
            ->where('tipo','=','AMPARO')
            ->whereDate('fecha', '<=', $fecha_fin)
            ->whereDate('fecha', '>=', $fecha_inicio)
            ->select('amparos_promociones.*')->get());
    
        return response()->json(['expedientes_amps'=>$expedientes_amps]);
    
        }
    
      }
      //////////////////////////////////////////////////////////////////////////

         ///////////////////////////////Promociónes/////////////////////////////////////
    public function traer_exp_prom(Request $request,$fecha_inicio,$fecha_fin){   

        if ($request->ajax()) {         
    
            $expedientes_prom=count(DB::table('amparos_promociones')
            ->where('tipo','=','PROMOCION')
            ->whereDate('fecha', '<=', $fecha_fin)
            ->whereDate('fecha', '>=', $fecha_inicio)
            ->select('amparos_promociones.*')->get());
    
        return response()->json(['expedientes_prom'=>$expedientes_prom]);
    
        }
    
      }
      //////////////////////////////////////////////////////////////////////////
  
////////////////////////////////Estadisticas firmas//////////////////////////////////////////////////////////
public function estadisticasfirmas(){ 
    $user=Auth::user();
    $tipo_juicio=DB::table('tipos_juicios')->where('estado','=','ACTIVO')->get();
    $tipo_documentos=DB::table('tipodocumento')->where('estado','=','ACTIVO')->get();
    $tipo_exp=['RAG','NULIDAD'];
    $users=DB::table('users')->where('estado','=','ACTIVO')->orderBy('funcion','ASC')->get();
    $salas=DB::table('salamagistrado')->where('estado','=','ACTIVO')->get();
    
    setlocale(LC_ALL, 'es_MX');
    
    $registros=DB::table('asignaciones_firma')->get();
   
    $total_registros=count($registros);

    $date = date('Y-m-d');

    $mes=date("m");
        
    $year = date("Y");

    $year_menos=date("Y",strtotime($date."- 1 year"));
    
    $mes_menos=date("m",strtotime($date."- 1 month"));

    $mes_letra = strftime("%B", strtotime($date));
    $docs_mes=count(DB::table('asignaciones_firma')
        ->whereMonth('created_at','=',$mes)->select('asignaciones_firma.*')->get());

    $registros_year_menos=count(DB::table('asignaciones_firma')
        ->whereYear('created_at','=',$year_menos)->select('asignaciones_firma.*')->get());
        
    $registros_year=count(DB::table('asignaciones_firma')
        ->whereYear('created_at','=',$year)->select('asignaciones_firma.*')->get());

        //////////////Documentos//////////////////////

        $num_docs = count( DB::table('asignaciones_firma')
        ->select('asignaciones_firma.num_asignacion')
        ->distinct()
        ->get()); // total de documentos

        $docus_mes=count(DB::table('asignaciones_firma')
        ->select('asignaciones_firma.num_asignacion')
        ->whereMonth('created_at','=',$mes)
        ->distinct()
        ->get());

        $docs_year_menos=count(DB::table('asignaciones_firma')
        ->select('asignaciones_firma.num_asignacion')
        ->whereYear('created_at','=',$year_menos)
        ->distinct()
        ->get());
        
        $docs_year=count(DB::table('asignaciones_firma')
        ->select('asignaciones_firma.num_asignacion')
        ->whereYear('created_at','=',$year)
        ->distinct()
        ->get());

        //print_r($docs_mes);
 //////////////////////////////////////////////////

    return view('firmasElectronicas.estadisticas',[
    'tipo_juicio'=>$tipo_juicio,
    'tipo_documentos'=>$tipo_documentos,
    'tipo_exp'=>$tipo_exp,
    'salas'=>$salas,
    'mes_letra'=>$mes_letra,
    'docs_mes'=>$docs_mes,
    'total_registros'=>$total_registros,
    'registros_year_menos'=>$registros_year_menos,
    'year'=>$year,
    'registros_year'=>$registros_year,
    'num_docs'=>$num_docs,
    'docus_mes'=>$docus_mes,
    'docs_year_menos'=>$docs_year_menos,
    'docs_year'=>$docs_year,
    ]);
  }
////////////////////////////////Juicios/////////////////////////////////////////////////////////////////////////////////////////
    public function traerJuiciosTotales(Request $request,$juicio){   

        if ($request->ajax()) {         

        $juicios_tots=DB::table('asignaciones_firma')
        ->where('asignaciones_firma.tipo_juicio','=',$juicio)
        //->whereDate('created_at','=',$fecha)
        ->select('asignaciones_firma.tipo_juicio','asignaciones_firma.estado')->get();   

        return response()->json(['juicios_tots'=>$juicios_tots]);

        }

    }    

    public function traerJuiciosEstadisticas(Request $request,$juicio,$fecha_inicio,$fecha_fin,$sala){   

      if ($request->ajax()) {         
 
      $juicios=DB::table('asignaciones_firma')
      ->where('asignaciones_firma.tipo_juicio','=',$juicio)
      ->where('asignaciones_firma.sala','=',$sala) 
      ->whereDate('created_at', '<=', $fecha_fin)
      ->whereDate('created_at', '>=', $fecha_inicio)
      //->whereDate('created_at','=',$fecha)
      ->select('asignaciones_firma.tipo_juicio','asignaciones_firma.estado')->get();   

      return response()->json(['juicios'=>$juicios]);

      }

    }

    public function traerJuiciosFirmados(Request $request,$juicio,$fecha_inicio,$fecha_fin,$sala){  

        if ($request->ajax()) {         
   
        $juicios=DB::table('asignaciones_firma')
        ->where('asignaciones_firma.tipo_juicio','=',$juicio) 
        ->where('asignaciones_firma.sala','=',$sala)
        ->whereDate('created_at', '<=', $fecha_fin)
        ->whereDate('created_at', '>=', $fecha_inicio)
        ->where('asignaciones_firma.estado','=','FIRMADO')
        ->select('asignaciones_firma.tipo_juicio','asignaciones_firma.estado')->get();
  
        return response()->json(['juicios'=>$juicios]);
  
        }
  
      }

      public function traerJuiciosPendientes(Request $request,$juicio,$fecha_inicio,$fecha_fin,$sala){  

        if ($request->ajax()) {         
   
        $juicios=DB::table('asignaciones_firma')
        ->where('asignaciones_firma.tipo_juicio','=',$juicio)  
        ->where('asignaciones_firma.estado','=','PENDIENTE')
        ->where('asignaciones_firma.sala','=',$sala)
        ->whereDate('created_at', '<=', $fecha_fin)
        ->whereDate('created_at', '>=', $fecha_inicio)
        ->select('asignaciones_firma.tipo_juicio','asignaciones_firma.estado')->get();
  
        return response()->json(['juicios'=>$juicios]);
  
        }
  
      }
      
      public function traerJuiciosRevocadas(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){  

        if ($request->ajax()) {         
   
        $juicios=DB::table('asignaciones_firma')
        ->where('asignaciones_firma.tipo_juicio','=',$documento)  
        ->where('asignaciones_firma.estado','=','REVOCADO')
        ->where('asignaciones_firma.sala','=',$sala)
        ->whereDate('created_at', '<=', $fecha_fin)
        ->whereDate('created_at', '>=', $fecha_inicio)
        ->select('asignaciones_firma.tipo_juicio','asignaciones_firma.estado')->get();
  
        return response()->json(['juicios'=>$juicios]);
  
        }
  
      }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function traerDocumentos_totales(Request $request,$documento){   

    if ($request->ajax()) {         

    $documentos_tots=DB::table('asignaciones_firma')
    ->where('asignaciones_firma.tipo_documento','=',$documento)
    //->whereDate('created_at','=',$fecha)
    ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado','asignaciones_firma.sala')->get();   

    return response()->json(['documentos_tots'=>$documentos_tots]);

    }
}

public function traerDocumentosEstadisticas(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){   

    if ($request->ajax()) {         
        if($documento != "ACUERDO"){
            $documentos=DB::table('asignaciones_firma')
                ->where('asignaciones_firma.tipo_documento','=',$documento)
                ->where('asignaciones_firma.sala','=',$sala) 
                ->whereDate('created_at', '<=', $fecha_fin)
                ->whereDate('created_at', '>=', $fecha_inicio)
                //->whereDate('created_at','=',$fecha)
                ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();   

            return response()->json(['documentos'=>$documentos]);
        }else{

            $documentos=DB::table('asignaciones_firma')
            ->where('asignaciones_firma.tipo_documento','=',$documento)
            ->whereDate('created_at', '<=', $fecha_fin)
            ->whereDate('created_at', '>=', $fecha_inicio)
            //->whereDate('created_at','=',$fecha)
            ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();   
        
            return response()->json(['documentos'=>$documentos]);
        }

    }

  }

  public function traerDocumentosFirmados(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){  

      if ($request->ajax()) {         
        if($documento != "ACUERDO"){
            $documentos=DB::table('asignaciones_firma')
            ->where('asignaciones_firma.tipo_documento','=',$documento) 
            ->where('asignaciones_firma.sala','=',$sala)
            ->whereDate('created_at', '<=', $fecha_fin)
            ->whereDate('created_at', '>=', $fecha_inicio)
            ->where('asignaciones_firma.estado','=','FIRMADO')
            ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();
      
            return response()->json(['documentos'=>$documentos]);
        }else{

            $documentos=DB::table('asignaciones_firma')
            ->where('asignaciones_firma.tipo_documento','=',$documento)
            ->whereDate('created_at', '<=', $fecha_fin)
            ->whereDate('created_at', '>=', $fecha_inicio)
            ->where('asignaciones_firma.estado','=','FIRMADO')
            ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();
      
            return response()->json(['documentos'=>$documentos]);
        }

      }

    }

    public function traerDocumentosPendientes(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){  

      if ($request->ajax()) {         
        if($documento != "ACUERDO"){

            $documentos=DB::table('asignaciones_firma')
            ->where('asignaciones_firma.tipo_documento','=',$documento)  
            ->where('asignaciones_firma.estado','=','PENDIENTE')
            ->where('asignaciones_firma.sala','=',$sala)
            ->whereDate('created_at', '<=', $fecha_fin)
            ->whereDate('created_at', '>=', $fecha_inicio)
            ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();
      
            return response()->json(['documentos'=>$documentos]);

        }else{

            $documentos=DB::table('asignaciones_firma')
            ->where('asignaciones_firma.tipo_documento','=',$documento)  
            ->where('asignaciones_firma.estado','=','PENDIENTE')
            ->whereDate('created_at', '<=', $fecha_fin)
            ->whereDate('created_at', '>=', $fecha_inicio)
            ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();
      
            return response()->json(['documentos'=>$documentos]);
        }

      }

    }
    
    public function traerDocumentosRevocadas(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){  

        if ($request->ajax()) {         
            if($documento != "ACUERDO"){
                $documentos=DB::table('asignaciones_firma')
            ->where('asignaciones_firma.tipo_documento','=',$documento)  
            ->where('asignaciones_firma.estado','=','REVOCADO')
            ->where('asignaciones_firma.sala','=',$sala)
            ->whereDate('created_at', '<=', $fecha_fin)
            ->whereDate('created_at', '>=', $fecha_inicio)
            ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();
      
            return response()->json(['documentos'=>$documentos]);
            }else{

            $documentos=DB::table('asignaciones_firma')
            ->where('asignaciones_firma.tipo_documento','=',$documento)  
            ->where('asignaciones_firma.estado','=','REVOCADO')
            ->whereDate('created_at', '<=', $fecha_fin)
            ->whereDate('created_at', '>=', $fecha_inicio)
            ->select('asignaciones_firma.tipo_documento','asignaciones_firma.estado')->get();
      
            return response()->json(['documentos'=>$documentos]);
            }
  
        }
  
      }
//////////////////////////////////////EXPEDIENTES//////////////////////////////////////////////////////////////////////////////////77

public function traerExpedientes_totales(Request $request,$expediente){   

    if ($request->ajax()) {         

    $expedientes_tots=DB::table('asignaciones_firma')
    ->where('asignaciones_firma.tipo_expediente','=',$expediente)
    //->whereDate('created_at','=',$fecha)
    ->select('asignaciones_firma.tipo_expediente','asignaciones_firma.estado','asignaciones_firma.sala')->get();   

    return response()->json(['expedientes_tots'=>$expedientes_tots]);

    }
}

public function traerExpedientesEstadisticas(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){   

    if ($request->ajax()) {         

    $expedientes=DB::table('asignaciones_firma')
    ->where('asignaciones_firma.tipo_expediente','=',$documento)
    ->where('asignaciones_firma.sala','=',$sala) 
    ->whereDate('created_at', '<=', $fecha_fin)
    ->whereDate('created_at', '>=', $fecha_inicio)
    //->whereDate('created_at','=',$fecha)
    ->select('asignaciones_firma.tipo_expediente','asignaciones_firma.estado')->get();   

    return response()->json(['expedientes'=>$expedientes]);

    }

  }

  public function traerExpedientesFirmados(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){  

      if ($request->ajax()) {         
 
      $expedientes=DB::table('asignaciones_firma')
      ->where('asignaciones_firma.tipo_expediente','=',$documento) 
      ->where('asignaciones_firma.sala','=',$sala)
      ->whereDate('created_at', '<=', $fecha_fin)
      ->whereDate('created_at', '>=', $fecha_inicio)
      ->where('asignaciones_firma.estado','=','FIRMADO')
      ->select('asignaciones_firma.tipo_expediente','asignaciones_firma.estado')->get();

      return response()->json(['expedientes'=>$expedientes]);

      }

    }

    public function traerExpedientesPendientes(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){  

      if ($request->ajax()) {         
 
      $expedientes=DB::table('asignaciones_firma')
      ->where('asignaciones_firma.tipo_expediente','=',$documento)  
      ->where('asignaciones_firma.estado','=','PENDIENTE')
      ->where('asignaciones_firma.sala','=',$sala)
      ->whereDate('created_at', '<=', $fecha_fin)
      ->whereDate('created_at', '>=', $fecha_inicio)
      ->select('asignaciones_firma.tipo_expediente','asignaciones_firma.estado')->get();

      return response()->json(['expedientes'=>$expedientes]);

      }

    }

    public function traerExpedientesRevocadas(Request $request,$documento,$fecha_inicio,$fecha_fin,$sala){  

        if ($request->ajax()) {         
   
        $expedientes=DB::table('asignaciones_firma')
        ->where('asignaciones_firma.tipo_expediente','=',$documento)  
        ->where('asignaciones_firma.estado','=','REVOCADO')
        ->where('asignaciones_firma.sala','=',$sala)
        ->whereDate('created_at', '<=', $fecha_fin)
        ->whereDate('created_at', '>=', $fecha_inicio)
        ->select('asignaciones_firma.tipo_expediente','asignaciones_firma.estado')->get();
  
        return response()->json(['expedientes'=>$expedientes]);
  
        }
  
      }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7



public function traerSalasEstadisticas(Request $request,$sala,$fecha_inicio,$fecha_fin){   

    if ($request->ajax()) {         

    $salas=DB::table('asignaciones_firma')
    ->where('asignaciones_firma.sala','=',$sala) 
    ->whereDate('created_at', '<=', $fecha_fin)
    ->whereDate('created_at', '>=', $fecha_inicio)
    //->whereDate('created_at','=',$fecha)
    ->select('asignaciones_firma.sala','asignaciones_firma.estado')->get();   

    return response()->json(['salas'=>$salas]);

    }

  }

  public function traerSalasFirmados(Request $request,$sala,$fecha_inicio,$fecha_fin){  

      if ($request->ajax()) {         
 
      $salas=DB::table('asignaciones_firma')
      ->where('asignaciones_firma.sala','=',$sala)
      ->where('asignaciones_firma.estado','=','FIRMADO')
      ->whereDate('created_at', '<=', $fecha_fin)
      ->whereDate('created_at', '>=', $fecha_inicio)
      ->select('asignaciones_firma.sala','asignaciones_firma.estado')->get();

      return response()->json(['salas'=>$salas]);

      }

    }

    public function traerSalasPendientes(Request $request,$sala,$fecha_inicio,$fecha_fin){  

      if ($request->ajax()) {         
 
      $salas=DB::table('asignaciones_firma')
      ->where('asignaciones_firma.estado','=','PENDIENTE')
      ->where('asignaciones_firma.sala','=',$sala)  
      ->whereDate('created_at', '<=', $fecha_fin)
      ->whereDate('created_at', '>=', $fecha_inicio)
      ->select('asignaciones_firma.sala','asignaciones_firma.estado')->get();

      return response()->json(['salas'=>$salas]);

      }

    }

    public function traerSalasRevocadas(Request $request,$sala,$fecha_inicio,$fecha_fin){  

        if ($request->ajax()) {         
   
        $salas=DB::table('asignaciones_firma')  
        ->where('asignaciones_firma.estado','=','REVOCADO')
        ->where('asignaciones_firma.sala','=',$sala)
        ->whereDate('created_at', '<=', $fecha_fin)
        ->whereDate('created_at', '>=', $fecha_inicio)
        ->select('asignaciones_firma.tipo_expediente','asignaciones_firma.estado')->get();
  
        return response()->json(['salas'=>$salas]);
  
        }
  
      }

      //funcion para traer los coordinadores
      public function traerCoordinadores(Request $request,$id){

        if ($request->ajax()) {         
            $users=DB::table('expedientes')->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
            ->join('personalsala','personalsala.id_sala','=','expedientesala.id_sala')
            ->join('users','users.id','=','personalsala.id_user')->select('users.*')->where('expedientes.id','=',$id)->get();
            return response()->json(['users'=>$users]);
      
            }

      }

      public function enviarExpediente(Request $request,$id){
        $user=Auth::user();

        $expediente=ExpedientesModel::findOrFail($id);
        if($expediente->id_recibe == $user->id){
            $historial= new HistorialExpedienteModel;

        $sala=DB::table('expedientes')
            ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
            ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
           ->select('salamagistrado.*')->where('expedientes.id','=',$id)->first()->num_sala;

        $name=DB::table('users')->where('id','=',$request->get('user'))->first();   

        $historial->id_expediente=$id;
        $historial->id_user_recibe=$request->get('user');
        $historial->id_user_entrega=$user->id;
        $historial->estado="PENDIENTE";
        $historial->tipo_movimiento="ENTREGA";
        $historial->ubicacion="OFICIALIA_PARTES";
        $historial->captura=$user->name. " ".$user->apellido_p." ".$user->apellido_m;
        $historial->observaciones="SE ENVIA EL EXPEDIENTE DE OFICIALIA DE PARTES A SALA";
        $historial->save();


        $expediente->id_recibe=$request->get('user');
        $expediente->id_entrego=$user->id;
        $expediente->estado_ubicacion="PENDIENTE";
        $expediente->update();



        return Redirect::to('ver_expediente/'.$expediente->id)->with('errors', 'Se ha enviado el expediente a la sala '.$sala.", asignandoselo al usuario ".$name->name." ".$name->apellido_p." ".$name->apellido_m." .El usuario deberá aceptar el envió, para poder completar la entrega del expediente");


        }else{
            //permisos
      echo "permisos";
        }
        
      }

      public function recibirExpediente(Request $request,$id){
        $user=Auth::user();

        $expediente=ExpedientesModel::findOrFail($id);
        if($expediente->id_recibe == $user->id){
            $historial= new HistorialExpedienteModel;

        $sala=DB::table('expedientes')
            ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
            ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
           ->select('salamagistrado.*')->where('expedientes.id','=',$id)->first()->num_sala;       

           $historial->id_expediente=$id;
           $historial->id_user_recibe=$user->id;
           $historial->id_user_entrega=$expediente->id_entrego;
           $historial->tipo_movimiento="RECEPCION";
           $historial->ubicacion=$request->get('destino'.$id);
           $historial->captura=$user->name. " ".$user->apellido_p." ".$user->apellido_m;  

           $estado=$request->get('estado_envio'.$id);
           if($estado == "ACEPTAR"){
            $historial->estado="ASIGNADO";  
            $historial->observaciones="SE RECIBE EL EXPEDIENTE DE ".$historial->ubicacion." A ".$request->get('destino'.$id);

            $expediente->id_recibe=$user->id;
            $expediente->id_entrego=$historial->id_user_entrega;
            $expediente->estado_ubicacion="ASIGNADO"; 
            $mensaje="Se te ha asignado el expediente: $expediente->num_expediente";

           }else{
            $historial->estado="RECHAZADO";
            $historial->observaciones="SE RECHAZO EL EXPEDIENTE DE ".$request->get('destino'.$id)." A ".$historial->ubicacion;
            $expediente->id_recibe=$historial->id_user_entrega;
            $expediente->id_entrego=$user->id ;
            $expediente->estado_ubicacion="PENDIENTE";
            $mensaje="Se ha rechazado la recepción del expediente, y se regreso a su anterior propietario";
           }
       
        $historial->save();
        $expediente->update();



        return Redirect::to('ver_expediente/'.$expediente->id)->with('errors', $mensaje);


        }else{
            //permisos
      echo "permisos";
        }

      }

      public function mis_expedientes($id_user){
          $expedientes=DB::table('expedientes')->where('expedientes.id_recibe','=',$id_user)
          ->join('expedientesala','expedientesala.id_expediente','=','expedientes.id')
            ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
          ->join('users','users.id','=','expedientes.id_entrego')->select('expedientes.*','users.name','users.apellido_p','users.apellido_m','salamagistrado.num_sala')->orderBy('expedientes.estado_ubicacion','DESC')->get();
          return $expedientes;
      }

      public function excel(Request $request)
    {

     Excel::create('Estadisticas', function($excel) {
       $excel->sheet('Excel sheet', function($sheet) {
                 //otra opción -> $products = Product::select('name')->get();
         $tabla = asignacionFirmasModel::join('users','users.id','=','asignaciones_firma.id_solicita')
         ->select('users.name','users.apellido_p','users.apellido_m','asignaciones_firma.num_asignacion','asignaciones_firma.num_expediente','asignaciones_firma.clave_alfanumerica','asignaciones_firma.tipo_expediente','asignaciones_firma.tipo_juicio','asignaciones_firma.ponente','asignaciones_firma.proyectista','asignaciones_firma.auto','asignaciones_firma.actores','asignaciones_firma.sala','asignaciones_firma.estado','asignaciones_firma.captura','asignaciones_firma.created_at','asignaciones_firma.updated_at')
             //->where('directorio_regional')
         ->get();
         $sheet->fromArray($tabla);
         $sheet->row(1,['NOMBRE SOLICITA','APELLIDO PATERNO','APELLIDO MATERNO','NÚMERO ASIGNACIÓN','NÚMERO EXPEDIENTE','CLAVE ALFANUMÉRICA','TIPO EXPEDIENTE','TIPO JUICIO','PONENTE','PROYECTISTA','AUTO','ACTORES','SALA','ESTADO','CAPTURA','FECHA DE REGISTRO','ULTIMA ACTUALIZACION']);
         $sheet->row(1, function($row) { $row->setBackground('#CCCCCC'); });
         $sheet->setOrientation('landscape');
       });
     })->export('xls');
   }

   public function acusedia($date){        
    /* setlocale(LC_ALL, 'es_ES');
    $date = date('Y-m-d');
    $fecha = strftime("%A %d de %B del %Y", strtotime($date));
    $datos=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')->select('expedientes.*','detalle_expediente.num_anexos','detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados')->where('expedientes.id','=',$id)->first();
    $actores=DB::table('expedientes')->join('expediente_actor','expediente_actor.id_expediente','=','expedientes.id')->join('actor',
    'actor.id','=','expediente_actor.id_actor')->select('actor.*')->where('expedientes.id','=',$id)->get();
    $demandados=DB::table('expedientes')->join('expediente_demandado','expediente_demandado.id_expediente','=','expedientes.id')->join('demandado',
    'demandado.id','=','expediente_demandado.id_demandado')->select('demandado.*')->where('expedientes.id','=',$id)->get();
    $abogados=DB::table('expedientes')->join('expediente_abogado','expediente_abogado.id_expediente','=','expedientes.id')->join('abogado',
    'abogado.id','=','expediente_abogado.id_abogado')->select('abogado.*')->where('expedientes.id','=',$id)->get();
    $terceras=DB::table('expedientes')->join('expediente_tercera_persona','expediente_tercera_persona.id_expediente','=','expedientes.id')->join('tercera_persona',
    'tercera_persona.id','=','expediente_tercera_persona.id_tercera')->select('tercera_persona.*')->where('expedientes.id','=',$id)->get(); */
    
    //mcrypt_encrypt($algorithm, $key, $cleartext, $mode, $iv)
    //$num_exp= Crypt::encrypt($datos->num_expediente);
   // $num_exp = Crypt::decrypt($num_exp); 

   $datos=DB::table('amparos_promociones')
   ->join('expedientes','expedientes.id','=','amparos_promociones.id_expediente')
   ->whereDate('amparos_promociones.fecha', '=', $date)
   ->select('expedientes.num_expediente','amparos_promociones.*')
   ->get();
   

 $invoice = "2222";
 //print_r($);
 $view =  \View::make('expedientes.acusedia', compact('datos'))->render();
 //->setPaper($customPaper, 'landscape');
 $pdf = \App::make('dompdf.wrapper');
 $pdf->loadHTML($view);
 return $pdf->stream('ACUSE '.'pdf');


}


}


