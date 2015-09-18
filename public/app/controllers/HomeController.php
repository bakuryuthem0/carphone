<?php

class HomeController extends BaseController {

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

	public function getIndex()
	{
		$title = "Titulo | NombreDeLaPag";
		return View::make('home.index')
		->with('title',$title);
	}
	public function getPhones()
	{
		$title = "Telefonos | NombreDeLaPag";
		$phon = Phones::where('deleted','=',0)->get();
		$cant = array();
		foreach($phon as $p)
		{
			$aux = Items::where('item_marc','=',$p->id)->count();
			if($aux>0)
			{
				$cant[$p->id] = $aux;
			}
		}
		$items = Items::join('images','items.id', '=', 'images.item_id')
		->where('items.deleted','=',0)
		->groupBy('items.id')
		->orderBy('items.id','DESC')
		->paginate(6,array(
			'items.id',
			'items.item_prec',
			'items.item_marc',
			'items.item_cod',
			'items.item_nomb',
			'images.image',
		));
		$colores = array();
		foreach($items as $i)
		{
			$colores[$i->id] = Colores::where('item_id','=',$i->id)
			->where('deleted','=',0)
			->get();
		}
		return View::make('phone.home.index')
		->with('title',$title)
		->with('marcas',$phon)
		->with('cant',$cant)
		->with('items',$items)
		->with('colores',$colores);
	}
	public function getArtSelf($id)
	{
		$item = Items::find($id);
		$item->imgPrinc = Images::where('item_id','=',$id)
		->where('deleted','=',0)
		->first();
		$item->images = Images::where('item_id','=',$id)
		->where('deleted','=',0)
		->get()->toArray();
		$item->colores= Colores::where('item_id','=',$id)
		->where('deleted','=',0)
		->get()->toArray();
		$title = $item->item_nomb." | NombreDeLaPag";
		return View::make('phone.home.artSelf')
		->with('title',$title)
		->with('item',$item);
	}
}