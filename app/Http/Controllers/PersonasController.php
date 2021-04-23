<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\PersonasModel;
use DB;
use Illuminate\Support\Facades\Auth;

class PersonasController extends Controller
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
        //obtiene todos los actores activos de la base de datos 
        $actores=DB::table('personas')->get();
        return view('personas.index',['actores'=>$actores]);
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
        $autoridades=DB::table('personas')->where('estado','=','ACTIVO')->where('tipo','=','AUTORIDAD')->get();
        return view('personas.create',['autoridades'=>$autoridades]);
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
        $persona=new PersonasModel;
        $persona->tipo=$request->get('tipoPersona');
        if($persona->tipo == "FISICA"){
        
        $persona->nombre=$request->get('nombre');
        $persona->apellido_paterno=$request->get('apellidoPaterno');
        $persona->apellido_materno=$request->get('apellidoMaterno');
        $persona->sexo=$request->get('sexo');
        $persona->curp=$request->get('curp');
        //VALIDA SI ES ABOGADO PARA GURDAR SUS DATOS
        if($request->get('abogado') == "SI"){
        $persona->num_cedula=$request->get('cedulaAbogado');
        if(Input::hasFile('file')){
        
            $file=$request->file('file');
            $fileName = $persona->num_cedula.'-'.$file->getClientOriginalName();     
            $file->move('OFICIALIA/archivos/cedulas/',$fileName);
            $persona->cedula=$fileName;
        }
        }
        }else if($persona->tipo == "MORAL"){
        $persona->razon_social=$request->get('razonSocial');
        $persona->rfc=$request->get('rfc');

        }else if($persona->tipo == "AUTORIDAD"){
            $persona->nombre=$request->get('nombre_aut');           
    
        }
        
        //SI ES UNA SUBAUTORIDAD 
        if($persona->tipo == "SUB"){

        }else{
            $persona->captura=$user->name.' '.$user->apellido_p.' '.$user->apellido_m;
            $persona->estado="ACTIVO";
            $persona->email=$request->get('email');
            $persona->telefono=$request->get('telefono');
            $persona->celular=$request->get('celular');
            $persona->save();
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","personas","'.$persona->id.'","'.base64_encode(json_encode($persona)).'"," ","El usuario ha creado una persona")');    
            return Redirect::to('/personas')->with('errors','Registro guardado correctamente');

        }
     
        //
    }

         //funcion valida cedula del abogado
         public function valida_cedula_abogado(Request $request){
            if ($request->ajax()) { 
             $num_cedula=$request->get('cedulaAbogado');
             $user= DB::table('personas')->where('num_cedula','=',$num_cedula)->select('personas.num_cedula')->first();
             return response()->json(['user'=>$user]);
            }
        }

    public function modal_actores(Request $request){
        if ($request->ajax()) {
            $user=Auth::user();
        $actor=new PersonasModel;
        $actor->tipo_persona=$request->get('tipoPersona');
        if($actor->tipo_persona == "FISICA"){
        
        $actor->nombre=$request->get('nombre');
        $actor->apellido_paterno=$request->get('apellidoPaterno');
        $actor->apellido_materno=$request->get('apellidoMaterno');
        $actor->sexo=$request->get('sexo');    
        }else{
        $actor->razon_social=$request->get('razonSocial');

        }
        $actor->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
        $actor->estado="ACTIVO";
        $actor->email=$request->get('email');
        $actor->save();   

        DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","personas","'.$persona->id.'","'.base64_encode(json_encode($persona)).'"," ","El usuario ha creado una persona")');    
         // retorno de datos via json
         return response()->json(
            $actor->toArray()
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
        $actor=PersonasModel::findOrFail($id);
        $expedientes=DB::table('expediente_actor')->join('actor','actor.id','=','expediente_actor.id_actor')
        ->join('expedientes','expedientes.id','=','expediente_actor.id_expediente')->where('expediente_actor.id_actor','=',$id)
        ->select('expedientes.*')->get();

        return view('actores.detalle', ['actor'=>$actor,'expedientes'=>$expedientes]);

        //
    }

    public function valida_email(Request $request){
        if ($request->ajax()) { 
         $email=$request->get('email');
         $user= DB::table('personas')->where('email','=',$email)->select('personas.email')->first();
         return response()->json(['user'=>$user]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $autoridades=DB::table('personas')->where('estado','=','ACTIVO')->where('tipo','=','AUTORIDAD')->get();
        $actor=PersonasModel::findOrFail($id);
        
        return view("personas.edit",["actor"=>$actor,'autoridades'=>$autoridades]);
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
        $persona=PersonasModel::findOrFail($id);
        $persona_ant=PersonasModel::findOrFail($id);
        $persona->tipo=$request->get('tipoPersona');
    
        if($persona->tipo == "FISICA"){
        
            $persona->nombre=$request->get('nombre');
            $persona->apellido_paterno=$request->get('apellidoPaterno');
            $persona->apellido_materno=$request->get('apellidoMaterno');
            $persona->sexo=$request->get('sexo');
            $persona->curp=$request->get('curp');
            //VALIDA SI ES ABOGADO PARA GURDAR SUS DATOS
            if($request->get('abogado') == "SI"){
            $persona->num_cedula=$request->get('cedulaAbogado');
            if(Input::hasFile('file')){
            
                $file=$request->file('file');
                $fileName = $persona->num_cedula.'-'.$file->getClientOriginalName();     
                $file->move('OFICIALIA/archivos/cedulas/',$fileName);
                $persona->cedula=$fileName;
            }
            }
            }else if($persona->tipo == "MORAL"){
            $persona->razon_social=$request->get('razonSocial');
            $persona->rfc=$request->get('rfc');
    
            }else if($persona->tipo == "AUTORIDAD"){
                $persona->nombre=$request->get('nombre_aut');           
        
            }
            
            //SI ES UNA SUBAUTORIDAD 
            if($persona->tipo == "SUB"){
    
            }else{
                $persona->captura=$user->name.' '.$user->apellido_p.' '.$user->apellido_m;
                $persona->estado="ACTIVO";
                $persona->email=$request->get('email');
                $persona->telefono=$request->get('telefono');
                $persona->celular=$request->get('celular');
                $persona->update();              
                DB::select('CALL InsertarMovimiento ("'.$user->id.'","insert","personas","'.$persona->id.'","'.base64_encode(json_encode($persona)).'","'.base64_encode(json_encode($persona_ant)).'","El usuario ha modificado una persona")');    
                return Redirect::to('/personas')->with('errors','Registro actualizado correctamente');
    
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
        $actor=PersonasModel::findOrFail($id);
        $actor->captura=$user->name;
        $actor->estado="INACTIVO";     
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","personas","'.$actor->id.'","'.base64_encode(json_encode($actor)).'"," ","El usuario a inactivado el registro")');    
        $actor->update();
       // return Redirect::to('/personas')->with('errors','Registro inactivado correctamente');
        
        //
    }
}