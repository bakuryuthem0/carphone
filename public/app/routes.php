<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/','HomeController@getIndex');
Route::get('telefonos','HomeController@getPhones');
Route::get('administrador','AdminController@getAdminLogin');
Route::post('administrador/iniciar-sesion/autenticar','AdminController@postAdminLogin');

Route::group(array('before' => 'check_auth'),function()
{
	Route::group(array('before' => 'check_admin'),function(){
		Route::get('administrador/inicio','AdminController@getIndex');

		Route::get('marca/nueva','AdminController@getNewMarca');
		Route::post('marca/nueva/enviar','AdminController@postNewMarca');
		Route::get('marcas/ver-marcas','AdminController@getModifyCat');
		Route::get('editar-marca/{id}','AdminController@getModifyCatById');
		Route::post('modificar-marca/{id}/enviar','AdminController@postModifyCatById');
		Route::post('marca/eliminar','AdminController@postElimCat');

	});
});
Route::group(array('before' => 'check_no_auth'),function()
{
	Route::get('iniciar-sesion','AuthController@getLogin');
	Route::post('iniciar-sesion/enviar','AuthController@postLogin');

	Route::get('registrarse','AuthController@getRegister');
	Route::post('registrarse/enviar','AuthController@postRegister');

});

Route::get('cerrar-sesion','AuthController@getLogOut');