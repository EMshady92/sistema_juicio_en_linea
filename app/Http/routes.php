<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
//pagina de bienvenida
Route::resource('welcome', 'LobbyController');

//pagina de bienvenida
Route::resource('welcome', 'LobbyController');

//OLVIDE CONTRASEÑA
Route::get('/reset_password', function () {
    return view('auth/reset_password');
});


Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

 

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);

//ACTORES-ABOGADOS
Route::resource('personas', 'PersonasController');
Route::post('actoresCrear', 'PersonasController@modal_actores');
Route::get('valida_email', 'PersonasController@valida_email');
Route::get('valida_cedula_abogado', 'PersonasController@valida_cedula_abogado');
//RUTA PARA VALIDAR LOS CORREOS DE LOS ACTORES

//DEMANDADOS
Route::resource('demandados', 'DemandadoController');
Route::post('demandadosCrear', 'DemandadoController@modal_demandados');
Route::get('valida_nombreAutoridad', 'DemandadoController@valida_nombreAutoridad');

//ABOGADOS
Route::resource('abogados', 'AbogadoController');
Route::post('abogadosCrear', 'AbogadoController@modal_abogados');
Route::get('valida_email_abogado', 'AbogadoController@valida_email_abogado');

//TERCERAS PERSONAS 
Route::resource('terceras_personas', 'TerceraPersonaController');
Route::post('terceras_personasCrear', 'TerceraPersonaController@modal_terceras_personas');
Route::get('valida_email_terceras', 'TerceraPersonaController@valida_email_terceras');
Route::get('valida_email_tercerasmod', 'TerceraPersonaController@valida_email_tercerasmod');
//INGRESOS DE EXPEDIENTES
Route::resource('expedientes', 'ExpedientesController');
Route::get('traer_expediente/{id}', 'ExpedientesController@traer_expediente'); 
Route::get('ver_expediente/{id}', 'ExpedientesController@show');
Route::get('acuse_ingreso/{id}', array('as'=> '/acuse_ingreso','uses'=>'ExpedientesController@invoice'));
Route::get('traerHistorialExpediente/{id}', 'ExpedientesController@traerHistorialExpediente');
Route::get('portada/{id}', array('as'=> '/portada','uses'=>'ExpedientesController@portada'));
Route::get('generate-docx', 'ExpedientesController@docs');
Route::get('traerCoordinadores/{id}', 'ExpedientesController@traerCoordinadores');
Route::post('enviarExpediente/{id}', 'ExpedientesController@enviarExpediente');
Route::post('recibirExpediente/{id}', 'ExpedientesController@recibirExpediente');

/////////////////////////Estadisticas Oficialia////////////////////////////////////
Route::get('estadisticas_ofi', 'ExpedientesController@estadisticas_ofi');
Route::get('traer_exp_nul/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traer_exp_nul');
Route::get('traer_exp_rag/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traer_exp_rag');
Route::get('traer_exp_gen/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traer_exp_gen');
Route::get('traer_exp_amp/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traer_exp_amp');
Route::get('traer_exp_prom/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traer_exp_prom');
/////////////////////////////////////////////////////////////////////////////////////////
//AMPAROS Y PROMOCIONES
Route::resource('amparos_promociones', 'AmparosController');
Route::get('acuse_amparo/{id}', array('as'=> '/acuse_amparo','uses'=>'AmparosController@invoice'));
Route::get('ver_amparo/{id}', 'AmparosController@show');

//USUARIOS
Route::resource('users', 'userController');
Route::get('verHistorialUsuario/{id}', 'userController@show');
Route::get('passwordvalida', 'userController@validaPassword');
Route::get('historial_usuarios', 'userController@historial_usuarios');
Route::get('historial_usuario/{id}', 'userController@historial_usuario');

//FIRMA ELECTRONICA
Route::resource('firmaElectronica', 'firmaElectronicaController');
Route::get('validaFirma', 'firmaElectronicaController@validaFirma');




//SALAS MAGISTRADO
Route::resource('salasMagistrado', 'salaMagistradoController');
Route::get('validaSala/{cr}', 'salaMagistradoController@validaSala');

//MAGISTRADOS EXPEDIENTES
Route::resource('magistradoExpedientes', 'ExpedienteMagistradoController');
Route::get('misExpedientes', 'ExpedienteMagistradoController@misExpedientes');
Route::post('asignarExpediente/{id}', 'ExpedienteMagistradoController@asignarExpediente');
Route::post('editarExpediente/{id}', 'ExpedienteMagistradoController@editarExpediente');
Route::get('asignaciones', 'ExpedienteMagistradoController@asignaciones');
Route::get('misAsignaciones', 'ExpedienteMagistradoController@misAsignaciones');
Route::post('validarExpediente/{id}', 'ExpedienteMagistradoController@validarExpediente');


Route::get('estadisticasfirmas', 'ExpedientesController@estadisticasfirmas');
Route::get('acusedia/{date}', array('as'=> '/acusedia','uses'=>'ExpedientesController@acusedia'));
Route::get('descargar-estadisticas', 'ExpedientesController@excel')->name('firmasElectronicas.excel');
Route::get('traerJuiciosTotales/{juicio}', 'ExpedientesController@traerJuiciosTotales');
Route::get('traerJuiciosEstadisticas/{juicio}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerJuiciosEstadisticas');
Route::get('traerJuiciosFirmados/{juicio}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerJuiciosFirmados');
Route::get('traerJuiciosPendientes/{juicio}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerJuiciosPendientes');
Route::get('traerJuiciosRevocadas/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerJuiciosRevocadas');

