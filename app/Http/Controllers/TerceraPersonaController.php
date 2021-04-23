<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\TerceraPersonaModel;
use DB;
use Illuminate\Support\Facades\Auth;
class TerceraPersonaController extends Controller
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

        //obtiene todos las terceras personas activas de la base de datos 
        $terceras_personas=DB::table('tercera_persona')->get();

        return view('terceras_personas.index',['terceras_personas'=>$terceras_personas]);
        //
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //MANDA A LA VISTA ACTORES.CREATE
        return view('terceras_personas.create');
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
        $tercera_persona=new TerceraPersonaModel;
        $tercera_persona->tipo_persona=$request->get('tipoPersona');
        if($tercera_persona->tipo_persona == "FISICA"){
        
        $tercera_persona->nombre=$request->get('nombre');
        $tercera_persona->apellido_paterno=$request->get('apellidoPaterno');
        $tercera_persona->apellido_materno=$request->get('apellidoMaterno');
        $tercera_persona->sexo=$request->get('sexo');

        }else{
        $tercera_persona->razon_social=$request->get('razonSocial');

        }
        $tercera_persona->captura="ADMIN_PRUEBA";
        $tercera_persona->estado="ACTIVO";
        $tercera_persona->email=$request->get('email');
        $tercera_persona->save();

        return Redirect::to('/terceras_personas');
        //
    }

    public function modal_terceras_personas(Request $request){
        if ($request->ajax()) {
            $user=Auth::user();
            $tercera_persona=new TerceraPersonaModel;
            $tercera_persona->tipo_persona=$request->get('tipoPersonaTercera');
            if($tercera_persona->tipo_persona == "FISICA"){
            
            $tercera_persona->nombre=$request->get('nombreTercera');
            $tercera_persona->apellido_paterno=$request->get('apellidoPaternoTercera');
            $tercera_persona->apellido_materno=$request->get('apellidoMaternoTercera');
            $tercera_persona->sexo=$request->get('sexotercera');
    
            }else{
            $tercera_persona->razon_social=$request->get('razonSocialTercera');
    
            }
            $tercera_persona->captura="ADMIN_PRUEBA";
            $tercera_persona->estado="ACTIVO";
            $tercera_persona->email=$request->get('emailTercera');
            $tercera_persona->save();
         // retorno de datos via json
         return response()->json(
            $tercera_persona->toArray()
        );
    }
    //fin ajax

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tercera=TerceraPersonaModel::findOrFail($id);
        $expedientes=DB::table('expediente_tercera_persona')->join('tercera_persona','tercera_persona.id','=','expediente_tercera_persona.id_tercera')
        ->join('expedientes','expedientes.id','=','expediente_tercera_persona.id_expediente')->where('expediente_tercera_persona.id_tercera','=',$id)
        ->select('expedientes.*')->get();

        return view('terceras_personas.detalle', ['tercera'=>$tercera,'expedientes'=>$expedientes]);
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
        $tercera=TerceraPersonaModel::findOrFail($id);
        
        return view("terceras_personas.edit",["tercera"=>$tercera]);
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
        $tercera_persona=TerceraPersonaModel::findOrFail($id);
        $tercera_persona->tipo_persona=$request->get('tipoPersona');
        if($tercera_persona->tipo_persona == "FISICA"){
        
        $tercera_persona->nombre=$request->get('nombre');
        $tercera_persona->apellido_paterno=$request->get('apellidoPaterno');
        $tercera_persona->apellido_materno=$request->get('apellidoMaterno');
        $tercera_persona->sexo=$request->get('sexo');

        }else{
        $tercera_persona->razon_social=$request->get('razonSocial');

        }
        $tercera_persona->captura="ADMIN_PRUEBA";
        $tercera_persona->estado="ACTIVO";
        $tercera_persona->email=$request->get('email');
        $tercera_persona->save();

        return Redirect::to('/terceras_personas');
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
    
     //funcion valida email del terceras
     public function valida_email_terceras(Request $request){
        if ($request->ajax()) { 
         $email=$request->get('email');
         $user= DB::table('tercera_persona')->where('email','=',$email)->select('tercera_persona.email')->first();
         return response()->json(['user'=>$user]);
        }
    }
 //funcion valida email del terceras modal
    public function valida_email_tercerasmod(Request $request){
        if ($request->ajax()) { 
         $email=$request->get('emailTercera');
         $user= DB::table('tercera_persona')->where('email','=',$email)->select('tercera_persona.email')->first();
         return response()->json(['user'=>$user]);
        }
    }
}