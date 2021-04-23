<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\AbogadoModel;
use DB;
use Illuminate\Support\Facades\Auth;



class AbogadoController extends Controller
{
  


    public function __construct()
    {
      $this->middleware('auth');
  }

    /**
     * Display a listing of the resource.
     *sgit
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //obtiene todos los ABOGADOS activos de la base de datos
       
        $abogados=DB::table('abogado')->get();
        return view('abogados.index',['abogados'=>$abogados]);
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
        return view('abogados.create');
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

        $num_ced=$request->get('cedulaAbogado');
        $user=Auth::user();
        $abogado=new AbogadoModel;
       
        $abogado->nombre=$request->get('nombre');
        $abogado->apellido_paterno=$request->get('apellidoPaterno');
        $abogado->apellido_materno=$request->get('apellidoMaterno');
        $abogado->sexo=$request->get('sexo');
        $abogado->email=$request->get('emailAbogado');
        $abogado->num_cedula=$num_ced;

    

        if(Input::hasFile('file')){
        
            $file=$request->file('file');
            $fileName = $num_ced.'-'.$file->getClientOriginalName();     
            $file->move('OFICIALIA/archivos/cedulas/',$fileName);
            $abogado->cedula=$fileName;
        }
         
        
        
        
        $abogado->captura=$user->name.' '.$user->apellido_p.' '.$user->apellido_m;
        $abogado->estado="ACTIVO";       
        $abogado->save();

        return Redirect::to('/abogados');
        //
    }
 
    public function modal_abogados(Request $request){
        if ($request->ajax()) {
            $user=Auth::user();
            $abogado=new AbogadoModel;
            $abogado->nombre=$request->get('nombre_abogado');
            $abogado->apellido_paterno=$request->get('apellidoPaternoAbogado');
            $abogado->apellido_materno=$request->get('apellidoMaternoAbogado');
            $abogado->email=$request->get('emailAbogado');
            $abogado->num_cedula=$request->get('cedulaAbogado');
            $abogado->sexo=$request->get('sexo');
            $abogado->captura=$user->name;
            $abogado->estado="ACTIVO";       
            $abogado->save();
         // retorno de datos via json
         return response()->json(
            $abogado->toArray()
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
        $abogado=AbogadoModel::findOrFail($id);
        $expedientes=DB::table('expediente_abogado')->join('abogado','abogado.id','=','expediente_abogado.id_abogado')
        ->join('expedientes','expedientes.id','=','expediente_abogado.id_expediente')->where('expediente_abogado.id_abogado','=',$id)
        ->select('expedientes.*')->get();

        return view('abogados.detalle', ['abogado'=>$abogado,'expedientes'=>$expedientes]);
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
        $abogado=AbogadoModel::findOrFail($id);
        
        return view("abogados.edit",["abogado"=>$abogado]);
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
        $num_ced=$request->get('cedulaAbogado');
        $user=Auth::user();
        $abogado=AbogadoModel::findOrFail($id);
        $abogado->nombre=$request->get('nombre');
        $abogado->apellido_paterno=$request->get('apellidoPaterno');
        $abogado->apellido_materno=$request->get('apellidoMaterno');
        $abogado->sexo=$request->get('sexo');
        $abogado->email=$request->get('emailAbogado');
        $abogado->num_cedula= $num_ced;

        if(Input::hasFile('file')){
        
            $file=$request->file('file');
            $fileName = $num_ced.'-'.$file->getClientOriginalName();     
            $file->move('OFICIALIA/archivos/cedulas/',$fileName);
            $abogado->cedula=$fileName;
        }
       

        $abogado->captura=$user->name;
        $abogado->estado="ACTIVO";       
        $abogado->update();

        return Redirect::to('/abogados');
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
        $abogado=AbogadoModel::findOrFail($id);
        $abogado->captura=$user->name;
        $abogado->estado="INACTIVO";       
        $abogado->update();
        //
    }

    //funcion valida email del abogado
    public function valida_email_abogado(Request $request){
        if ($request->ajax()) { 
         $email=$request->get('emailAbogado');
         $user= DB::table('abogado')->where('email','=',$email)->select('abogado.email')->first();
         return response()->json(['user'=>$user]);
        }
    }

     //funcion valida cedula del abogado
     public function valida_cedula_abogado(Request $request){
        if ($request->ajax()) { 
         $num_cedula=$request->get('cedulaAbogado');
         $user= DB::table('abogado')->where('num_cedula','=',$num_cedula)->select('abogado.num_cedula')->first();
         return response()->json(['user'=>$user]);
        }
    }
}
