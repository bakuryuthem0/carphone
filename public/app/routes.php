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
		//marcas
		Route::get('marca/nueva','AdminController@getNewMarca');
		Route::post('marca/nueva/enviar','AdminController@postNewMarca');
		Route::get('marcas/ver-marcas','AdminController@getModifyCat');
		Route::get('editar-marca/{id}','AdminController@getModifyCatById');
		Route::post('modificar-marca/{id}/enviar','AdminController@postModifyCatById');
		Route::post('marca/eliminar','AdminController@postElimCat');
		
		//articulos
		Route::get('articulo/nuevo','AdminController@getNewItem');
		Route::post('articulo/nuevo/enviar','AdminController@postNewItem');
		Route::get('articulo/nuevo-articulo/continuar/{id}','AdminController@getContinueNew');
		Route::post('articulo/nuevo-articulo/imagenes/procesar','AdminController@post_upload');
		Route::post('articulo/imagenes/eliminar','AdminController@postDeleteImg');
		Route::get('articulo/ver-articulos','AdminController@getShowArt');
		Route::get('articulo/editar-articulo/{id}','AdminController@getMdfItem');
		Route::post('articulo/editar-articulo/{id}/enviar','AdminController@postMdfItem');
		Route::post('articulo/color/eliminar','AdminController@postElimItemColor');
		Route::post('articulo/eliminar','AdminController@postElimItem');
		Route::post('articulo/imagenes/eliminar','AdminController@postDeleteImgMdf');


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