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
				'type' => 'success',
				'msg'  => 'Inicio de sesión satisfactorio, redirigiendo'
			));
		}else
		{
			return Response::json(array(
				'type' => 'danger',
				'msg'  => 'Usuario o Contraseña incorrecto'
			));
		}
	}
	public function getRegister()
	{
		$title = "Registro | Nombre";
		return View::make('home.register')
		->with('title',$title);
	}
	public function postRegister()
	{
		$inp 	= Input::all();
		$rules	= array(
			'user' => 'required|min:4|unique:users,username',
			'pass' => 'required|min:4|confirmed',
			'email'=> 'required|min:4|unique:users,email|email' 
		);
		$msg 	= array(
			'required' => 'El campo es obligatorio',
			'confirmed'=> 'Las contraseñas no concuerdan', 
			'min'	   => 'El campo es muy corto minimo 4 caracteres',
			'email'	   => 'Formato invalido para el campo' 
		);
		$validator = Validator::make($inp, $rules, $msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$user = new User;
		$user->username = $inp['user'];
		$user->password = Hash::make($inp['pass']);
		$user->email 	= $inp['email'];
		if ($user->save()) {
			Session::flash('success', 'Cuenta creada satisfactoriamente');
			return Redirect::to('iniciar-sesion');
		}else
		{
			Session::flash('success', 'Error al crear la cuenta');
			return Redirect::back();
		}

	}
	public function getLogOut()
	{
		Auth::logout();
		if (Auth::check()) {
			return 'nope';
		}
		return Redirect::to('/');
	}
}