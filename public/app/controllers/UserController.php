<?php

class UserController extends BaseController {

	public function getMyPurchases()
	{
		$title = "Mis Compras | NombreDeLaPag";
		$fac = Facturas::where('user_id','=',Auth::user()->id)
		->get();
		return View::make('user.userPurchases')
		->with('title',$title)
		->with('fac',$fac);
	}
}