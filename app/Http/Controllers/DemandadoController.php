<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\DemandadoModel;
use DB;
use Illuminate\Support\Facades\Auth;

class DemandadoController extends Controller
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
        //obtiene todos los DEMANDADOS  de la base de datos 
        $demandados=DB::table('demandado')->get();
        return view('demandados.index',['demandados'=>$demandados]);
        //
    }

    public function valida_nombreAutoridad(Request $request){
        if ($request->ajax()) { 
         $nombre=$request->get('nombre');
         if($nombre == null){//IF PARA CUANDO EL FORMULARIO ESTA VACIO Y VIENE DEL MODAL
         $nombre=$request->get('nombre_demandado');
         }
         $autoridad= DB::table('demandado')->where('nombre','=',$nombre)->select('demandado.nombre')->first();
         return response()->json(['autoridad'=>$autoridad]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //MANDA A LA VISTA DEMANDADOS.CREATE
        return view('demandados.create');
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
        $demandado=new DemandadoModel;
        $demandado->nombre=$request->get('nombre');       

        $demandado->captura=$user->name;
        $demandado->estado="ACTIVO";       
        $demandado->save();

        return Redirect::to('/demandados');
        //
    }

    public function modal_demandados(Request $request){
        if ($request->ajax()) {
            $user=Auth::user();
        $demandado=new DemandadoModel;
        $demandado->nombre=$request->get('nombre_demandado');       

        $demandado->captura=$user->name;
        $demandado->estado="ACTIVO";       
        $demandado->save();

         // retorno de datos via json
         return response()->json(
            $demandado->toArray()
        );
    }
}
    //fin ajax


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $demandado=DemandadoModel::findOrFail($id);
        $expedientes=DB::table('expediente_demandado')->join('demandado','demandado.id','=','expediente_demandado.id_demandado')
        ->join('expedientes','expedientes.id','=','expediente_demandado.id_expediente')->where('expediente_demandado.id_demandado','=',$id)
        ->select('expedientes.*')->get();

        return view('demandados.detalle', ['demandado'=>$demandado,'expedientes'=>$expedientes]);
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
        $demandado=DemandadoModel::findOrFail($id);
        
        return view("demandados.edit",["demandado"=>$demandado]);
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
        $demandado=DemandadoModel::findOrFail($id);
        $demandado->nombre=$request->get('nombre');        

        $demandado->captura=$user->name;
        $demandado->estado="ACTIVO";       
        $demandado->update();

        return Redirect::to('/demandados');
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
        $demandado=DemandadoModel::findOrFail($id);
        $demandado->captura=$user->name;
        $demandado->estado="INACTIVO";       
        $demandado->update();
        //
    }
}
