<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use DB;
use App\salaMagistradoModel;
use Illuminate\Support\Facades\Auth;

class salaMagistradoController extends Controller
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
          
        $magistrados= DB::table('salamagistrado')->where('estado','=','ACTIVO')->get();
        return view('salamagistrado.index',['magistrados'=>$magistrados]);
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
          
            $salas=['I','II','III'];
            return view('salamagistrado.create',['salas'=>$salas]);
        
        }else{
            return view('errors.permisos');
        }
    }

    //FUNCION PARA VALIDAR LA SALA O MAGISTRADO, SI YA ESTAN OCUPADOS
    public function validaSala(Request $request,$cr){
        if ($request->ajax()) { 
            if($cr == "sala"){
                $sala=$request->get('sala');
                $valida=DB::table('salamagistrado')->where('estado','=','ACTIVO')->where('num_sala','=',$sala)->first();
                $mensaje="La sala que intenta registrar, ya se encuentra asignada";
                var_dump($cr);
                return response()->json(['valida'=>$valida,'mensaje'=>$mensaje]);
            }else if($cr =="magistrado"){
                $magistrado= $request->get('magistrado');
                $valida=DB::table('salamagistrado')->where('estado','=','ACTIVO')->where('id_magistrado','=',$magistrado)
                ->first();
                $mensaje="El magistrado que intenta registrar, ya se encuentra asignado a otra sala";
                return response()->json(['valida'=>$valida,'mensaje'=>$mensaje]);
            }else if($cr =="coordinador"){
                $coordinador= $request->get('coordinador');
                $valida=DB::table('salamagistrado')->where('estado','=','ACTIVO')->where('id_cordinador','=',$coordinador)
                ->first();
                $mensaje="El coordinador que intenta registrar, ya se encuentra asignado a otra sala";
                return response()->json(['valida'=>$valida,'mensaje'=>$mensaje]);
            }else if($cr =="sec_estudios"){
                $sec_estudios_1= $request->get('sec_estudios_1');
                $sec_estudios_2= $request->get('sec_estudios_2');
                $valida=DB::table('salamagistrado')->where('estado','=','ACTIVO')->where('id_sec_est_cuen_1','=',$sec_estudios_1)
                ->orwhere('id_sec_est_cuen_1','=',$sec_estudios_2)->orwhere('id_sec_est_cuen_2','=',$sec_estudios_1)->orwhere('id_sec_est_cuen_2','=',$sec_estudios_2)
                ->first();
                $mensaje="El secretario de estudio y cuenta que intenta registrar, ya se encuentra asignado a otra sala";
                return response()->json(['valida'=>$valida,'mensaje'=>$mensaje]);
            }else if($cr =="proyectista"){
                $proyectista_1= $request->get('proyectista_1');
                $proyectista_2= $request->get('proyectista_2');
                $valida=DB::table('salamagistrado')->where('estado','=','ACTIVO')->where('id_proyectista_1','=',$proyectista_1)
                ->orwhere('id_proyectista_1','=',$proyectista_2)->orwhere('id_proyectista_2','=',$proyectista_1)->orwhere('id_proyectista_2','=',$proyectista_2)
                ->first();
                $mensaje="El proyectista que intenta registrar, ya se encuentra asignado a otra sala";
                return response()->json(['valida'=>$valida,'mensaje'=>$mensaje]);
            }else if($cr =="auxiliar"){
                $auxiliar_1= $request->get('auxiliar_1');
                $auxiliar_2= $request->get('auxiliar_2');
                $valida=DB::table('salamagistrado')->where('estado','=','ACTIVO')->where('auxiliar_sala_1','=',$auxiliar_1)
                ->orwhere('auxiliar_sala_1','=',$auxiliar_2)->orwhere('auxiliar_sala_2','=',$auxiliar_1)->orwhere('auxiliar_sala_2','=',$auxiliar_2)
                ->first();
                $mensaje="El secretario auxiliar que intenta registrar, ya se encuentra asignado a otra sala";
                return response()->json(['valida'=>$valida,'mensaje'=>$mensaje]);
            }                               
       
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
        $sala= new salaMagistradoModel;
        $sala->num_sala=$request->get('sala');      
        $sala->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
        $sala->estado="ACTIVO";
        $sala->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","salamagistrado","'.$sala->id.'","'.base64_encode(json_encode($sala)).'"," ","El usuario creo una nueva sala")');  
      

        return Redirect::to('/salasMagistrado');
       
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
        $personal_sala=DB::table('personalsala')->join('salamagistrado','salamagistrado.id','=','personalsala.id_sala')->join('users','users.id','=','personalsala.id_user')
        ->where('users.estado','=','ACTIVO')->where('salamagistrado.id','=',$id)->select('salamagistrado.num_sala','personalsala.*','users.id as id_user','users.name','users.apellido_p','users.apellido_m','users.email')->get();
        return view('salamagistrado.detalle',['personal_sala'=>$personal_sala]);
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
         
        $sala=salaMagistradoModel::findOrfail($id);      

        return view('salamagistrado.edit',['sala'=>$sala]);

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
        $sala=salaMagistradoModel::findOrfail($id);
        $sala_ant=salaMagistradoModel::findOrfail($id);
        $sala->num_sala=$request->get('sala');
        $sala->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
        $sala->estado="ACTIVO";
        $sala->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","salamagistrado","'.$sala->id.'","'.base64_encode(json_encode($sala)).'","'.base64_encode(json_encode($sala_ant)).'","El usuario modifico los datos de la sala")'); 

        return Redirect::to('/salasMagistrado');
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
         
            $sala=salaMagistradoModel::findOrfail($id);     
            $sala->estado="INACTIVO";
            $sala->update();
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","salamagistrado","'.$sala->id.'","'.base64_encode(json_encode($sala)).'"," ","El usuario inactivo una sala")');  

            return Redirect::to('/salasMagistrado');
            //
        }else{
            return view('errors.permisos');
        }    
    }
}
