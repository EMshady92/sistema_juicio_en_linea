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



//ACTORES

Route::resource('actores', 'ActorController');

Route::post('actoresCrear', 'ActorController@modal_actores');

Route::get('valida_email', 'ActorController@valida_email');



//DEMANDADOS

Route::resource('demandados', 'DemandadoController');

Route::post('demandadosCrear', 'DemandadoController@modal_demandados');

Route::get('valida_nombreAutoridad', 'DemandadoController@valida_nombreAutoridad');



//ABOGADOS

Route::resource('abogados', 'AbogadoController');

Route::post('abogadosCrear', 'AbogadoController@modal_abogados');



//TERCERAS PERSONAS 

Route::resource('terceras_personas', 'TerceraPersonaController');

Route::post('terceras_personasCrear', 'TerceraPersonaController@modal_terceras_personas');



//INGRESOS DE EXPEDIENTES

Route::resource('expedientes', 'ExpedientesController');

Route::get('traer_expediente/{id}', 'ExpedientesController@traer_expediente');

Route::get('ver_expediente/{id}', 'ExpedientesController@show');

Route::get('acuse_ingreso/{id}', array('as'=> '/acuse_ingreso','uses'=>'ExpedientesController@invoice'));

Route::get('portada/{id}', array('as'=> '/portada','uses'=>'ExpedientesController@portada'));

//AMPAROS Y PROMOCIONES

Route::resource('amparos_promociones', 'AmparosController');

Route::get('acuse_amparo/{id}', array('as'=> '/acuse_amparo','uses'=>'AmparosController@invoice'));

Route::get('ver_amparo/{id}', 'AmparosController@show');



//FIRMA ELECTRONICA

Route::resource('firmaElecronica', 'firmaElectronicaController');





//USUARIOS

Route::resource('users', 'userController');



//FIRMA ELECTRONICA

Route::resource('firmaElectronica', 'firmaElectronicaController');

Route::get('validaFirma', 'firmaElectronicaController@validaFirma');

Route::get('acuseFirma/{id}', array('as'=> '/acuseFirma','uses'=>'firmaElectronicaController@invoice'));



//SALAS MAGISTRADO

Route::resource('salasMagistrado', 'salaMagistradoController');

Route::get('validaSala/{cr}', 'salaMagistradoController@validaSala');



//MAGISTRADOS EXPEDIENTES

Route::resource('magistradoExpedientes', 'ExpedienteMagistradoController');

Route::get('misExpedientes', 'ExpedienteMagistradoController@misExpedientes');

Route::post('asignarExpediente/{id}', 'ExpedienteMagistradoController@asignarExpediente');

Route::get('asignaciones', 'ExpedienteMagistradoController@asignaciones');

Route::get('misAsignaciones', 'ExpedienteMagistradoController@misAsignaciones');



//ACUERDOS

Route::resource('acuerdos', 'acuerdosController');

Route::get('generar_acuerdo/{id}', 'acuerdosController@create');

Route::post('generar_acuerdo/{id}', 'acuerdosController@store');

Route::get('guardado/{id}','acuerdosController@guardado');

Route::get('imprimir_acuerdo/{id}', array('as'=> '/imprimir_acuerdo','uses'=>'acuerdosController@invoice'));