Route::get('traerDocumentos_totales/{documento}', 'ExpedientesController@traerDocumentos_totales');
Route::get('traerDocumentosEstadisticas/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerDocumentosEstadisticas');
Route::get('traerDocumentosFirmados/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerDocumentosFirmados');
Route::get('traerDocumentosPendientes/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerDocumentosPendientes');
Route::get('traerDocumentosRevocadas/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerDocumentosRevocadas');

Route::get('traerExpedientes_totales/{expediente}', 'ExpedientesController@traerExpedientes_totales');
Route::get('traerExpedientesEstadisticas/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerExpedientesEstadisticas');
Route::get('traerExpedientesFirmados/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerExpedientesFirmados');
Route::get('traerExpedientesPendientes/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerExpedientesPendientes');
Route::get('traerExpedientesRevocadas/{documento}/{fecha_inicio}/{fecha_fin}/{sala}', 'ExpedientesController@traerExpedientesRevocadas');

Route::get('traerSalasEstadisticas/{sala}/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traerSalasEstadisticas');
Route::get('traerSalasFirmados/{documento}/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traerSalasFirmados');
Route::get('traerSalasPendientes/{documento}/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traerSalasPendientes');
Route::get('traerSalasRevocadas/{documento}/{fecha_inicio}/{fecha_fin}', 'ExpedientesController@traerSalasRevocadas');
//ACUERDOS
Route::resource('acuerdos', 'acuerdosController');
Route::get('generar_acuerdo/{id}', 'acuerdosController@create');
Route::post('generar_acuerdo/{id}', 'acuerdosController@store'); 
Route::get('guardado/{id}','acuerdosController@guardado');
Route::get('imprimir_acuerdo/{id}', array('as'=> '/imprimir_acuerdo','uses'=>'acuerdosController@invoice'));
Route::get('revisarAcuerdos', 'acuerdosController@revisarAcuerdos');
Route::get('revisarAcuerdo/{id}', 'acuerdosController@revisarAcuerdo');
Route::post('guardarAcuerdoRev/{id}', 'acuerdosController@guardarAcuerdoRev');
Route::post('firmarAcuerdo/{id}', 'acuerdosController@firmarAcuerdo');


//GENERALIDADES
Route::resource('generalidades', 'generalidadesController');
Route::get('ver_generalidades/{id}', 'generalidadesController@show');

//SALASPERSONAL
Route::resource('personalSala', 'personalSalaController');
Route::get('valida_magistrado', 'personalSalaController@valida_magistrado');
Route::get('validar_sala', 'personalSalaController@validar_sala');

//Catalogo Acuerdoscd c:/
Route::resource('acuerdos_tipos', 'CatalogoTiposAcuerdosController');
Route::post('abogadosCrear', 'AbogadoController@modal_abogados');



//TIPOS JUICIOS
Route::resource('tipos_juicios', 'TiposJuiciosController');

//EMAIL USERS
Route::resource('email_users', 'EmailUsersController');
Route::get('valida_email_users', 'EmailUsersController@valida_email_users');
Route::post('emailsCrear', 'EmailUsersController@modal_personas');
Route::get('ver_emails/{id}', 'EmailUsersController@ver_emails');
Route::get('traer_emails/{id}', 'EmailUsersController@traer_emails');
//FIRMAR DOCUMENTOS
Route::get('validadoc/{base64}', 'consultaFirmasController@validarDocumento');
Route::get('validadoc', 'consultaFirmasController@validarDocumentos');
Route::post('validadoc', 'consultaFirmasController@validarDocumentos');
Route::get('validarFirma', 'firmaElectronicaController@validarFirma');
Route::post('validarFirma', 'firmaElectronicaController@mostrarFirma');
Route::get('firmarDocumento', 'firmaElectronicaController@firmarDocumento');
Route::post('guardardocFirmado', 'firmaElectronicaController@guardardocFirmado'); 
Route::get('misFirmas', 'firmaElectronicaController@misFirmas');
Route::get('firmasEmitidas', 'firmaElectronicaController@firmasEmitidas');
Route::get('firmasPendientes', 'firmaElectronicaController@misFirmasPendientes');
Route::get('firmarAsignacion/{id}', 'firmaElectronicaController@firmarAsignacion');
Route::post('firmarAsignaciones/{id}', 'firmaElectronicaController@firmarAsignaciones');
Route::get('autofirmado', 'firmaElectronicaController@autofirmado');
Route::get('validarFiel', 'firmaElectronicaController@validarFiel');
Route::post('validarFiel', 'firmaElectronicaController@validaFiel');
Route::get('traerMagistradoSala/{id}', 'firmaElectronicaController@traerMagistradoSala');


//TIPOS DE DOCUMENTOS
Route::resource('tiposDocumentos', 'tipoDocumentoController');

//TIPOS DE Actos
Route::resource('tipos_actos', 'TiposActosController');

//TIPOS DE Actos
Route::resource('tipos_promociones', 'TiposPromocionController');

//SUBDEPENDENCIAS
Route::resource('subdependencias', 'SubDependenciasController');
Route::get('valida_email_subdeps', 'SubDependenciasController@valida_email_subdeps');

//TIPOS DE FALTA
Route::resource('tiposFalta', 'tipoFaltaController');

//RUTA PARA PRUEBA
Route::get('dompdf', 'tipoDocumentoController@dompdf');

//REVOCAR DOCUMENTOS
Route::resource('revocarDocumentos', 'documentosRevocadosController');
Route::get('traerAsignacionFirma/{id}', 'documentosRevocadosController@traerAsignacionFirma');
