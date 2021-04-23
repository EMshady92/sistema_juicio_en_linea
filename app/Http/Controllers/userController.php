<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Mail;
use App\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Hash;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
            $user=Auth::user();
            $tipo_usuario = Auth::user()->funcion;
            

            if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->tipo_usuario == "ADMINISTRADOR"){
                $users=DB::table('users')->get();

                return view('users.index',['users'=>$users]);
            }else{
                return view('errors.permisos');
            }      
        //
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
             
            $funciones=['MAGISTRADO','COORDINADOR','SECRETARIO DE ESTUDIO Y CUENTA','PROYECTISTA','SECRETARIO AUXILIAR','PERSONAL ADMINISTRATIVO','AUXILIAR DE SISTEMAS','CORDINADOR DE SISTEMAS'];//LAS FUNCIONES DE LOS EMPELADOS
            $tiposUsuario=['ADMINISTRADOR','BASICO','INVITADO'];
            return view('users.create',['funciones'=>$funciones,'tiposUsuario'=>$tiposUsuario]);
          }else{
            return view('errors.permisos');
          } 
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
        $user_aux=Auth::user();        

        $user=new User;
        $user->email=$request->get('email');
        $user->name=$request->get('nombre');
        $user->apellido_p=$request->get('apellido_p');
        $user->apellido_m=$request->get('apellido_m');
        $user->name=$request->get('nombre');
        $user->password=bcrypt($request->get('password'));
        $user->funcion=$request->get('funcion');
        $user->tipo_usuario=$request->get('tipo_usuario');
        $user->estado="ACTIVO";
        $user->captura=$user_aux->name." ".$user_aux->apellido_p." ".$user_aux->apellido_m;
        $user->save();
        DB::select('CALL InsertarMovimiento ("'.$user_aux->id.'","insert","users","'.$user->id.'"," "," ","El usuario creo un nuevo usuario")'); 
        
        return Redirect::to('/users');


   
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
          
        $usuario=User::findOrFail($id);
        $funciones=['MAGISTRADO','COORDINADOR','SECRETARIO DE ESTUDIO Y CUENTA','PROYECTISTA','SECRETARIO AUXILIAR','PERSONAL ADMINISTRATIVO','AUXILIAR DE SISTEMAS','CORDINADOR DE SISTEMAS'];//LAS FUNCIONES DE LOS EMPELADOS
        $tiposUsuario=['ADMINISTRADOR','BASICO','INVITADO'];
        return view("users.edit",["usuario"=>$usuario,'funciones'=>$funciones,'tiposUsuario'=>$tiposUsuario]);
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
        $user_aux=Auth::user();        

        $user=User::findOrFail($id);
        $user->email=$request->get('email');
        $user->name=$request->get('nombre');
        $user->apellido_p=$request->get('apellido_p');
        $user->apellido_m=$request->get('apellido_m');
        $user->name=$request->get('nombre');
        $user->password=bcrypt($request->get('password'));
        $user->funcion=$request->get('funcion');
        $user->tipo_usuario=$request->get('tipo_usuario');
        $user->estado="ACTIVO";
        $user->captura=$user_aux->name." ".$user_aux->apellido_p." ".$user_aux->apellido_m;
        $user->update();
        DB::select('CALL InsertarMovimiento ("'.$user_aux->id.'","insert","users","'.$user->id.'"," "," ","El usuario edito los datos del usuario")'); 
        
        
        return Redirect::to('/users');
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
    
    public function validaPassword(Request $request){
          if ($request->ajax()) {
            $rules = [
            'mypassword' => 'required',
        ];
        
         $messages = [
            'mypassword.required' => 'El campo es requerido',
        ];
        
         $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()){
            //return redirect('firmarDocumento')->withErrors($validator
             $resp=0;
        }else{
            if (Hash::check($request->mypassword, Auth::user()->password)){
               $resp=1;
                //return redirect('user')->with('status', 'Password cambiado con éxito');
            }else{
               // return redirect('user/password')->with('message', 'Credenciales incorrectas');
                $resp=0;
            }
        }
       return response()->json(['resp'=>$resp]);
       //return response()->json($demandado->toArray());
        
    }
    }

    public function historial_usuarios(){
        $user=Auth::user();        
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->tipo_usuario == "ADMINISTRADOR"){
        $historial=DB::table('historial_usuarios')->join('users','users.id','=','historial_usuarios.id_user')->select('historial_usuarios.*','users.name','users.apellido_p',
        'users.apellido_m','users.funcion','users.estado as estado_user','users.email','users.sexo','users.id as id_user','users.created_at as fecha_registro')->get();

        return view('users.historial_usuarios',['historial'=>$historial]);
        }else{
            return view('errors.permisos');

        }

    }

    //FUNCION PARA TRAER LOS REGISTROS ALTERADOS DEL HISTORIAL
    public function traer_tabla_historial(Request $request){
        if ($request->ajax()) {


            return response()->json(['resp'=>$resp]);
            //return response()->json($demandado->toArray());
             
         }

    }

    public function historial_usuario($id){
        $user=Auth::user();        
        if($user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->tipo_usuario == "ADMINISTRADOR" || $user->id == $id){
        
        $user=DB::table('users')->where('id','=',$id)->first();

        $historial=DB::table('historial_usuarios')
        ->join('users','users.id','=','historial_usuarios.id_user')
        ->select('historial_usuarios.*','users.name','users.apellido_p',
        'users.apellido_m','users.funcion','users.estado as estado_user','users.email','users.sexo','users.created_at as fecha_registro')->where('users.id','=',$id)->get();
        $sala=DB::table('personalsala')->join('salamagistrado','salamagistrado.id','=','personalsala.id_sala')
        ->where('personalsala.id_user','=',$id)->select('personalsala.*','salamagistrado.num_sala')->first();
        $firma=DB::table('firmaelectronica')->where('id_usuario','=',$id)->first();
        $asignaciones_ext=DB::table('expedientesala')->join('expedientes','expedientes.id','=','expedientesala.id_expediente')
        ->where('expedientesala.id_asignacion','=',$id)
        ->select('expedientes.*')->get();
        $asignaciones_firma=DB::table('asignaciones_firma')->where('id_user','=',$id)->get();
        $emails=DB::table('email_users')->where('id_personas','=',$id)->get();    
        return view('users.historial_usuario',['user'=>$user,'historial'=>$historial,'sala'=>$sala,'firma'=>$firma,'asignaciones_ext'=>$asignaciones_ext,
        'asignaciones_firma'=>$asignaciones_firma,'emails'=>$emails]);
        }else{
            return view('errors.permisos');

        }

    }
    
    
}
