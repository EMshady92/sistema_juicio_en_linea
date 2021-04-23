<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\tipoDocumentoModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;

class tipoDocumentoController extends Controller
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
        $tipos=DB::table('tipodocumento')->get();

        return view('tipoDocumentos.index',['tipos'=>$tipos]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('tipoDocumentos.create');
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
        $tipo = new tipoDocumentoModel;
        $tipo->tipo_documento=$request->get('tipo');
        $tipo->estado="ACTIVO";
        $tipo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
        $tipo->save();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","create","tipodocumento","'.$tipo->id.'","'.base64_encode(json_encode($tipo)).'"," ","El usuario ha creado un nuevo tipo de documento")');  


        return Redirect::to('tiposDocumentos')->with('errors','Registro guardado correctamente');
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
        $tipo= tipoDocumentoModel::findOrFail($id); 
        return view('tipoDocumentos.detalle',['tipo'=>$tipo]);
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
        $tipo= tipoDocumentoModel::findOrFail($id); 
        return view('tipoDocumentos.edit',['tipo'=>$tipo]);

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
        $tipo= tipoDocumentoModel::findOrFail($id);      
        $tipo_ant= tipoDocumentoModel::findOrFail($id);      
        $tipo->tipo_documento=$request->get('tipo');
        $tipo->estado="ACTIVO";
        $tipo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
        $tipo->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","update","tipodocumento","'.$tipo->id.'","'.base64_encode(json_encode($tipo)).'","'.base64_encode(json_encode($tipo_ant)).'","El usuario ha modificado el tipo de documento")');  


        return Redirect::to('tiposDocumentos')->with('errors','Registro actualizado correctamente');
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
        $tipo= tipoDocumentoModel::findOrFail($id);      
        $tipo->estado="INACTIVO";
        $tipo->captura=$user->name." ".$user->apellido_p." ".$user->apellido_m;  
        $tipo->update();
        DB::select('CALL InsertarMovimiento ("'.$user->id.'","delete","tipodocumento","'.$tipo->id.'","'.base64_encode(json_encode($tipo)).'"," ","El usuario ha inactivado el tipo de documento")');  


        return Redirect::to('tiposDocumentos')->with('errors','Registro inactivado correctamente');
        //
    }

    public function dompdf(){
         //GENERA EL PDF PARA EL ACUERDO
         $fileContent = file_get_contents('DOCUMENTOSPARAFIRMA/document2.html') ;
     $options = new Options();
     $options->set('isPhpEnabled', 'true');
     $options->setIsRemoteEnabled(true);
     $options->isHtml5ParserEnabled(true);
        $dompdf = new Dompdf($options);

        $encabezado= '<p>
        <table style="border:none;">
        <tbody style="border:none;">
        <tr style="border:none;">
        <td style="border:none;">
        <div class="logo"><img class="logo" src="https://www.sijel.com.mx/img/logo_tja.png" width="200" height="200" alt="" style="border:none;" /></div>
        </td>
        <span style="font-family: "Arial"; font-size: 14pt;"> 
        <td style="border:none;">
        <h4><strong>Document</strong></h4>
        <h4>Expediente: <strong>56456446</strong></h4>
        <h4>Sala: <strong>2</strong></h4>
        <h4>Ponente: <strong>Juan Chaves</strong></h4>
        <h4>Proyectista: <strong>Luis V</strong></h4></span>
        </td>
        </tr>
        </tbody>
        </table>
        </p>';

    $aux="<style type='text/css'> @page { text-align:justify; margin-right:3cm; margin-left:4cm; margin-top:1.75cm; margin-bottom:5cm; width: 21.59cm;
        height: 33.02cm; display: inline-block; line-height: 150%;}  img {
            height:800px!important;
            width:620px!important;
          }
          .logo {
            height:200px!important;
            width:200px!important;
          }
          </style>";

        $dompdf->loadHtml($aux.$encabezado.$fileContent);
        $dompdf->setPaper('letter');
        define("DOMPDF_FONT_HEIGHT_RATIO", 0.75);
        $dompdf->render();
        //Page numbers
        //$font = $dompdf->getFontMetrics()->getFont("Arial", "bold");
        //$dompdf->getCanvas()->page_text(20, 770, "Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 8, array(0, 0, 0));
        // Instantiate canvas instance 
        $canvas = $dompdf->getCanvas();


       // $canvas->set_opacity(10,'Multiply');//Multiply means apply to all pages.
        // Specify watermark text
        $text = "Sello de la cadena original: V/OZhFa3acWMpfDqux9OjYYrZIZ7AyspaDeW3e6Kz6n6h1i7UAccdMazqjOFZJKqyMnGoPZ/buk2zCFtz2pNb4zvPp8PF2zUJZNzZ9xAyU1B2tEtZ
";
        $text2 = "MfU3roJMjqF7RdFCRKevErxBk8rQV6eWdTtou6NvaNceedlYiiGa8ZpEwmkXITChmn1MnPYUL5SAJBQAJEhcLIScad9wSX8dyNfstdRkNlPIwHfIn";

        // Instantiate font metrics class
        $fontMetrics = new FontMetrics($canvas, $options);
        $font = $fontMetrics->getFont('times');
        $txtHeight = $fontMetrics->getFontHeight($font, 150);
        $textWidth = $fontMetrics->getTextWidth($text, $font, 40);
         
        $x2 = 100; 
        $y2 = 100; 
        //$x = (($w-$textWidth)/2);42.68
        $x=580;
        $y = 50;
      


        $canvas->page_text(10, 770, "Pagina {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));
        $canvas->page_text(10, 50, "Clave alfanumerica:65464654", $font, 5,$color = array(0,0,0), 
        $word_space = 0.0, $char_space = 0.0, $angle = 90.0);       
        //page_text method applies text to all pages.
        $canvas->page_text($x, $y, $text, $font, 5,$color = array(0,0,0), 
                $word_space = 0.0, $char_space = 0.0, $angle = 90.0);
        $canvas->page_text(575, $y, $text2, $font, 5,$color = array(0,0,0), 
                $word_space = 0.0, $char_space = 0.0, $angle = 90.0);

                $canvas->set_opacity(.5,'Multiply'); 
                $canvas->page_script('
                $pdf->set_opacity(.5,"Multiply");
                $pdf->image("img/logo_extendido.png","png", 200,600,200,700);
              ');
                

$dompdf->stream('document.pdf', array("Attachment" => 0));
    }
}
