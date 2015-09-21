<?php

class ItemController extends BaseController {

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
	public function addToCart()
	{
		$inp = Input::all();
		$rowId = Cart::search(array('id' => $inp['id'],'options' => array('color' => $inp['color'])));
		if ($rowId) {
			$cart  = Cart::get($rowId[0]);
			$stock = Colores::find($inp['color']);
			if ($cart->qty+1 > $stock->item_stock) {
				return Response::json(
					array(
						'type'   => 'warning',
						'msg'    => 'Lo sentimos, no poseemos suficiente stock para este item.',
						'maximo' => $cart->qty));
			}
			
		}

		Cart::add(array(
			'id' => $inp['id'],
			'name' => $inp['name'],
			'qty' => 1,
			'options' =>array(
				'img' 			=> $inp['img'],
				'color'			=> $inp['color'],
				'color_desc'    => $inp['color_desc'],
				'cod' 		    => $inp['cod'],
				),
			'price' => $inp['price']
			));
		return Response::json(array('type' => 'success','msg' => 'Articulo agregado satisfactoriamente'));
	}
	public function deleteCartItem()
	{
		$inp = Input::all();
		$rowId = Cart::search(array('id' => $inp['id'],'options' => array('color' => $inp['color'])));
		Cart::remove($rowId[0]);
		return Response::json(array('type' => 'success','msg' => 'Articulo removido satisfactoriamente'));
	}
	public function destryoCart()
	{
		Cart::destroy();
		return Response::json(array('type' => 'success','msg' => 'Se ha vaciado el carrito'));
	}
	public function getCart()
	{
		$title = "Mi carrito | NombreDeLaPag";
		return View::make('phone.home.mycart')
		->with('title',$title);
	}
	public function modifyCartQty()
	{
		$inp = Input::all();
		$stock = Colores::find($inp['color']);
		if ($inp['qty'] > $stock->item_stock) {
			return Response::json(
				array(
					'type' => 'warning',
					'msg' => 'Lo sentimos, no poseemos suficiente stock para este item.',
					'maximo' => $inp['qty']-1
					)
				);
		}
		$rowId = Cart::search(array('id' => $inp['id'],'options' => array('color' => $inp['color'])));
		Cart::update($rowId[0], $inp['qty']);
		return Response::json(array('type' => 'success','msg' => 'Se ha actualizado el carrito satisfactoriamente.'));
	}
	public function proceesCart()
	{
		if (Cart::count()<1) {
			Session::flash('danger','Lo sentimos, no posee articulos en el carrito');
			return Redirect::back();
		}
		$fac = new Facturas;
		$fac->user_id =  Auth::user()->id;
		$fac->total   = Cart::total();
		if($fac->save())
		{
			foreach (Cart::content() as $c) {
				$col = Colores::find($c->options['color']);
				$col->item_stock = $col->item_stock-$c->qty;
				if ($col->item_stock <= 0) {
					$col->deleted = 1;
				}
				$col->save();

				$itemFac = new FacturaItem;
				$itemFac->factura_id = $fac->id;
				$itemFac->item_id    = $c->id;
				$itemFac->qty 		 = $c->qty;
				$itemFac->color_id 	 = $c->options['color'];
				$itemFac->save();
				$col = Colores::where('item_id','=',$c->id)->where('deleted','=',0)->count();
				if ($col < 1) {
					$item = Items::find($c->id);
					$item->deleted = 1;
					$item->save();
					$data = array(
						'nombre' => $item->item_nomb,
						'cod'    => $item->item_cod,
					);
					$subject = 'Articulo borrado: '.$item->item_nomb;
					Mail::send('emails.runOut', $data, function($message) use($item,$subject)
					{
						$message->to('admin@NombreDeLaPag.com')->from('sistema@NombreDeLaPag.com')->subject($subject);
					});
				}
			}
			Cart::destroy();
			return Redirect::to('telefono/compra/procesar/'.$fac->id);			
		}
	}
	public function getFact($id)
	{
		$title = "Mi compra | NombreDeLaPag";
		$fac = Facturas::find($id);
		$facItem = FacturaItem::where('factura_id','=',$id)
		->join('items','items.id','=','factura_item.item_id')
		->join('colores','colores.id','=','factura_item.color_id')
		->join('images','items.id','=','images.item_id')
		->get(
			array(
				'items.id',
				'items.item_nomb',
				'items.item_prec as precio',
				'images.image',
				'colores.nombre as color',
				'factura_item.qty',
			)
		);
		return View::make('phone.home.myPurchase')
		->with('title',$title)
		->with('fac',$fac)
		->with('facItem',$facItem);
	}
	public function proceesPayment($id)
	{
		//Depende del cliente
		$fac = Facturas::find($id);
		$fac->status = 1;
		$fac->save();
		return Redirect::to('telefonos');
	}
}