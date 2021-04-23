<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class consultaFirmasController extends Controller
{ 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function validarDocumento($base64){ 
    
           if($base64 <> null){
           $doc= DB::table('firmasaplicadas')->where('clave_alfanumerica','=',$base64)->first();
           if($doc == null){
           $doc="";
           $revocado="";
           }else{
            $revocado=DB::table('documentos_revocados')->where('id_firma','=',$doc->id)->first(); 
            $doc= DB::table('firmasaplicadas')->where('clave_alfanumerica','=',$base64)->first()->xml;
               
           }               
           }else{
           $doc="";
           $base64="";
           $revocado="";
           }
           
        return view('firmaDocumentos.validaDocumento',['revocado'=>$revocado,'doc'=>$doc,'base64'=>$base64]);
           
       }
       
       public function validarDocumentos(request $request){
           
           $search=$request->get('clave_alfa');
           if($search <> null){
           $doc= DB::table('firmasaplicadas')->where('clave_alfanumerica','=',$search)->first();
           $base64=$search;
           if($doc == null){
           $doc="";
           $revocado="";
           }else{
            $revocado=DB::table('documentos_revocados')->where('id_firma','=',$doc->id)->first(); 
                $doc= DB::table('firmasaplicadas')->where('clave_alfanumerica','=',$search)->first()->xml;
           }
               
           }else{
           $doc="";
           $base64="";
           $revocado="";
           }
       
           
        return view('firmaDocumentos.validaDocumento',['revocado'=>$revocado,'doc'=>$doc,'base64'=>$base64]);
           
       }


    public function index()
    {
        //
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
