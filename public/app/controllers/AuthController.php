<?php

class AuthController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function getLogin()
	{
		$title = "Iniciar Sesión | Nombre";
		return View::make('home.login')
		->with('title',$title);
	}
	public function postLogin()
	{
		$inp 	= Input::all();
		$rules  = array(
			'username' => 'required',
			'password' => 'required',
		); 
		$msg = array(
			'required' => 'El campo :attribute es obligatorio'
		);
		$attr = array(
			'username.required' => 'Usuario',
			'password.required' => 'Contraseña',
		);
		$validator = Validator::make($inp, $rules, $msg, $attr);
		if ($validator->fails()) {
			return Response::json(array('type' => 'warning','data' => $validator->getMessageBag()->toArray()));
		}
		$data = array(
			'username' => $inp['username'],
			'password' => $inp['password']
		);
		if(Auth::attempt($data, $inp['check']))
		{
			return Response::json(array(
				'type' => 'success'
			));
		}else
		{
			return Response::json(array(
				'type' => 'danger',
				'msg'  => 'Usuario o Contraseña incorrecto'
			));
		}
	}

}