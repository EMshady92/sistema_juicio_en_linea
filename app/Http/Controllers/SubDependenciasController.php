<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\SubDependenciasModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubDependenciasController extends Controller
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
        $subdependencias=DB::table('subdependencias')
        ->join('personas','personas.id','=','subdependencias.id_dependencia')
        ->select('subdependencias.*','personas.nombre as nombre_dependencia')
        ->get();
        return view('subdependencias.index',['subdependencias'=>$subdependencias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas=DB::table('personas')
        ->where('tipo','=','AUTORIDAD')
        ->where('estado','=','ACTIVO')
        ->orderBy('nombre','ASC')->get();
         $subdependencias=DB::table('subdependencias')
        ->get();
        return view('subdependencias.create',['personas'=>$personas,'subdependencias'=>$subdependencias]);
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
        $subdependencia=new SubDependenciasModel;
        $subdependencia->nombre=$request->get('nombre');
        $subdependencia->id_dependencia=$request->get('id_dependencia');
        $subdependencia->email=$request->get('email');
        $subdependencia->telefono=$request->get('telefono');
        $subdependencia->captura=$user->name;
        $subdependencia->estado="ACTIVO";
        $subdependencia->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","subdependencias","'.$subdependencia->id.'","'.base64_encode(json_encode($subdependencia)).'"," ","El usuario ha creado una nueva subdependencia")');  


        return Redirect::to('/subdependencias');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $personas=DB::table('personas')->where('tipo','=','AUTORIDAD')
        ->where('estado','=','ACTIVO')
        ->orderBy('nombre','ASC')->get();
        $subdependencias=SubDependenciasModel::findOrFail($id);
       
        return view('subdependencias.edit',['subdependencias'=>$subdependencias,'personas'=>$personas]);
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
        $subdependencia= SubDependenciasModel::findOrFail($id);
        $subdependencia_ant= SubDependenciasModel::findOrFail($id);
        $subdependencia->nombre=$request->get('nombre');      
        $subdependencia->id_dependencia=$request->get('id_dependencia');
        $subdependencia->email=$request->get('email');
        $subdependencia->telefono=$request->get('telefono');
        $subdependencia->captura=$user->name;
        $subdependencia->estado="ACTIVO";
        $subdependencia->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","subdependencias","'.$subdependencia->id.'","'.base64_encode(json_encode($subdependencia)).'","'.base64_encode(json_encode($subdependencia_ant)).'","El usuario ha modificado los datos de la subdependencia")');  


        return Redirect::to('subdependencias')->with('errors','Registro actualizado correctamente');
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
        $subdependencia=SubDependenciasModel::findOrFail($id);
        $subdependencia->captura=$user->name;
        $subdependencia->estado="INACTIVO";       
        $subdependencia->update();
        return Redirect::back();
    }

    public function valida_email_subdeps(Request $request){
        if ($request->ajax()) { 
         $email=$request->get('email');
         $subdependencia= DB::table('subdependencias')->where('email','=',$email)->select('subdependencias.email')->first();
         return response()->json(['subdependencia'=>$subdependencia]);
        }
    }
}
