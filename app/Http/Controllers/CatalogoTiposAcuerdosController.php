<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Milon\Barcode\DNS1D;
use \Milon\Barcode\DNS2D;
use \Crypt;
use App\CatalogoTiposAcuerdosModel;
use DB;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class CatalogoTiposAcuerdosController extends Controller
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
        //obtiene todos los tipos de catalogo activos de la base de datos 
        $catalogos=DB::table('catalogo_tipos_acuerdos')->get();
        return view('catalogo_tipos_acuerdos.index',['catalogos'=>$catalogos]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //MANDA A LA VISTA ACUERDOS TIPOS.CREATE
        return view('catalogo_tipos_acuerdos.create');
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
        $acuerdo=new CatalogoTiposAcuerdosModel;
        $acuerdo->tipo=$request->get('tipo');
        $acuerdo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
        $acuerdo->estado="ACTIVO";
        $acuerdo->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","catalogo_tipos_acuerdos","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).'"," ","El usuario creo un tipo de acuerdo.")');  


        return Redirect::to('/acuerdos_tipos')->with('errors', 'Tipo de acuerdo creado correctamente');
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
        $acuerdo=CatalogoTiposAcuerdosModel::findOrFail($id);
        
        return view("catalogo_tipos_acuerdos.edit",["acuerdo"=>$acuerdo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {    $user=Auth::user();
        $acuerdo=CatalogoTiposAcuerdosModel::findOrFail($id);
        $acuerdo_ant=CatalogoTiposAcuerdosModel::findOrFail($id);
        $acuerdo->tipo=$request->get('tipo');
        $acuerdo->captura=$user->name;
        $acuerdo->estado="ACTIVO";
        $acuerdo->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","catalogo_tipos_acuerdos","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).'","'.base64_encode(json_encode($acuerdo_ant)).'","El usuario modifico un tipo de acuerdo.")');  


        return Redirect::to('/acuerdos_tipos');
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
        $acuerdo=CatalogoTiposAcuerdosModel::findOrFail($id);
        $acuerdo->captura=$user->name;
        $acuerdo->estado="INACTIVO";       
        $acuerdo->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","catalogo_tipos_acuerdos","'.$acuerdo->id.'","'.base64_encode(json_encode($acuerdo)).'"," ","El usuario inactivo un tipo de acuerdo.")');  

    }
}
