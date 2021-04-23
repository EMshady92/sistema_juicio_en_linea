<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\firmaElectronicaModel;
use App\firmasAplicadasModel;
use App\asignacionFirmasModel;
use Illuminate\Support\Facades\Auth;
use Crypt;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Redirect;
use Doc2Txt\Doc2Txt;
use WordPHP\WordPHP;
use \PDF;
use DNS2D;
use ZipArchive;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Storage;
use Dompdf\FontMetrics;


class firmaElectronicaController extends Controller

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
      if($user->funcion == "ADMINISTRADOR"){
        $firmas=DB::table('firmaelectronica')->join('users','users.id','=','firmaelectronica.id_usuario')
        ->select('firmaelectronica.*','users.name','users.email','users.estado',
        'users.funcion','users.tipo_usuario')->get();
        return view('firmasElectronicas.index',['firmas'=>$firmas]);
      }else{
        return view('errors.permisos');
      }  
    }

    

    public function autofirmado(){
        $dn = array(
    "countryName" => "MX",
    "stateOrProvinceName" => "Zacatecas",
    "localityName" => "Guadalupe",
    "organizationName" => "Tribunal de Justicia Administrativa del Estado de Zacatecas",
    "organizationalUnitName" => "Secretaría General de Acuerdos",
    "commonName" => "Tribunal de Justicia Administrativa del Estado de Zacatecas",
    "emailAddress" => "admin@sitzac.org.mx"
);
          $config = array('config' => 'ssl/openssl.cnf',
        'encrypt_key' => true,
        "private_key_bits" => 4096,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
        'digest_alg' => 'sha512'
        );
        $req_key = openssl_pkey_new($config);
        //$config = array("config" => "ssl/openssl.cnf");    
        if(openssl_pkey_export ($req_key, $out_key)) {
        $dn = array(
                 "countryName" => "MX",
    "stateOrProvinceName" => "Zacatecas",
    "localityName" => "Guadalupe",
    "organizationName" => "Tribunal de Justicia Administrativa del Estado de Zacatecas",
    "organizationalUnitName" => "Secretaría General de Acuerdos",
    "commonName" => "Tribunal de Justicia Administrativa del Estado de Zacatecas",
    "emailAddress" => "admin@sitzac.org.mx"
                );
        $req_csr  = openssl_csr_new ($dn, $req_key);
        $req_cert = openssl_csr_sign($req_csr, null, $req_key, 730,array('digest_alg'=>'sha256'));
        if(openssl_x509_export ($req_cert, $out_cert)) {
openssl_x509_export_to_file($out_cert, "ssl/cert/admin@sitzac.org.mx.cer");
openssl_pkey_export_to_file($out_key, "ssl/key/admin@sitzac.org.mx.key");
$a_key = openssl_pkey_get_details($req_key);
$ClavePublica=$a_key["key"];
file_put_contents("ssl/key/admin@sitzac.org.mx-Pub.key",$ClavePublica);}
}
// Mostrar cualquier error que ocurra
while (($e = openssl_error_string()) !== false) {
    echo $e . "\n";
}
    }



    public function misFirmas()
    {
      $user=Auth::user();
      if($user->funcion == "ADMINISTRADOR" || $user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR" || $user->funcion == "SECRETARIA GENERAL DE ACUERDOS"){
        $firmas=DB::table('firmasaplicadas')->join('firmaelectronica','firmaelectronica.id','=','firmasaplicadas.id_firma')
        ->join('users','users.id','=','firmaelectronica.id_usuario')
        ->where('users.id','=',$user->id)
        ->select('firmasaplicadas.*')->get();
        $total_asignadas=count(DB::table('asignaciones_firma')->where('id_user','=',$user->id)->get());
        $total_pendientes=count(DB::table('asignaciones_firma')->where('id_user','=',$user->id)->where('estado','=','PENDIENTE')->get());
        $total_firmas=count(DB::table('asignaciones_firma')->where('id_user','=',$user->id)->where('estado','=','FIRMADO')->get());
        return view('firmaDocumentos.misFirmas',['firmas'=>$firmas,'total_asignadas'=>$total_asignadas,'total_pendientes'=>$total_pendientes,'total_firmas'=>$total_firmas]);
      }  else{
        return view('errors.permisos');
      }        
    }


    public function firmasEmitidas(){
      $user=Auth::user();
      if($user->funcion == "ADMINISTRADOR" || $user->funcion == "MAGISTRADO" || $user->funcion == "COORDINADOR"){
        $firmas=DB::table('firmasaplicadas')->join('firmaelectronica','firmaelectronica.id','=','firmasaplicadas.id_firma')
        ->join('users','users.id','=','firmaelectronica.id_usuario')       
        ->select('firmasaplicadas.*')->get();
        return view('firmaDocumentos.firmasEmitidas',['firmas'=>$firmas]);
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
        $usuarios=DB::table('users')->where('estado','=','ACTIVO')->get();
        return view('firmasElectronicas.create',['usuarios'=>$usuarios]);
     }



    public function validaFirma(Request $request){

        if ($request->ajax()) { 

        $user=$request->get('usuario');

        $usuario=DB::table('firmaelectronica')->where('id_usuario','=',$user)->first();

        return response()->json(['usuario'=>$usuario]);

          }

    }

        //



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {
         $user=Auth::user();
        $password=$request->get('password');
        $usuario=DB::table('users')->where('id','=',$request->get('usuario'))->first();
        $serial = DB::table('firmaelectronica')->orderBy('serial', 'desc')->first();
        if($serial == null){
        $serial="000001";
        }else{
            $serial=intval($serial->serial+1);
            $serial= str_pad($serial, 0, "0", STR_PAD_LEFT);           
        }
          $config = array('config' => 'ssl/openssl.cnf',
        'encrypt_key' => true,
        "private_key_bits" => 4096,
        'private_key_type' => OPENSSL_KEYTYPE_RSA,
        'digest_alg' => 'sha256'
        );
       // $CA_CERT = "ssl/cert/SIJEL.cer";
        //$CA_KEY  = "ssl/key/SIJEL.key";
         $CA_CERT = "ssl/cert/admin@sitzac.org.mx.cer";
         $CA_KEY  = "ssl/key/admin@sitzac.org.mx.key";
        $req_key = openssl_pkey_new($config);
        //$config = array("config" => "ssl/openssl.cnf");
      $name=$usuario->name." ".$usuario->apellido_p." ".$usuario->apellido_m;
        if(openssl_pkey_export ($req_key, $out_key)) {
        $dn = array(
            "countryName" => "MX",
           "stateOrProvinceName" => "Zacatecas",
           "localityName" => "Guadalupe",
           "organizationName" => "Tribunal de Justicia Administrativa",
           "organizationalUnitName" => "Secretaría General de Acuerdos",
           "commonName" => $name,
           "emailAddress" => $usuario->email
                );
        $req_csr  = openssl_csr_new ($dn, $req_key);
        $req_cert = openssl_csr_sign($req_csr, "file://$CA_CERT", "file://$CA_KEY", 730,array('digest_alg'=>'sha256'),$serial);
        if(openssl_x509_export ($req_cert, $out_cert)) {
                     $fecha=date("m-d-y");  
openssl_x509_export_to_file($out_cert, "ssl/cert/$usuario->email-$fecha.cer");
openssl_pkey_export_to_file($out_key, "ssl/key/$usuario->email-$fecha.key");
$a_key = openssl_pkey_get_details($req_key);
$ClavePublica=$a_key["key"];
file_put_contents("ssl/key/$usuario->email-$fecha-Pub.key",$ClavePublica);
        $firma = new firmaElectronicaModel;
          $firma->fill([
        'password' => Crypt::encrypt($request->password),
       'certificado'=>$out_cert,
       'clave_privada'=>$out_key,
       'clave_publica'=>$out_key,
       'id_usuario'=>$usuario->id,
       'serial'=>$serial,
       'captura'=>$user->name,
        'cert'=>"$usuario->email-$fecha.cer",
        'llave'=>"$usuario->email-$fecha.key",
         'llave_publica'=>"$usuario->email-$fecha.-Pub.key"
       ]);
      // $firma->password = Crypt::encrypt($request->password);
       //$firma->certificado=$out_cert;
       //$firma->clave_privada=$out_key;
     //  $firma->id_usuario=$usuario->id;
      // $firma->serial=$serial;
       //$firma->captura=$user->name;
       // $firma->cert="$usuario->email-$fecha.cer";
        //$firma->llave="$usuario->email-$fecha.key";
       //  $firma->password= Crypt::encrypt($request->get('password'));
       if( $firma->save()){
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","firmaelectronica","'.$firma->id.'","'.base64_encode(json_encode($firma)).'"," ","El usuario creo una nueva firma electronica ")');  

          return view('firmasElectronicas.detalle',['usuario'=>$usuario,'firma'=>$firma,'out_key'=>$out_key,'out_key'=>$out_key]);
        //print "<h1>Certificado X509</h1><pre>$CadCertificado</pre><h1>Clave privada</h1><pre>$CadClave</pre";
       }

        // Mostrar cualquier error que ocurra
        while (($e = openssl_error_string()) !== false) {
            echo $e . "\n";
        }
                echo "$out_key\n";
                echo "$out_cert\n";
                }
        else    echo "Failed Cert\n";
        }
else            echo "FailedKey\n";

    }

    /**

     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $firma=DB::table('firmasaplicadas')->join('firmaelectronica','firmaelectronica.id','=','firmasaplicadas.id_firma')
      ->join('users','users.id','=','firmaelectronica.id_usuario')
      ->where('firmasaplicadas.id','=',$id)
      ->select('firmasaplicadas.*','firmaelectronica.cert')->first();
      //$certificado=$request->file('certificado');
      //$firma=$request->file('firma');
      $pub_key = openssl_pkey_get_public(file_get_contents('ssl/cert/'.$firma->cert));
      $keyData = openssl_pkey_get_details($pub_key);
      $key_public=$keyData['key'];
      $xml = file_get_contents('FIRMASEMITIDAS/XML/'.$firma->xml);
      $firma_aux = file_get_contents('FIRMASEMITIDAS/FIRMA/'.$firma->firma_ruta);
     // $xml = simplexml_load_file('//FIRMASEMITIDAS/XML/'.$firma->xml);
     // $xml = file_get_contents('FIRMASEMITIDAS/XML/'.$firma->xml);
      if (openssl_verify($xml, $firma_aux, $key_public, 'sha256WithRSAEncryption') === 1) {
        // $firma=DB::table('firmasaplicadas')->where('firma','=',$firma)->first();
        //echo 'la firma es valida y los datos son confiables';
        return view('firmaDocumentos.detalleFirma',['firma'=>$firma]);
        } else {
             return Redirect::to('validarFirma')->with('errors','La firma es invalida y/o los datos fueron alterados');
       // echo 'la firma es invalida y/o los datos fueron alterados';->with('errors', 'Mostrando datos del expediente:'.$expediente->num_expediente);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)

    {
         // Se crea el par de claves
    $Claves = openssl_pkey_new();
    // Se guarda la clave pública en un archivo
   $Datos = openssl_pkey_get_details($Claves);
   file_put_contents('/ssl/key', $Datos['key']);
   openssl_pkey_free($Claves); // Liberación de las claves
   // Recuperación exclusivamente de la clave pública
   $ClavePublica = openssl_pkey_get_public('file:///ssl/key/miclave.pub');
   if($ClavePublica)
     print 'Clave recuperada satisfactoriamente';
   else
     print ' Fallo al intentar leer la clave';
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
        // traer las claves públicas para nuestros destinatarios, y prepararlas
$fp = fopen("/src/openssl-0.9.6/demos/maurice/cert.pem", "r");
$cert = fread($fp, 8192);
fclose($fp);
$pk1 = openssl_get_publickey($cert);
// Repetir para el segundo destinatario
$fp = fopen("/src/openssl-0.9.6/demos/sign/cert.pem", "r");
$cert = fread($fp, 8192);
fclose($fp);
$pk2 = openssl_get_publickey($cert);
// sellar el mensaje, sólo los propietarios de $pk1 y $pk2 pueden desencriptar $sealed
// con las claves $ekeys[0] y $ekeys[1] respectivamente.
openssl_seal($data, $sealed, $ekeys, array($pk1, $pk2));
// liberar las claves de la memoria
openssl_free_key($pk1);
openssl_free_key($pk2);
        //
    }

public function validarFirma(){
  return view('firmaDocumentos.validaFirma');
}


public function mostrarFirma(request $request){
  $certificado=$request->file('certificado');
  $firma=$request->file('firma');
  $xml=$request->file('xml');
  $pass=$request->get('password');
  $pub_key = openssl_pkey_get_public(file_get_contents($certificado));
  $keyData = openssl_pkey_get_details($pub_key);
  $key_public=$keyData['key'];
  $firma = file_get_contents($firma);
  $xml = file_get_contents($xml);
  if (openssl_verify($xml, $firma, $key_public, 'sha256WithRSAEncryption') === 1) {

     $firma=DB::table('firmasaplicadas')->where('firma','=',$firma)->first();
    //echo 'la firma es valida y los datos son confiables';
    return view('firmaDocumentos.detalleFirma',['firma'=>$firma],['successMsg'=>'Firma validada correctamente']);
    } else {

         return Redirect::to('validarFirma')->with('errors','La firma es invalida y/o los datos fueron alterados');

   // echo 'la firma es invalida y/o los datos fueron alterados';->with('errors', 'Mostrando datos del expediente:'.$expediente->num_expediente);

    }

}



public function firmarDocumento(){
    $user=Auth::user();
    $tipo_juicio=DB::table('tipos_juicios')->where('estado','=','ACTIVO')->get();
    $tipo_documentos=DB::table('tipodocumento')->where('estado','=','ACTIVO')->get();
    $tipos_acuerdos=DB::table('catalogo_tipos_acuerdos')->where('estado','=','ACTIVO')->get();
    $tipo_exp=['RAG','NULIDAD'];
    $users=DB::table('users')->join('firmaelectronica','firmaelectronica.id_usuario','=','users.id')->where('users.estado','=','ACTIVO')->orderBy('users.funcion','ASC')->select('users.*')->get();
    $proyectistas=DB::table('users')->where('estado','=','ACTIVO')->where('funcion','=','PROYECTISTA')->orwhere('funcion','=','SECRETARIO AUXILIAR')->orwhere('funcion','=','SECRETARIA GENERAL DE ACUERDO')->get();
    $salas=DB::table('salamagistrado')->where('estado','=','ACTIVO')->get();
  return view('firmaDocumentos.firmarDocumento',['proyectistas'=>$proyectistas,'tipos_acuerdos'=>$tipos_acuerdos,'salas'=>$salas,'users'=>$users,'tipo_documentos'=>$tipo_documentos,'tipo_juicio'=>$tipo_juicio,'tipo_exp'=>$tipo_exp]);
}




public function guardardocFirmado(request $request){
  $user=Auth::user();
  $tipo_doc=$request->get('tipoDocumento');
  $tipo_juicio=$request->get('tipoJuicio');
  $tipo_expediente=$request->get('tipoExpediente');
  $num_exp=$request->get('num_exp');
  $proyectista=$request->get('proyectista');
  $ponente=$request->get('ponente');
  $sala=$request->get('sala');
  $sala=DB::table('salamagistrado')->where('id','=',$sala)->first();
  $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  
    //GENERA LA CLAVE ALFANUMERICA PARA LA ASIGNACION
    for($a=0; $a < 100; $a++){
    $clave_alfa_asig= substr(str_shuffle($permitted_chars), 0, 30);
      $valida_clave=DB::table('asignaciones_firma')->where('clave_alfanumerica','==',$clave_alfa_asig)->get();
       if($valida_clave == null){
           $clave_alfa_asig=$clave_alfa_asig;
           break;
       }
   }
   
  if($request->hasFile('doc')){
    $documento=$request->file('doc');
    $path_info = pathinfo($documento->getClientoriginalName());
    $extension = $path_info['extension']; // "bill"
    //print_r($tabla->archivo);

    $nombre_doc="Documento_Previo_Firma_Clave-".$clave_alfa_asig.".".$extension;          
    $documento->move('public/DOCUMENTOSPARAFIRMA/',$nombre_doc);
  }
  
    //CONVIERTE EL DOCUMENTO EN TEXTO PLANO
    //$docObj = new Doc2Txt("public/DOCUMENTOSPARAFIRMA/".$nombre_doc);
    //$docObj = new Doc2Txt("test.doc");
    //$txt = $docObj->convertToText();
    $txt="";
     //GENERA EL NUMERO DE ASIGNACION
     $num_asignacion=DB::table('asignaciones_firma')->orderBy('num_asignacion','DESC')->first();
     if($num_asignacion <> null){       
         $num_asignacion=intval($num_asignacion->num_asignacion)+1;
     }else{
         $num_asignacion=1;
     }
     
 $tabla = $request->get('array');
  if($tabla){
        foreach($tabla as $_aux){
        $elements = explode(",", $_aux);
        for ($i = 0; $i < count($elements); $i++) {
        $asignacion = new asignacionFirmasModel;       
        $asignacion->id_user=$elements[$i];
        $asignacion->id_solicita=$user->id;
        $asignacion->num_expediente=$request->get('num_exp');
        $asignacion->num_asignacion=$num_asignacion;
        $asignacion->clave_alfanumerica=$clave_alfa_asig;
        $asignacion->txt=$txt;
        $asignacion->docx=$nombre_doc;
        $asignacion->tipo_documento=$request->get('tipoDocumento');
        $asignacion->tipo_expediente=$request->get('tipoExpediente');
        $asignacion->tipo_juicio=$request->get('tipoJuicio');
        //GUARDAR EL EXPEDIENTE-ACTOR                                    
        if($asignacion->tipo_documento == "SENTENCIA"){
          $asignacion->sala=$sala->num_sala;
          $asignacion->ponente=$request->get('ponente');
          $asignacion->proyectista=$proyectista;

        }elseif($asignacion->tipo_documento == "ACUERDO"){
         $actor_aux=$request->get('actores');
         $name = explode(",",$actor_aux[0]);
          if($actor_aux[0]){
            $actores="";
            foreach($name as $actor){
              if($actores == ""){
                $actores=$actor;          
              }else{
                $actores=$actores.",".$actor;          
              }              
            }

          }
          $asignacion->actores=$actores;
          $asignacion->auto=$request->get('tipoAcuerdo');
        }

        $asignacion->observaciones="";
        $asignacion->estado="PENDIENTE";
        $asignacion->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
        $asignacion->save();      
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","asignaciones_firma","'.$asignacion->id.'","'.base64_encode(json_encode($asignacion)).'"," ","El usuario creo una nueva asignación de firma electronica de un documento")');  
      
      }
  }
  }
  
    //VRIABLE PARA TRAER EL NUMERO DE ASIGNACION
    $firma_aux_aplicada=DB::table('asignaciones_firma')->where('id_user','=',$user->id)->where('num_expediente','=',$request->get('num_exp'))->where('clave_alfanumerica','=',$clave_alfa_asig)->first();
    //VALIDA SI SE ASIGNO LA FIRMA A ESE USUARIO- SI ES ASI PROCEDE A LA FIRMA , SI NO SOLO LO REDIRECCIONA Y ASIGNA LAS FIRMAS
    if($firma_aux_aplicada <> null){
        return Redirect::to('firmarAsignacion/'.$firma_aux_aplicada->id)->with('errors','Favor de ingresar sus credenciales, para continuar con el proceso de firma.');
}else{
       return Redirect::to('misFirmas')->with('errors','Se ha enviado el documento para la firma.');
        
    }
}


public function misFirmasPendientes(){
          $user=Auth::user();
      if($user->funcion == "ADMINISTRADOR" || $user->funcion == "MAGISTRADO" || $user->funcion == "SECRETARIA GENERAL DE ACUERDOS"|| $user->funcion == "COORDINADOR"){
       $firmas_int=DB::table('asignaciones_firma')->join('acuerdosgenarados','acuerdosgenarados.id','=','asignaciones_firma.id_acuerdo')
       ->join('expedientes','expedientes.id','=','acuerdosgenarados.id_expediente')
       ->where('asignaciones_firma.id_user','=',$user->id)
       ->join('users','users.id','=','asignaciones_firma.id_solicita')->where('asignaciones_firma.estado','=','PENDIENTE')->
       select('asignaciones_firma.*','expedientes.id as id_expediente','expedientes.num_expediente','users.name','users.apellido_p','users.apellido_m')->get();
       $firmas_ext=DB::table('asignaciones_firma')->where('asignaciones_firma.id_user','=',$user->id)->where('id_acuerdo','=',null)->where('asignaciones_firma.estado','=','PENDIENTE')
       ->join('users','users.id','=','asignaciones_firma.id_solicita')->
       select('asignaciones_firma.*','users.name','users.apellido_p','users.apellido_m')->get();
        return view('firmaDocumentos.firmasPendientes',['firmas_int'=>$firmas_int,'firmas_ext'=>$firmas_ext]);
      }  else{
        return view('errors.permisos');
      }  
}



public function firmarAsignacion($id){
          $user=Auth::user();
      if($user->funcion == "ADMINISTRADOR" || $user->funcion == "MAGISTRADO" || $user->funcion == "SECRETARIA GENERAL DE ACUERDOS"|| $user->funcion == "COORDINADOR"){
       $firma=DB::table('asignaciones_firma')
       ->where('asignaciones_firma.id_user','=',$user->id)
      ->where('asignaciones_firma.id','=',$id)
       ->where('asignaciones_firma.estado','=','PENDIENTE')
       ->join('users','users.id','=','asignaciones_firma.id_solicita')->
       select('asignaciones_firma.*','users.name','users.apellido_p','users.apellido_m')->first();
     

       $firmas=DB::table('asignaciones_firma')
      ->where('asignaciones_firma.num_asignacion','=',$firma->num_asignacion)
       ->join('users','users.id','=','asignaciones_firma.id_user')->
       select('asignaciones_firma.*','users.name','users.apellido_p','users.apellido_m','users.funcion')->get();
        return view('firmaDocumentos.firmarAsignacion',['firma'=>$firma,'firmas'=>$firmas]);
      }  else{
        return view('errors.permisos');
      }  
}


public function firmarAsignaciones(request $request,$id){
    $user=Auth::user();
    $firma=DB::table('firmaelectronica')->where('id_usuario','=',$user->id)->first();
    $certificado=$request->file('certificado');
    $llave=$request->file('key');
    $pass=$request->get('password');
        ////TIMESTAMP
    $fecha = new DateTime();
    $fecha_firma=$fecha->format('Y-m-d');
    $fecha_hora= $fecha->format('H:i:s');
    $fecha_unix=$fecha->format('U');
    //CARGAMOS EL CERTIFICADO
     $certFile = file_get_contents($certificado);
     $keyFile = file_get_contents($llave);
     $keyPassphrase = $pass;
     $keyCheckData = array(0=>$keyFile,1=>$keyPassphrase);
     $result = openssl_x509_check_private_key($certFile,$keyCheckData);

     

     if($result == true){
              //VALIDA SI HAY FIRMA REGISTRADA CON ESE USUARIO
     if($firma <> null){
            $decrypted = Crypt::decrypt($firma->password);
         if($certFile == $firma->certificado){
             if($decrypted == $pass){
     //ASIGNACION             
     $_auxAsig=asignacionFirmasModel::findOrFail($id);
     //OBETENEMOS EL ULTIMO FOLIO DE LA FIRMA Y DATOS GENERALES PARA GUARDAR LA FIRMA
       $firma_aux=DB::table('firmasaplicadas')->orderBy('num_firma','DESC')->first();
       $firma_user=DB::table('firmaelectronica')->where('id_usuario','=',$user->id)->first();
                 if($firma_aux <> null){
                 $folio_firma=$firma_aux->num_firma+1;
                  }else{
                  $folio_firma="0001";
                   }
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // Output: 54esmdr0qf
    for($a=0; $a < 100; $a++){
    $clave_alfa= substr(str_shuffle($permitted_chars), 0, 30);
      $valida_clave=DB::table('firmasaplicadas')->where('clave_alfanumerica','==',$clave_alfa)->get();
       if($valida_clave == null){
           $clave_alfa=$clave_alfa;
           break;
       }
   }
       //OBTENEMOS LA LLAVE PUBLICA DEL CERTIFICADO
   $pub_key = openssl_pkey_get_public(file_get_contents($certificado));
    $keyData = openssl_pkey_get_details($pub_key);
    $key_public=$keyData['key'];
    //SE GENERA EL SELLO
    //openssl_seal($data, $txt, $ekeys, array($key_public));
    $iv = openssl_random_pseudo_bytes(32);
    $Long= openssl_seal($_auxAsig->txt, $sealed, $ekeys, array($key_public),"AES256",$iv);
    $envelopeKey = $ekeys[0];
    $sello_original = base64_encode($envelopeKey);
    $xmlstr ="<?xml version='1.0'  encoding='utf-8'?>
<Datos>
    <expediente>
        <num_expediente>$_auxAsig->num_expediente</num_expediente>
        <tipo_juicio>$_auxAsig->tipo_juicio</tipo_juicio>
        <tipo>$_auxAsig->tipo_juicio</tipo>
         <fecha_expediente>$fecha_firma $fecha_hora</fecha_expediente>
        <fecha_captura>$fecha_firma $fecha_hora</fecha_captura>
        <ultima_actualizacion>$fecha_firma $fecha_hora</ultima_actualizacion>
    </expediente>
    <datos_documento>
        <tipo_documento>$_auxAsig->tipo_documento</tipo_documento>
         <folio_documento>XXX</folio_documento>
          <tiempo_contestacion>XXX</tiempo_contestacion>
         <capturo>$user->name $user->apellido_p $user->apellido_m</capturo>
          <fecha_captura>$fecha_firma $fecha_hora</fecha_captura>
        <ultima_actualizacion>$fecha_firma $fecha_hora</ultima_actualizacion>
        <documento_text>$_auxAsig->txt</documento_text>
    </datos_documento>
    <datos_firmante>
        <fecha_firma>$fecha_firma</fecha_firma>
        <hora_firma>$fecha_hora</hora_firma>
         <marca_tiempo>$fecha_unix</marca_tiempo>
        <firmante>$user->name $user->apellido_p $user->apellido_m</firmante>
        <num_firma>$folio_firma</num_firma>
         <clave_alfanumerica>$clave_alfa</clave_alfanumerica>
        <algoritmo_firma>SHA256</algoritmo_firma>
        <email_firmante>$user->email</email_firmante>
        <funcion_firmante>$user->funcion</funcion_firmante>
        <sello_original>$sello_original</sello_original>
    </datos_firmante>
</Datos>";
 $Mensaje = $xmlstr;
  //Datos que se quieren firmar:
    $datos_firma=['fecha_firma'=>$fecha_firma,'hora_firma'=>$fecha_hora,'num_firma'=>$folio_firma,'algoritmo_firma'=>'SHA256','email_firmante'=>$user->email,'funcion_firmante'=>$user->funcion,
        'firmante'=>$user->name." ".$user->apellido_p." ".$user->apellido_m];
        if (!openssl_sign($Mensaje, $firma, $keyFile, OPENSSL_ALGO_SHA256)) {
   // echo openssl_error_string(); //en el caso que la función anterior de openssl arrojará algun error, este sería visualizado gracias a esta línea
     return Redirect::to('firmarDocumento')->with('errors','Error al firmar el documento ');
    exit;
    }
    $firma_array=[];
    $firma_64 = base64_encode($firma);
    for ($i=1; $i <= 100; $i++){
        $firma1 = substr($firma_64,$i*100 , 100); // devuelve "d"
        if($firma1 <> null){
        array_push($firma_array, $firma1);
        }else{
            break;
        }
    }
     $firma_64 = base64_encode($firma);
    //GENERAMOS EL CODIGO QR
    $qr= DNS2D::getBarcodeHTML('https://www.sit-zac.org.mx/validadoc/'.$clave_alfa, 'QRCODE',2,2);
     //NOMBRE DEL XML Y PDF
    $nombre_xml=$user->email."_".$fecha_firma."_".$fecha_hora;
    //GENERAMOS EL NOMBRE DEL PDF PARA TODOS LOS ASIGNADOS
    $nombre_pdf="Documento_".$_auxAsig->num_asignacion;
    $name_zip=$nombre_xml.".zip";
    //GUARDA LA FIRMA ACTUAL
     $firma_a= new firmasAplicadasModel;
     $firma_a->id_firma=$firma_user->id;
     $firma_a->num_firma=$folio_firma;
     $firma_a->id_asignacion=$_auxAsig->id;
     $firma_a->firma=$firma;
     $firma_a->firma_64=$firma_64;
     $firma_a->firma_ruta=$nombre_xml.".dat";
     $firma_a->xml=$nombre_xml.".xml";
     $firma_a->pdf=$nombre_pdf.".pdf";
     $firma_a->estado="ACTIVA";
     $firma_a->clave_alfanumerica=$clave_alfa;
     $firma_a->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;
     $firma_a->zip=$name_zip;
     $firma_a->save();
     DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","firmasaplicadas","'.$firma_a->id.'","'.base64_encode(json_encode($firma_a)).'"," ","El usuario realizo la firma de un documento")');  
      
    //AGREGAMOS LA FIRMA AL DOCUMENTO
    //TRAEMOS TODAS LAS FIRMAS DEL DOCUMENTO
    	$_firmas_aux=DB::table('asignaciones_firma')->join('firmasaplicadas','firmasaplicadas.id_asignacion','=','asignaciones_firma.id')
    	->join('firmaelectronica','firmaelectronica.id','=','firmasaplicadas.id_firma')
    	->join('users','users.id','=','firmaelectronica.id_usuario')
    	->select('firmasaplicadas.*','users.name','users.apellido_p','users.apellido_m','users.funcion','users.email')->where('asignaciones_firma.num_asignacion','=',$_auxAsig->num_asignacion)->orderBy('asignaciones_firma.id','asc')->get();
    	$firma_text="";
    	$inicio="<style>
h6 {
font-family: sans-serif;
  font-weight: normal;
  font-size:0.7em;
    text-align : justify;
   word-wrap: break-word;
   line-height: 98%;
}
</style>
<br><br>
	    <p text-align:justify line-height: 98%;>
	   <h6>";
	   $fin="</h6>
     	<p>";
//ESTE FOR RECORRE TODAS LAS FIRMAS QUE TIENE AL MOMENTO
    	foreach($_firmas_aux as $_firma){
    	 $firma_text_aux="
	    Fecha y hora de la firma: ".$_firma->created_at."<br>
	    Firmante:".$_firma->name." ".$_firma->apellido_p." ".$_firma->apellido_m." <br>
	    Número de Folio: $_firma->num_firma <br>
	    Clave alfanumérica : $_firma->clave_alfanumerica <br>
	    Email : ".$_firma->email." <br>
	    Función : ".$_firma->funcion."<br><br>
	    Firma: <br>".
	    $_firma->firma_64."<br>
	    Algoritmo de firmado: SHA256, resultado codificado en Base64. <br><br><br>".
	     $qr."<hr>";
    	    $firma_text=$firma_text.$firma_text_aux;
    	}
    	$firma_text=$inicio.$firma_text.$fin;
    	//ACTUALIZA EL ESTADO DE LA ASIGNACION PROPIA
     $_auxAsig=asignacionFirmasModel::findOrFail($_auxAsig->id);
     $_auxAsig->estado="FIRMADO";
     $_auxAsig->update();
     DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","asignaciones_firma","'.$_auxAsig->id.'","'.base64_encode(json_encode($_auxAsig)).'"," ","El usuario actualizo el estado de la asignación de firma a FIRMADO")');  
      
    $_validaAsig=count(DB::table('asignaciones_firma')->where('estado','=','PENDIENTE')->where('num_asignacion','=',$_auxAsig->num_asignacion)->get());
    	if($_validaAsig == 0){
     $iv = openssl_random_pseudo_bytes(32);
       $pk1=openssl_x509_read('file://ssl/cert/admin@sitzac.org.mx.cer');
        openssl_seal($_auxAsig->txt, $sealed, $ekeys, array($pk1),"AES256",$iv);
        $sello_original_total = base64_encode($ekeys[0]);
    	//GENERAMOS UN SELLO UNICO 
    	$sello_aux="<h6>Sello original <br>
	    $sello_original_total<br><br>
	    <a href='https://www.sit-zac.org.mx/validadoc'>Url de validación del documento: https://www.sit-zac.org.mx/validadoc </a><br><br>
      Clave alfanumérica  del documento: $_auxAsig->clave_alfanumerica </h6>";
    	  $firma_text=$firma_text.$sello_aux;
    $firma_1 = 'Sello original:'.substr($sello_original_total, 0, 230); // devuelve "d"
    $firma_2 = substr($sello_original_total, 230, 230); // devuelve "d"
    $firma_3 = substr($sello_original_total, 460, 230); // devuelve "d"  
    	}else{
    $firma_1 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS "; // devuelve "d"
    $firma_2 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"
    $firma_3 = "DOCUMENTO NO VALIDO - FALTAN FIRMAS"; // devuelve "d"  	    
    	}
    // Make sure you have `dompdf/dompdf` in your composer dependencies.
    Settings::setPdfRendererName(Settings::PDF_RENDERER_DOMPDF);
    // Any writable directory here. It will be ignored.
    Settings::setPdfRendererPath('.');
    $phpWord = IOFactory::load("public/DOCUMENTOSPARAFIRMA/".$_auxAsig->docx, 'Word2007');
    $phpWord->save("public/DOCUMENTOSPARAFIRMA/tmp_".$_auxAsig->clave_alfanumerica.".html", 'HTML');
    

   //SE VALIDA QUE TIPO DE DOCUMENTO ES PARA GENERAR EL ENCABEZADO
   if($_auxAsig->tipo_documento == "ACUERDO"){
    $auto=mb_convert_encoding($_auxAsig->auto,'HTML-ENTITIES','UTF-8');
    $actores=mb_convert_encoding($_auxAsig->actores,'HTML-ENTITIES','UTF-8');

    $encabezado= '<p></p>
    <table style="border:none;" line-height: 120%>
    <tbody style="border:none;">
    <tr style="border:none;">
    <td style="border:none;">
     <div class="logo"><img class="logo" src="https://www.sit-zac.org.mx/img/logo_tja.png" width="200" height="200" alt="" style="border:none;" /></div>
    </td>
    <span style="font-family: "Arial"; font-size: 14pt;"> 
    <td style="border:none;">
    <h4>Expediente: <strong>'.$_auxAsig->num_expediente.'</strong></h4>
    <h4>AUTO :'.$auto.'</h4>
    <h4>ACTOR: <strong>'.$actores.'.</strong></h4>
    </td>
    </tr>
    </tbody>
    </table>
    <p></p>';
    

   }elseif($_auxAsig->tipo_documento == "SENTENCIA"){
    $encabezado= '<meta charset="UTF-8"/> <p></p>
    <table style="border:none;" line-height: 120%>
    <tbody style="border:none;">
    <tr style="border:none;">
    <td style="border:none;">
     <div class="logo"><img class="logo" src="https://www.sit-zac.org.mx/img/logo_tja.png" width="200" height="200" alt="" style="border:none;" /></div>
    </td>
    <span style="font-family: "Arial"; font-size: 14pt;"> 
    <td style="border:none;">
    <h4><strong>'.$_auxAsig->tipo_documento.'</strong></h4>
    <h4>Expediente: <strong>'.$_auxAsig->num_expediente.'</strong></h4>
    <h4>Sala :'.$_auxAsig->sala.'</h4>
    <h4>Ponente: <strong>'.$_auxAsig->ponente.'.</strong></h4>
    <h4>Proyectista: <strong>'.$_auxAsig->proyectista.'.</strong></h4></span>
    </td>
    </tr>
    </tbody>
    </table>
    <p></p>';
    

   }

$fileContent = file_get_contents("public/DOCUMENTOSPARAFIRMA/tmp_".$_auxAsig->clave_alfanumerica.".html");
$text_aux=$encabezado.$fileContent.$firma_text;

     //GENERA EL PDF PARA EL ACUERDO
     $options = new Options();
   $options->setIsRemoteEnabled(true);
    $options->isHtml5ParserEnabled(true);
    $options->set('isPhpEnabled', 'true');
     $aux="<style type='text/css'> @page { text-align:justify; margin-right:3cm; margin-left:3cm; margin-top:3cm; margin-bottom:3cm; width: 21.59cm;
  height: 33.02cm; inline-block; line-height: 150%;}  img {           
            max-width: 100%!important;
            height: auto!important;
          }
          .logo {
            height:200px!important;
            width:200px!important;
            max-width: 200px%!important;
          }
          </style>";
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($aux.$text_aux);
    $dompdf->render();
    $dompdf->setPaper('letter', 'portrait');
     $canvas = $dompdf->getCanvas();
   // $canvas->set_opacity(.5,'Multiply');//Multiply means apply to all pages.
    // Specify watermark text
    $sello_marca="Clave alfanumérica: ".$_auxAsig->clave_alfanumerica;

    // Instantiate font metrics class
    $fontMetrics = new FontMetrics($canvas, $options);
    $font = $fontMetrics->getFont('times');

    //$x = (($w-$textWidth)/2);42.68
    $canvas->page_text(10, 770, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
    //page_text method applies text to all pages.
    $canvas->page_text(580, 50, $firma_1, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0);  
    $canvas->page_text(575, 50, $firma_2, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0);       
    $canvas->page_text(570, 50, $firma_3, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0);               
            $canvas->set_opacity(.5,'Multiply'); 
             $canvas->page_text(10, 50, $sello_marca, $font, 5,$color = array(0,0,0), 
            $word_space = 0.0, $char_space = 0.0, $angle = 90.0); 
            $canvas->page_script('
            $pdf->set_opacity(.5,"Multiply");
           $pdf->image("img/logo_extendido.png","png", 300,600,200,700);
          ');
    
    $output = $dompdf->output();

    file_put_contents('FIRMASEMITIDAS/PDF/'.$nombre_pdf.".pdf", $output);
       // Nos aseguramos de que la cadena que contiene el XML esté en UTF-8
    $textoXML = mb_convert_encoding($xmlstr, "UTF-8");
    // Grabamos el XML en el servidor como un fichero plano, para
	// poder ser leido por otra aplicación.
    	$gestor = fopen('FIRMASEMITIDAS/XML/'.$nombre_xml.".xml", 'w');
	fwrite($gestor, $textoXML);//ESCRIBIMOS EL XML
	fclose($gestor);
    file_put_contents('FIRMASEMITIDAS/FIRMA/'.$nombre_xml.".dat", $firma);//GUARDAMOS LA FIRMA
   //////////////////////////COMPRIMIMOS EL XML Y PDF
   $zip = new ZipArchive();
   $name_zip=$nombre_xml.".zip";
$filename = 'FIRMASEMITIDAS/ZIP/'.$name_zip;
if($zip->open($filename,ZIPARCHIVE::CREATE)===true) {
        $zip->addFile("FIRMASEMITIDAS/PDF/".$nombre_xml.".pdf",$nombre_xml.".pdf");
        $zip->addFile("FIRMASEMITIDAS/XML/".$nombre_xml.".xml",$nombre_xml.".xml");
        $zip->addFile("FIRMASEMITIDAS/FIRMA/".$nombre_xml.".dat",$nombre_xml.".dat");
        $zip->close();
        //echo 'Creado '.$filename;
}
else {
        echo 'Error creando '.$filename;
         return Redirect::to('firmarDocumento')->with('errors','Error al crear el zip ');
}
    $version_ant="";
   return view('firmaDocumentos.detalle',['_validaAsig'=>$_validaAsig,'firma_a'=>$firma_a,'datos_firma'=>$datos_firma,'name_zip'=>$name_zip,'version_ant'=>$version_ant]);
             }else{
    //NO COICIDE LA CONTRASEÑA
    return Redirect::to('firmasPendientes')->with('errors','Contraseña incorrecta ');
          }
         }else{
             //no coincide certificado
             return Redirect::to('firmasPendientes')->with('errors','El certificado ingresado no corresponde al suyo, favor de cargar las credenciales correctas o ponerse en contacto con el administrador ');
         }
     }else{
         return Redirect::to('firmasPendientes')->with('errors','No tiene una firma registrada en el sistema, favor de comunicarse con el administrador');
     }
 }else{
           return Redirect::to('firmasPendientes')->with('errors','El certificado y su llave privada no coicide,  favor de cargar las credenciales correctas o ponerse en contacto con el administrador ');
     }
}



public function validarFiel(){
    $users=DB::table('users')->where('estado','=','ACTIVO')->get();
    return view('firmasElectronicas.validaFiel',['users'=>$users]);
}

    



public function validaFiel(request $request){
     //$user=Auth::user();
      $user=$request->get('firmante');
      $firma=DB::table('firmaelectronica')->where('id_usuario','=',$user)->first();
      $certificado=$request->file('certificado');
      $llave=$request->file('key');
      $pass=$request->get('password');
    //CARGAMOS EL CERTIFICADO
     $certFile = file_get_contents($certificado);
     $keyFile = file_get_contents($llave);
     $keyPassphrase = $pass;
     $keyCheckData = array(0=>$keyFile,1=>$keyPassphrase);
     $result = openssl_x509_check_private_key($certFile,$keyCheckData);
     if($result == true){
              //VALIDA SI HAY FIRMA REGISTRADA CON ESE USUARIO
     if($firma <> null){
            $decrypted = Crypt::decrypt($firma->password);
         if($certFile == $firma->certificado){
             if($decrypted == $pass){
                 echo "FIRMA CORRECTA";
  }else{
    //NO COICIDE LA CONTRASEÑA
    return Redirect::to('validarFiel')->with('errors','Contraseña incorrecta ');
          }
         }else{
             //no coincide certificado
             return Redirect::to('validarFiel')->with('errors','El certificado ingresado no corresponde al suyo, favor de cargar las credenciales correctas o ponerse en contacto con el administrador ');
         }
         
     }else{

         

         return Redirect::to('validarFiel')->with('errors','No tiene una firma registrada en el sistema, favor de comunicarse con el administrador');

     }

    

 }else{

          

           return Redirect::to('validarFiel')->with('errors','El certificado y su llave privada no coicide,  favor de cargar las credenciales correctas o ponerse en contacto con el administrador ');

     }

             

         }

public function traerMagistradoSala(Request $request,$id){
     if ($request->ajax()) {        
    $sala=DB::table('salamagistrado')->where('salamagistrado.id','=',$id)->join('personalsala','personalsala.id_sala','=','salamagistrado.id')
    ->where('personalsala.funcion','=','MAGISTRADO')->join('users','users.id','=','personalsala.id_user')->select('users.*')->first();
     return response()->json(['sala'=>$sala]);
     }
    
}




}

