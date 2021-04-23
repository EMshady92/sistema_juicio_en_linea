<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\ExpedientesModel;
use App\ExpedienteAbogadoModel;
use App\ExpedienteDemandadoModel;
use App\ExpedienteActorModel;
use App\ExpedienteTerceraModel;
use App\DetalleExpedienteModel;
use App\AmparosPromocionesModel;
use App\EscaneoAnexosModel;
use App\EscaneoAnexosAmparosModel;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use \Crypt;

use DB;
use Illuminate\Support\Facades\Storage;
use Input;
use Illuminate\Support\Facades\Auth;

class AmparosController extends Controller
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
        $expedientes=DB::table('amparos_promociones')->join('expedientes','expedientes.id','=','amparos_promociones.id_expediente')
        ->select('amparos_promociones.*','expedientes.num_expediente')->get();
        return view('amparos.index',['expedientes'=>$expedientes]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        $amparo= AmparosPromocionesModel::findOrFail($id);
        $escaneos_amp=DB::table('escaneo_anexos_amparos')->where('id_amparo','=',$id)->get(); 

        $amparos=DB::table('amparos_promociones')->where('id_expediente','=',$amparo->id_expediente)->get();
        $escaneos=DB::table('escaneo_anexos')->where('id_expediente','=',$amparo->id_expediente)->get();
        $expediente=DB::table('expedientes')->join('detalle_expediente','detalle_expediente.id_expediente','=','expedientes.id')
        ->where('expedientes.id','=',$amparo->id_expediente)->select('expedientes.*','detalle_expediente.escaneo_escrito','detalle_expediente.num_anexos',
        'detalle_expediente.hojas_escrito','detalle_expediente.hojas_traslados','detalle_expediente.created_at as created_detalle')->first();
        $acuerdos=DB::table('acuerdosgenarados')->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')     
        ->where('acuerdosgenarados.id_expediente','=',$amparo->id_expediente)->select('catalogo_tipos_acuerdos.tipo','acuerdosgenarados.*')->get();

        return view('amparos.detalle', ['acuerdos'=>$acuerdos,'amparos'=>$amparos,'escaneos'=>$escaneos,'expediente'=>$expediente,'amparo'=>$amparo,'escaneos_amp'=>$escaneos_amp])->with('errors', 'Amparo del Expediente a mostrar:'.$expediente->num_expediente);
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
        
        
        $expediente=DB::table('amparos_promociones')->join('expedientes','expedientes.id','=','amparos_promociones.id_expediente')
        ->select('amparos_promociones.*','expedientes.num_expediente')->where('amparos_promociones.id','=',$id)->first();
        $expedientes=DB::table('expedientes')->get();
       
        $escaneos=DB::table('escaneo_anexos_amparos')->where('id_amparo','=',$id)->get();
        $options=['SELECCIONE UNA OPCIÓN', 'ACTA DE NACIMIENTO', 'CURP', 'IFE', 'PASAPORTE MEXICANO', 'CÉDULA PROFESIONAL', 'TITULO PROFESIONAL', 'CARTILLA DEL SERVICIO MILITAR', 'INAPAM', 'CREDENCIAL IMSS', 'CREDENCIAL ISSSTE', 'LICENCIA DE CONDUCIR', 'CARTA DE NATURALIZACIÓN'];
        $options2=['SELECCIONE UNA OPCIÓN', 'ORIGINAL', 'COPIA CERTIFICADA', 'COPIA SIMPLE'];

        return view('amparos.edit', ['expedientes'=>$expedientes,'options2'=>$options2,'options'=>$options,'expediente'=>$expediente,
        'escaneos'=>$escaneos]);

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
        $year = date("Y");
        $user=Auth::user();
        $amparo= AmparosPromocionesModel::findOrFail($id);
        $amparo_ant= AmparosPromocionesModel::findOrFail($id);
        $amparo->tipo=$request->get('tipoIngreso');
        $amparo->id_expediente=$request->get('expediente');
        $amparo->num_anexos=$request->get('hojas_anexo');
        $amparo->hojas_escrito=$request->get('hojas_escrito');             
        $amparo->fecha=$request->get('fecha');
        $amparo->estado="ACTIVO";
        $amparo->captura=$user->name;
        if($request->hasFile('escaneo_escrito')){
            $file=$request->file('escaneo_escrito');
            $file->move('OFICIALIA/archivos/amparos_promociones/',$file->getClientoriginalName());
            $amparo->escaneo_escrito=$file->getClientoriginalName();
            $path_info = pathinfo($amparo->escaneo_escrito);
           $extension = $path_info['extension']; // "bill"
           $nombre="Escaneo-Escrito-".$amparo->tipo."-".$amparo->id_expediente."-".$year.".".$extension;          
           rename("OFICIALIA/archivos/amparos_promociones/".$amparo->escaneo_escrito, "OFICIALIA/archivos/amparos_promociones/".$nombre);
           $amparo->escaneo_escrito=$nombre;
           $amparo->update();
        }else{//SI NO MODIFICO EL ARCHIVO SOLO ACTUALIZA LOS OTROS CAMPOS
            $amparo->update();
        }
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","amparos_promociones","'.$amparo->id.'","'.base64_encode(json_encode($amparo)).'","'.base64_encode(json_encode($amparo_ant)).'","El usuario actualizo los datos de la promocion.")');  


        if($request->hasFile('input1')){//VALIDA SI SE CAMBIO EL ARCHIVO 

        //ELIMINA LOS ANEXOS ACTUALES DEL EXPEDIENTE PARA ASIGNAR LOS NUEVOS
        $_aux=DB::table('escaneo_anexos_amparos')->where('id_amparo','=',$id)->get();
        foreach ($_aux as $value) {
        $_Delete=EscaneoAnexosAmparosModel::findOrFail($value->id); 
        $_Delete->delete();
        }
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
       
       $nombre="Escaneo-Anexo-N".$i."-".$amparo->tipo."-".$amparo->id_expediente."-".$year.".".$extension;          
       rename("OFICIALIA/archivos/amparos_promociones/".$escaneo_amparo->escaneo_anexos, "OFICIALIA/archivos/amparos_promociones/".$nombre);
       $escaneo_amparo->escaneo_anexos=$nombre;
       $escaneo_amparo->save();
    }                        
}//end for      
        }//endif
         return Redirect::to('ver_amparo/'.$amparo->id)->with('errors','Promocion actualizada correctamente');
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
        $expediente= AmparosPromocionesModel::findOrFail($id);
        $expediente->estado="INACTIVO";
        $expediente->captura=$user->name;
        $expediente->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","amparos_promociones","'.$expediente->id.'","'.base64_encode(json_encode($expediente)).'"," ","El usuario inactivo  la promocion.")');  

        //
    }

    public function invoice($id){
       
        $id = Crypt::decrypt($id); 
        setlocale(LC_ALL, 'es_ES');
        $date = date('Y-m-d');
        $fecha = strftime("%A %d de %B del %Y", strtotime($date));
        $amparo=DB::table('amparos_promociones')->where('id','=',$id)->first();
        $tipo=$amparo->tipo;

        $datos=DB::table('expedientes')->select('expedientes.*')->where('expedientes.id','=',$amparo->id_expediente)->first();
        $actores=DB::table('expedientes')->join('expediente_actor','expediente_actor.id_expediente','=','expedientes.id')->join('actor',
        'actor.id','=','expediente_actor.id_actor')->select('actor.*')->where('expedientes.id','=',$amparo->id_expediente)->get();
        $demandados=DB::table('expedientes')->join('expediente_demandado','expediente_demandado.id_expediente','=','expedientes.id')->join('demandado',
        'demandado.id','=','expediente_demandado.id_demandado')->select('demandado.*')->where('expedientes.id','=',$amparo->id_expediente)->get();
        $abogados=DB::table('expedientes')->join('expediente_abogado','expediente_abogado.id_expediente','=','expedientes.id')->join('abogado',
        'abogado.id','=','expediente_abogado.id_abogado')->select('abogado.*')->where('expedientes.id','=',$amparo->id_expediente)->get();
        $terceras=DB::table('expedientes')->join('expediente_tercera_persona','expediente_tercera_persona.id_expediente','=','expedientes.id')->join('tercera_persona',
        'tercera_persona.id','=','expediente_tercera_persona.id_tercera')->select('tercera_persona.*')->where('expedientes.id','=',$amparo->id_expediente)->get();
        
        $num_exp= Crypt::encrypt('ACUSE '.$tipo."-".$datos->num_expediente);
       // $num_exp = Crypt::decrypt($num_exp); 

     $view =  \View::make('amparos.invoice', compact('amparo','fecha','datos','actores','demandados','abogados','terceras','num_exp'))->render();
     //->setPaper($customPaper, 'landscape');
     $pdf = \App::make('dompdf.wrapper');
     $pdf->loadHTML($view);
     return $pdf->stream('ACUSE '.$tipo.'-'.$datos->num_expediente.'pdf');


    }
}