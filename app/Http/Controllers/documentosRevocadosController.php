<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\firmasAplicadasModel;
use App\documentosRevocadosModel;
use App\asignacionFirmasModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class documentosRevocadosController extends Controller
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
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "ADMINISTRADOR"){
        $firmas_rev=DB::table('documentos_revocados')
        ->join('asignaciones_firma','asignaciones_firma.id','=','documentos_revocados.id_asignacion')
        ->join('firmasaplicadas','firmasaplicadas.id','=','documentos_revocados.id_firma')
        ->join('users','users.id','=','asignaciones_firma.id_solicita')
        ->select('asignaciones_firma.*','firmasaplicadas.clave_alfanumerica as clave_alfanumerica_doc','documentos_revocados.captura as captura_rev','documentos_revocados.id as id_rev',
        'documentos_revocados.created_at as fecha_rev','users.name','users.apellido_p','users.apellido_m')->groupby('asignaciones_firma.num_asignacion')
        ->distinct()->get();
    
        return view('firmasRevocadas.index',['firmas_rev'=>$firmas_rev]);
    }else{
        return view('errors.permisos');
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
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "ADMINISTRADOR"){
        $firmas_act=DB::table('asignaciones_firma')
       ->select('asignaciones_firma.*')->groupby('num_asignacion')->distinct()->where('estado','=','FIRMADO')->orwhere('estado','=','PENDIENTE')->get();

       return view('firmasRevocadas.create',['firmas_act'=>$firmas_act]);
    }else{
        return view('errors.permisos');
    }
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
        if($user->funcion == "MAGISTRADO" || $user->funcion == "ADMINISTRADOR"){
        $asignaciones=DB::table('asignaciones_firma')->where('num_asignacion','=',$request->get('clave'))->get();

        if($asignaciones){
            foreach($asignaciones as $asignacion){
                $asig=asignacionFirmasModel::findOrFail($asignacion->id);
                $asig_ant=asignacionFirmasModel::findOrFail($asignacion->id);
                $asig->estado="REVOCADO";
                //$asig->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
                $asig->observaciones=$request->get('motivo');
                $asig->update();

                DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","asignaciones_firma","'.$asig->id.'","'.base64_encode(json_encode($asig)).'","'.base64_encode(json_encode($asig_ant)).'","El usuario actualizo el estado de la asignación de firma .")');  
        

                $firma=DB::table('firmaelectronica')->where('id_usuario','=',$asig->id_user)->first();
                $firma_aplicada=DB::table('firmasaplicadas')->where('id_firma','=',$firma->id)->where('id_asignacion','=',$asig->id)->first();
                $firma_aux=firmasAplicadasModel::findOrFail($firma_aplicada->id);
                $firma_aux_ant=firmasAplicadasModel::findOrFail($firma_aplicada->id);
                $firma_aux->estado="REVOCADA";
                $firma_aux->update();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","firmasaplicadas","'.$firma_aux->id.'","'.base64_encode(json_encode($firma_aux)).'","'.base64_encode(json_encode($firma_aux_ant)).'","El usuario actualizo el estado de la firma electronica del documento.")');  

      
                $doc = new documentosRevocadosModel;
                $doc->id_asignacion=$asig->id;
                $doc->id_firma=$firma_aux->id;
                $doc->motivo=$request->get('motivo');
                $doc->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
                $doc->save();
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","documentos_revocados","'.$doc->id.'","'.base64_encode(json_encode($doc)).'"," ","El usuario genero una nueva revocación de documento.")');  

              }
              return Redirect::to('revocarDocumentos')->with('errors','Documento revocado correctamente');

        }else{
           return Redirect::to('revocarDocumentos')->with('errors','Lo sentimos ocurrio un error al revocar el documento, por favor volverlo a intentar');
        }
       
    }else{
        return view('errors.permisos');
    }
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


        $asignacion=DB::table('documentos_revocados')
        ->join('asignaciones_firma','asignaciones_firma.id','=','documentos_revocados.id_asignacion')       
        ->select('asignaciones_firma.*','documentos_revocados.captura as captura_rev','documentos_revocados.id as id_rev',
        'documentos_revocados.created_at as fecha_rev','documentos_revocados.motivo')->where('documentos_revocados.id_asignacion','=',$id)->first();
 
        return view('firmasRevocadas.detalle',['asignacion'=>$asignacion]);
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
        //
    }

    public function traerAsignacionFirma(request $request,$id){
        if ($request->ajax()) {  
        $asignacion=DB::table('asignaciones_firma')
        ->join('users','users.id','=','asignaciones_firma.id_solicita')
        ->select('asignaciones_firma.*','users.name','users.apellido_p','users.apellido_m')->where('asignaciones_firma.id','=',$id)->first();

        $asignaciones=DB::table('asignaciones_firma')
        ->join('users','users.id','=','asignaciones_firma.id_user')
        ->select('asignaciones_firma.*','users.name','users.apellido_p','users.apellido_m','users.funcion')->where('asignaciones_firma.num_asignacion','=',$asignacion->num_asignacion)->get();

        return response()->json(['asignacion'=>$asignacion,'asignaciones'=>$asignaciones]);
    }   }
}
