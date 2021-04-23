<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\tipoFaltaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class tipoFaltaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
      $this->middleware('auth');
  }

    public function index()
    {
        
        $tipos=DB::table('tipofalta')->get();

        return view('tiposFalta.index',['tipos'=>$tipos]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tiposFalta.create');
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
        $tipo = new tipoFaltaModel;
        $tipo->tipo_falta=$request->get('tipo');
        $tipo->estado="ACTIVO";
        $tipo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
        $tipo->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","tipofalta","'.$tipo->id.'","'.base64_encode(json_encode($tipo)).'"," ","El usuario ha creado una nueva tipo de falta")');  


        return Redirect::to('tiposFalta')->with('errors','Registro guardado correctamente');
        //
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
        $tipo= tipoFaltaModel::findOrFail($id); 
        return view('tiposFalta.edit',['tipo'=>$tipo]);
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
        $tipo= tipoFaltaModel::findOrFail($id);      
        $tipo_ant= tipoFaltaModel::findOrFail($id);      
        $tipo->tipo_falta=$request->get('tipo');
        $tipo->estado="ACTIVO";
        $tipo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
        $tipo->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","tipofalta","'.$tipo->id.'","'.base64_encode(json_encode($tipo)).'","'.base64_encode(json_encode($tipo_ant)).'","El usuario ha modificado el tipo de falta")');  



        return Redirect::to('tiposFalta')->with('errors','Registro actualizado correctamente');
        //
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
        $tipo= tipoFaltaModel::findOrFail($id);      
        $tipo->estado="INACTIVO";
        $tipo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
        $tipo->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","tipofalta","'.$tipo->id.'","'.base64_encode(json_encode($tipo)).'"," ","El usuario ha inactivado el tipo de falta")');  


        return Redirect::to('tiposFalta')->with('errors','Registro inactivado correctamente');
        //
    }
}
