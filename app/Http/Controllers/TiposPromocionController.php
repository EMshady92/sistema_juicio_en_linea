<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Crypt;
use App\TiposPromocionModel;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TiposPromocionController extends Controller
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
        //obtiene todos los tipos de actos activos de la base de datos 
        $promociones=DB::table('tipos_promocion')->get();
        return view('tipos_promocion.index',['promociones'=>$promociones]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipos_promocion.create');
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
        $promocion=new TiposPromocionModel;
        $promocion->tipo_promocion=$request->get('tipo_promocion');
        $promocion->captura=$user->name;
        $promocion->estado="ACTIVO";
        $promocion->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","tipos_promociones","'.$promocion->id.'","'.base64_encode(json_encode($promocion)).'"," ","El usuario ha creado un nuevo tipo de promoción")');  

        return Redirect::to('/tipos_promociones');
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
        $promociones=TiposPromocionModel::findOrFail($id);
        
        return view("tipos_promocion.edit",["promociones"=>$promociones]);
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
        $promociones=TiposPromocionModel::findOrFail($id);
        $promociones_ant=TiposPromocionModel::findOrFail($id);
        $promociones->tipo_promocion=$request->get('tipo_promocion');
        $promociones->captura=$user->name;
        $promociones->estado="ACTIVO";
        $promociones->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","tipos_promociones","'.$promociones->id.'","'.base64_encode(json_encode($promociones)).'","'.base64_encode(json_encode($promociones_ant)).'","El usuario ha modificado el tipo de promoción")');    


        return Redirect::to('/tipos_promociones');
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
        $promociones=TiposPromocionModel::findOrFail($id);
        $promociones->captura=$user->name;
        $promociones->estado="INACTIVO";       
        $promociones->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","tipos_promociones","'.$promociones->id.'","'.base64_encode(json_encode($promociones)).'"," ","El usuario ha inactivado el tipo de promoción")');  

    }
}
