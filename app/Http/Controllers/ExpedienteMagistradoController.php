<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;
use App\expedienteSalaModel;
use App\ExpedientesModel;
use Illuminate\Support\Facades\Redirect;

class ExpedienteMagistradoController extends Controller
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
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR"  || $user->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || $user->funcion == "PROYECTISTA" || $user->funcion == "SECRETARIO AUXILIAR" || $user->funcion == "ADMINISTRADOR"){
        $expedientes=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')->where('personalsala.funcion','=','MAGISTRADO')->select('expedientesala.id as id_expediente_sala','salamagistrado.num_sala','users.name','users.apellido_p','users.apellido_m','expedientes.*')->get();
        $mis_expedientes=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')->where('personalsala.id_user','=',$user->id)->select('salamagistrado.num_sala','users.name','users.apellido_p','users.apellido_m','expedientes.*')->get();
        $num=count($mis_expedientes);
        $total_expedientes=count($expedientes);
        setlocale(LC_ALL, 'es_ES');
        $mes=date("m");
        $date = date('Y-m-d');
        $year = date("Y");


        //resto 1 a単o
        $year_menos=date("Y",strtotime($date."- 1 year"));
        $mes_menos=date("m",strtotime($date."- 1 month"));

        $mes_letra = strftime("%B", strtotime($date));

        $expedientes_mes=count(DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->whereMonth('fecha','=',$mes)->select('expedientes.*')->get());
     
        $expedientes_year=count(DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->whereYear('fecha','=',$year)->select('expedientes.*')->get());

        $expedientes_year_menos=count(DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->whereYear('fecha','=',$year_menos)->select('expedientes.*')->get());

        $expedientes_mes_menos=count(DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->whereMonth('fecha','=',$mes_menos)->select('expedientes.*')->get());
        $personas=DB::table('salamagistrado')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('personalsala.funcion','=','SECRETARIO AUXILIAR')->select('users.*')->get();
        return view('magistradoExpedientes.index',['expedientes_mes_menos'=>$expedientes_mes_menos,'expedientes_year_menos'=>$expedientes_year_menos,'total_expedientes'=>$total_expedientes,'expedientes_year'=>$expedientes_year,'year'=>$year,"mes_letra"=>$mes_letra,'expedientes_mes'=>$expedientes_mes,'mis_expedientes'=>$mis_expedientes,'num'=>$num,'expedientes'=>$expedientes,'user'=>$user,'personas'=>$personas]);

        }else{
            return view('errors.permisos')->with('errors', 'Solo los miembros de una sala pueden acceder a este modulo');
           

        }

        //
    }

    public function misExpedientes(){ 
        $user=Auth::user();
        
        $funcion=DB::table('personalsala')->join('users','users.id','=','personalsala.id_user')
        ->where('users.id','=',$user->id)
        ->select('personalsala.funcion')->first();

        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR"  || $user->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || $user->funcion == "PROYECTISTA" || $user->funcion == "SECRETARIO AUXILIAR" || $user->funcion == "ADMINISTRADOR"){
       
        $sala=DB::table('salamagistrado')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('users.id','=',$user->id)->select('salamagistrado.*')->first();

        $expedientes=DB::table('expedientesala')->join('expedientes','expedientes.id','=','expedientesala.id_expediente')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('users.id','=',$user->id)->select('expedientesala.id as id_expediente_sala','salamagistrado.num_sala','users.name','users.apellido_p','users.apellido_m','expedientes.*')->get();
       
        //$personas=DB::table('users')->where('estado','=','ACTIVO')->get();
        //CARGAMOS TODAS LAS PERSONAS DE LA SALA       
       
        $expedientes_pedientes=count(DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('expedientes.estado','=','POR_ASIGNAR')->where('users.id','=',$user->id)->select('expedientes.*')->get());

        $expedientes_validar=count(DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('expedientes.estado','=','POR_VALIDAR')->where('users.id','=',$user->id)->select('expedientes.*')->get());

        $acuerdos_por_generar=DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('expedientes.estado','=','VALIDADO')->where('users.id','=',$user->id)->select('expedientes.*','users.name','users.apellido_p','users.apellido_m')->get();
        $acuerdos_generar=count($acuerdos_por_generar);

        $acuerdos_revisar=count(DB::table('expedientesala')->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('expedientes.estado','=','ACUERDO_GENERADO')->where('users.id','=',$user->id)->select('expedientes.*')->get());
 
        $verifica_sala = isset($sala->num_sala); //verifica si a sido asignado a una sala
        if($verifica_sala == 1){ //si es verdadero, mando la variabl personas con la sala asignada
            $personas=DB::table('salamagistrado')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
            ->where('num_sala','=',$sala->num_sala)->where('personalsala.funcion','=','SECRETARIO AUXILIAR')->select('users.*')->get();    
            return view('magistradoExpedientes.misExpedientes',['verifica_sala'=>$verifica_sala,'acuerdos_por_generar'=>$acuerdos_por_generar,'sala'=>$sala,'acuerdos_revisar'=>$acuerdos_revisar,'acuerdos_generar'=>$acuerdos_generar,'expedientes_validar'=>$expedientes_validar,'expedientes_pedientes'=>$expedientes_pedientes,'personas'=>$personas,'expedientes'=>$expedientes,'funcion'=>$funcion]);
        }else{ // si no ha sido asignado a alguna sala regresa falso y no mando expedientes asignados
            $personas=DB::table('salamagistrado')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
            ->where('personalsala.funcion','=','SECRETARIO AUXILIAR')->select('users.*')->get();    
            return view('magistradoExpedientes.misExpedientes',['verifica_sala'=>$verifica_sala,'acuerdos_por_generar'=>$acuerdos_por_generar,'sala'=>$sala,'acuerdos_revisar'=>$acuerdos_revisar,'acuerdos_generar'=>$acuerdos_generar,'expedientes_validar'=>$expedientes_validar,'expedientes_pedientes'=>$expedientes_pedientes,'personas'=>$personas,'expedientes'=>$expedientes,'funcion'=>$funcion]);
      
        }

        }else{
            return view('errors.permisos')->with('errors', 'Solo los Magistrados o Coordinadores pueden acceder a este modulo');
           

        }

    }

    public function asignarExpediente(Request $request,$id){
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR"  || $user->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || $user->funcion == "PROYECTISTA" || $user->funcion == "SECRETARIO AUXILIAR" || $user->funcion == "ADMINISTRADOR"){           
           
            $expediente=expedienteSalaModel::findOrFail($id);
            $expediente_ant=expedienteSalaModel::findOrFail($id);
            $expediente->id_asignacion=$request->get('personal'.$id);
            $expediente->observaciones=$request->get('observaciones'.$id);
            $expediente->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
            $expediente->update();
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","expedientesala","'.$expediente->id.'","'.base64_encode(json_encode($expediente)).'","'.base64_encode(json_encode($expediente_ant)).'","El usuario asigno el expediente.")');  


            $expedientes=ExpedientesModel::findOrFail($expediente->id_expediente);
            $expedientes_ant=ExpedientesModel::findOrFail($expediente->id_expediente);
            $expedientes->ubicacion="SALA_MAGISTRADO";
            $expedientes->estado="POR_VALIDAR";
            $expedientes->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
            $expedientes->update();
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","expedientes","'.$expedientes->id.'","'.base64_encode(json_encode($expedientes)).'","'.base64_encode(json_encode($expedientes_ant)).'","El usuario actualizo el estado del expediente.")');  



            return Redirect::to('misExpedientes');
           // return response()->json(['expediente'=>$expediente,'id'=>$id]);

            
        }

    }

    public function editarExpediente(Request $request,$id){
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR"  || $user->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || $user->funcion == "PROYECTISTA" || $user->funcion == "SECRETARIO AUXILIAR" || $user->funcion == "ADMINISTRADOR"){           
           
            $expediente=expedienteSalaModel::findOrFail($id);
            $expediente_ant=expedienteSalaModel::findOrFail($id);
            $expediente->id_asignacion=$request->get('personal'.$id);
            $expediente->observaciones=$request->get('observaciones'.$id);
            $expediente->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
            $expediente->update();

            DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","expedientesala","'.$expediente->id.'","'.base64_encode(json_encode($expediente)).'","'.base64_encode(json_encode($expediente_ant)).'","El usuario modifico la asignacion expediente-sala.")');  


            $expedientes=ExpedientesModel::findOrFail($expediente->id_expediente);
            $expedientes_ant=ExpedientesModel::findOrFail($expediente->id_expediente);
            $expedientes->ubicacion="SALA_MAGISTRADO";
            $expedientes->estado="POR_VALIDAR";
            $expedientes->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
            $expedientes->update();
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","expedientes","'.$expedientes->id.'","'.base64_encode(json_encode($expedientes)).'","'.base64_encode(json_encode($expedientes_ant)).'","El usuario actualizo el estado del expediente.")');  


            

            return Redirect::back();
           // return response()->json(['expediente'=>$expediente,'id'=>$id]);

            
        }

    }

    //FUNCION PARA VALIDAR UN EXPEDIENTE
    public function validarExpediente(Request $request,$id){
        $user=Auth::user();
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR"  || $user->funcion == "SECRETARIO DE ESTUDIO Y CUENTA" || $user->funcion == "PROYECTISTA" || $user->funcion == "SECRETARIO AUXILIAR" || $user->funcion == "ADMINISTRADOR"){  
                      
            $expedientes=ExpedientesModel::findOrFail($id);
            $expedientes_ant=ExpedientesModel::findOrFail($id);
            $expedientes->ubicacion="SALA_MAGISTRADO";
            $expedientes->estado="VALIDADO";
            $expedientes->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
            $expedientes->update();
            DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","expedientes","'.$expedientes->id.'","'.base64_encode(json_encode($expedientes)).'","'.base64_encode(json_encode($expedientes_ant)).'","El usuario valido el expediente.")');  

            return Redirect::back();
                    
        }
    }

    public function asignaciones(){
        $user=Auth::user();

        $funcion=DB::table('personalsala')->join('users','users.id','=','personalsala.id_user')
        ->where('users.id','=',$user->id)
        ->select('personalsala.funcion')->first();

        if($funcion == null &&   $user->funcion == "ADMINISTRADOR"){
            $funcion=$user;
            
        }

        $expedientesa=DB::table('expedientesala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('personalsala','personalsala.id_sala','=','salamagistrado.id')
        ->join('users','users.id','=','personalsala.id_user')
        ->where('users.id','=',$user->id)
        ->select('expedientesala.id as id_expediente_sala','salamagistrado.num_sala','users.name','users.apellido_p','users.apellido_m','expedientes.*')->get();
       
        $expedientes=DB::table('expedientesala')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('users as us','us.id','=','expedientesala.id_asignacion')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->select('expedientesala.id as id_expediente_sala','us.name as name_asig','us.apellido_p as apellido_pasig','us.apellido_m as apellido_masig','salamagistrado.num_sala',
        'expedientes.*')->get();
        
        $mis_asignaciones=DB::table('expedientesala')
        ->where('expedientesala.id_asignacion','=',$user->id)
        ->select('expedientesala.*')->get();
        $num=count($mis_asignaciones);
  
        $sala=DB::table('salamagistrado')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
        ->where('users.id','=',$user->id)->select('salamagistrado.*')->first();

       $verifica_sala = isset($sala->num_sala); //verifica si a sido asignado a una sala
        if($verifica_sala == 1){ //si es verdadero, mando la variabl personas con la sala asignada
            $personas=DB::table('salamagistrado')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
            ->where('num_sala','=',$sala->num_sala)->where('personalsala.funcion','=','SECRETARIO AUXILIAR')->select('users.*')->get();
    
            
            return view('magistradoExpedientes.asignaciones',['verifica_sala'=>$verifica_sala,'personas'=>$personas,'num'=>$num,'expedientes'=>$expedientes,'sala'=>$sala,'expedientesa'=>$expedientes, 'funcion'=>$funcion]);
       
        }else{ // si no ha sido asignado a alguna sala regresa falso y no mando expedientes asignados
            $personas=DB::table('salamagistrado')->join('personalsala','personalsala.id_sala','=','salamagistrado.id')->join('users','users.id','=','personalsala.id_user')
            ->where('personalsala.funcion','=','SECRETARIO AUXILIAR')->select('users.*')->get();
    
            return view('magistradoExpedientes.asignaciones',['verifica_sala'=>$verifica_sala,'personas'=>$personas,'num'=>$num,'expedientes'=>$expedientes,'sala'=>$sala,'expedientesa'=>$expedientes, 'funcion'=>$funcion]);
       

        }
    }

    public function misAsignaciones(){
        $user=Auth::user();
        

        $expedientes=DB::table('expedientesala')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('users','users.id','=','expedientesala.id_asignacion')
        ->where('expedientesala.id_asignacion','=',$user->id)
        ->select('users.name as name_asig','users.apellido_p as apellido_pasig','users.apellido_m as apellido_masig','salamagistrado.num_sala','expedientes.*')->get();
       
        $mis_asignaciones=DB::table('expedientesala')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('users','users.id','=','expedientesala.id_asignacion')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->where('expedientesala.id_asignacion','=',$user->id)
        ->select('salamagistrado.num_sala','users.name','users.apellido_p','users.apellido_m','expedientes.*')->get();

       

        $acuerdos_correciones=DB::table('expedientesala')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('acuerdosgenarados','acuerdosgenarados.id_expediente','=','expedientes.id')
        ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->where('acuerdosgenarados.estado','=','ACUERDO_CON_CORRECCIONES')
        ->where('expedientesala.id_asignacion','=',$user->id)
        ->select('acuerdosgenarados.id as id_acuerdo','catalogo_tipos_acuerdos.tipo as tipo_acuerdo','acuerdosgenarados.num_folio','acuerdosgenarados.estado as estado_acuerdo','salamagistrado.num_sala','expedientes.*')->get();

        $acuerdos_correctos=DB::table('expedientesala')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->join('acuerdosgenarados','acuerdosgenarados.id_expediente','=','expedientes.id')
        ->join('catalogo_tipos_acuerdos','catalogo_tipos_acuerdos.id','=','acuerdosgenarados.id_tipo_acuerdo')
        ->where('expedientesala.id_asignacion','=',$user->id)
        ->where('acuerdosgenarados.estado','=','ACUERDO_CORRECTO')
        ->orwhere('acuerdosgenarados.estado','=','ACUERDO_CON_CORRECCIONES_APLICADAS')
        ->select('catalogo_tipos_acuerdos.tipo as tipo_acuerdo','acuerdosgenarados.num_folio','acuerdosgenarados.estado as estado_acuerdo','salamagistrado.num_sala','expedientes.*')->get();

        $acuerdos_pendientes=DB::table('expedientesala')
        ->join('salamagistrado','salamagistrado.id','=','expedientesala.id_sala')
        ->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->where('expedientesala.id_asignacion','=',$user->id)
        ->where('expedientes.estado','=','VALIDADO')
        ->select('salamagistrado.num_sala','expedientes.*')->get();

        $num=count($mis_asignaciones);
        $personas=DB::table('users')->where('estado','=','ACTIVO')->get();
        return view('magistradoExpedientes.misAsignaciones',
        ['acuerdos_pendientes'=>$acuerdos_pendientes,'acuerdos_correctos'=>$acuerdos_correctos,'acuerdos_correciones'=>$acuerdos_correciones,'personas'=>$personas,'num'=>$num,'expedientes'=>$expedientes]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //
    }
}