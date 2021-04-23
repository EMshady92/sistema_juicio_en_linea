<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\personalSalaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class personalSalaController extends Controller
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
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->tipo_usuario == "ADMINISTRADOR"){
          
            $users=DB::table('personalsala')->join('users','users.id','=','personalsala.id_user')->join('salamagistrado','salamagistrado.id','=','personalsala.id_sala')
            ->select('personalsala.*','users.name','users.apellido_p','users.apellido_m','users.sexo','users.email','salamagistrado.num_sala')->get();
            //

            return view('personalsala.index',['users'=>$users]);
        }else{
            return view('errors.permisos');
        }    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->tipo_usuario == "ADMINISTRADOR"){
          
            $users=DB::table('users')->where('estado','=','ACTIVO')->get();
            $salas=DB::table('salamagistrado')->where('estado','=','ACTIVO')->get();
            $funciones=['MAGISTRADO','COORDINADOR','SECRETARIO DE ESTUDIO Y CUENTA','PROYECTISTA','SECRETARIO AUXILIAR'];//LAS FUNCIONES DE LOS EMPELADOS
            //
            return view('personalsala.create',['users'=>$users,'salas'=>$salas,'funciones'=>$funciones]);
        }else{
            return view('errors.permisos');
        }    
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
        $personal= new personalSalaModel;
        $personal->id_sala=$request->get('sala');
        $personal->id_user=$request->get('user');
        $personal->funcion=$request->get('funcion');
        $personal->estado="ACTIVO";
        $personal->captura=$user->name." ".$user->apellido_p." ".$user->apellido_p;
        $personal->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","personalsala","'.$personal->id.'","'.base64_encode(json_encode($personal)).'"," ","El usuario realizo una asignación de personal-sala")');  
      

        return Redirect::to('/personalSala');
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
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->tipo_usuario == "ADMINISTRADOR"){
          
            $users=DB::table('users')->where('estado','=','ACTIVO')->get();
            $personal=personalSalaModel::findOrfail($id);
            $salas=DB::table('salamagistrado')->where('estado','=','ACTIVO')->get();
            $funciones=['MAGISTRADO','COORDINADOR','SECRETARIO DE ESTUDIO Y CUENTA','PROYECTISTA','SECRETARIO AUXILIAR'];//LAS FUNCIONES DE LOS EMPELADOS
            //

            return view('personalsala.edit',['personal'=>$personal,'users'=>$users,'salas'=>$salas,'funciones'=>$funciones]);
        }else{
            return view('errors.permisos');
        }    
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
        $personal=personalSalaModel::findOrfail($id);
        $personal_ant=personalSalaModel::findOrfail($id);
        $personal->id_sala=$request->get('sala');
        $personal->id_user=$request->get('user');
        $personal->funcion=$request->get('funcion');
        $personal->estado="ACTIVO";
        $personal->captura=$user->name." ".$user->apellido_p." ".$user->apellido_p;
        $personal->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","personalsala","'.$personal->id.'","'.base64_encode(json_encode($personal)).'","'.base64_encode(json_encode($personal_ant)).'","El usuario realizo cambios a la asignación de personal-sala")');  

        return Redirect::to('/personalSala');
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
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->tipo_usuario == "ADMINISTRADOR"){

            $personal=personalSalaModel::findOrfail($id);      
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","personalsala","'.$personal->id.'","'.base64_encode(json_encode($personal)).'"," ","El usuario elimino la asignación de personal-sala")');  
      
            $personal->delete();
            

            return Redirect::to('/personalSala');
        }else{
            return view('errors.permisos');
        }     
        
    }

    public function validar_sala(Request $request){
        if ($request->ajax()) { 
         $id=$request->get('user');
         $ida= DB::table('personalsala')
         ->join('salamagistrado','salamagistrado.id','=','personalsala.id_sala')
         ->where('id_user','=',$id)->select('personalsala.id_user','salamagistrado.num_sala')->first();
         return response()->json(['ida'=>$ida]);
        }
    }

    public function valida_magistrado(Request $request){
        if ($request->ajax()) {
         $id=$request->get('sala');    
         $salas= DB::table('personalsala')->where('id_sala','=',$id)
         ->where('funcion','=','MAGISTRADO')
         ->select('personalsala.funcion')->first();
         return response()->json(['salas'=>$salas]);
        }
    }
}

