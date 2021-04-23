<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Crypt;
use App\TiposActosModel;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Input;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class TiposActosController extends Controller
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
         $actos=DB::table('tipos_acto')->get();
         return view('tipos_acto.index',['actos'=>$actos]);
         //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipos_acto.create');
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
        $acto=new TiposActosModel;
        $acto->tipo_acto=$request->get('tipo_acto');
        $acto->captura=$user->name;
        $acto->estado="ACTIVO";
        $acto->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","tipos_actos","'.$acto->id.'","'.base64_encode(json_encode($acto)).'"," ","El usuario ha creado un nuevo tipo de acto")');  

        return Redirect::to('/tipos_actos');
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
        $actos=TiposActosModel::findOrFail($id);
        
        return view("tipos_acto.edit",["actos"=>$actos]);
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
        $actos=TiposActosModel::findOrFail($id);
        $actos_ant=TiposActosModel::findOrFail($id);
        $actos->tipo_acto=$request->get('tipo_acto');
        $actos->captura=$user->name;
        $actos->estado="ACTIVO";
        $actos->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","tipos_actos","'.$actos->id.'","'.base64_encode(json_encode($actos)).'","'.base64_encode(json_encode($actos_ant)).'","El usuario ha modificado el tipo de acto")');    


        return Redirect::to('/tipos_actos');
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
        $actos=TiposActosModel::findOrFail($id);
        $actos->captura=$user->name;
        $actos->estado="INACTIVO";       
        $actos->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","tipos_actos","'.$actos->id.'","'.base64_encode(json_encode($actos)).'"," ","El usuario ha inactivado el tipo de acto")');  

    }
}
