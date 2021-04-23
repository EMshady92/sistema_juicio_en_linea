<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Crypt;
use App\TiposJuiciosModel;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TiposJuiciosController extends Controller
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
        //obtiene todos los tipos de juicios activos de la base de datos 
        $juicios=DB::table('tipos_juicios')->get();
        return view('tipos_juicios.index',['juicios'=>$juicios]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipos_juicios.create');
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
        $acuerdo=new TiposJuiciosModel;
        $acuerdo->tipo=$request->get('tipo');
        $acuerdo->captura=$user->name;
        $acuerdo->estado="ACTIVO";
        $acuerdo->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","tipos_juicios","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).'"," ","El usuario ha creado un nuevo tipo de juicio")');  

        return Redirect::to('/tipos_juicios');
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
        $tipos=TiposJuiciosModel::findOrFail($id);
        
        return view("tipos_juicios.edit",["tipos"=>$tipos]);
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
        $tipos=TiposJuiciosModel::findOrFail($id);
        $tipos_ant=TiposJuiciosModel::findOrFail($id);
        $tipos->tipo=$request->get('tipo');
        $tipos->captura=$user->name;
        $tipos->estado="ACTIVO";
        $tipos->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","tipos_juicios","'.$tipos->id.'","'.base64_encode(json_encode($tipos)).'","'.base64_encode(json_encode($tipos_ant)).'","El usuario ha modificado el tipo de juicio")');  


        return Redirect::to('/tipos_juicios');
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
        $tipos=TiposJuiciosModel::findOrFail($id);
        $tipos->captura=$user->name;
        $tipos->estado="INACTIVO";       
        $tipos->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","tipos_juicios","'.$tipos->id.'","'.base64_encode(json_encode($tipos)).'"," ","El usuario ha inactivado el tipo de juicio")');  

    }
}
