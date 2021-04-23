<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\EmailUsersModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class EmailUsersController extends Controller
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
        //obtiene todos los emails activos de la base de datos 
        $emails=DB::table('email_users')
        ->join('personas','personas.id','=','email_users.id_personas')
        ->select('email_users.*','personas.nombre')
        ->get();
        return view('email_users.index',['emails'=>$emails]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $personas=DB::table('personas')->where('estado','=','ACTIVO')->orderBy('nombre','ASC')->get();
         $emails=DB::table('email_users')
        ->get();
        return view('email_users.create',['personas'=>$personas,'emails'=>$emails]);
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
        $email=new EmailUsersModel;
        $email->email=$request->get('email');
        $email->id_users=$request->get('id_users');
        $email->captura=$user->name;
        $email->estado="ACTIVO";
        $email->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","email_users","'.$email->id.'","'.base64_encode(json_encode($email)).'"," ","El usuario genero un nuevo email.")');  


        return Redirect::to('/email_users');
    }

    public function modal_personas(Request $request){
        if ($request->ajax()) {
            $user=Auth::user();
            $email=new EmailUsersModel;
            $email->email=$request->get('email');
            $email->id_personas=$request->get('id_personas');
            $email->captura=$user->name;
            $email->estado="ACTIVO";
            $email->save();
         // retorno de datos via json
         return response()->json(
            $email->toArray()
        );
    }
    //fin ajax

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ver_emails($id)
    {
       
        $personas=DB::table('personas')->where('personas.id','=',$id)->where('estado','=','ACTIVO')->orderBy('nombre','ASC')->first();
        $emails=DB::table('email_users')->where('email_users.id_personas','=',$id)->where('estado','=','ACTIVO')->select('email_users.*')->get();
       
        return view('email_users.ver_mails',['personas'=>$personas,'emails'=>$emails]);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function traer_emails($id)
    {
       
        $emails=DB::table('email_users')->where('email_users.id_personas','=',$id)->where('estado','=','ACTIVO')->select('email_users.*')->get();
        
       
        return response()->json(['emails'=>$emails]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_personas=DB::table('email_users')->where('email_users.id','=',$id)->select('id_personas')->first();
        $personas=DB::table('personas')->where('personas.id','=',$id_personas->id_personas)->where('estado','=','ACTIVO')->orderBy('nombre','ASC')->get();
        $emails_u=EmailUsersModel::findOrFail($id);
       
        return view('email_users.edit',['emails_u'=>$emails_u,'personas'=>$personas]);
        
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
        $email= EmailUsersModel::findOrFail($id);   
        $email_ant= EmailUsersModel::findOrFail($id);      
        $email->email=$request->get('email');
        $email->id_users=$request->get('id_users');
        $email->captura=$user->name;
        $email->estado="ACTIVO";
        $email->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","email_users","'.$email->id.'","'.base64_encode(json_encode($email)).'","'.base64_encode(json_encode($email_ant)).'","El usuario actualizo los datos del email.")');  


        return Redirect::to('email_users')->with('errors','Registro actualizado correctamente');
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
        $email=EmailUsersModel::findOrFail($id);
        $email->captura=$user->name;
        $email->estado="INACTIVO";       
        $email->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","email_users","'.$email->id.'","'.base64_encode(json_encode($email)).'"," ","El usuario inactivo el email del usuario.")');  

    }

    public function valida_email_user(Request $request){
        if ($request->ajax()) { 
         $email=$request->get('email');
         $user= DB::table('email_users')->where('email','=',$email)->select('email_users.email')->first();
         return response()->json(['user'=>$user]);
        }
    }
}
