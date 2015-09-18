<?php

class AdminController extends BaseController {
	public function saveImage($id,$file)
	{
		$images = new Images;
		if (file_exists('images/items/'.$id.'/'.$file->getClientOriginalName())) {

			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/items/'.$id.'/'. $miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/items/".$id,$miImg);
            $blank = Intervention::make('images/blank.jpg');
            $img = Intervention::make('images/items/'.$id.'/'.$miImg);
           if ($img->width() > $img->height()) {
            	$img->widen(900);
            }else
            {
            	$img->heighten(1200);
            }
            
	        $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/items/'.$id.'/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $id.'/'.$miImg;
            }
		}else
		{
			$file->move("images/items/".$id,$file->getClientOriginalName());
			$blank = Intervention::make('images/blank.jpg');
			$img = Intervention::make('images/items/'.$id.'/'.$file->getClientOriginalName());
            if ($img->width() > $img->height()) {
            	$img->widen(900);
            }else
            {
            	$img->heighten(1200);
            }

            $blank->insert($img,'center')
           ->interlace()
           ->save('images/items/'.$id.'/'.$file->getClientOriginalName());
           $images->image = $id.'/'.$file->getClientOriginalName();
		}
		$images->item_id = $id;
		$images->save();
	}
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

	public function getAdminLogin()
	{
		$title = "Administrador | NombreDeLaTienda";
		return View::make('admin.login')->with('title',$title);
	}
	public function postAdminLogin()
	{

		$input = Input::all();
		if (isset($input['remember'])) {
			$valor = true;
		}else
		{
			$valor = false;
		}
		$find = User::where('username','=',$input['username'])->pluck('user_deleted');
		if ($find == 1) {
			Session::flash('error', 'Su usuario ha sido eliminado, para más información contáctenos desde nuestro módulo de contacto.');
			return Redirect::to('iniciar-sesion');
		}
		$userdata = array(
			'username' 	=> $input['username'],
			'password' 	=> $input['password']

		);
		$pass = User::where('username','=',$input['username'])->pluck('password');
		if (Auth::attempt($userdata,$valor)) {
			if (Auth::user()->role == 1) {

				return Redirect::to('administrador/inicio');	
			}else
			{
				return Redirect::to('/');
			}
		}else
		{
			Session::flash('error', 'Usuario o contraseña incorrectos');
			return Redirect::to('iniciar-sesion');
		}
		
	}
	public function logOut()
	{
		Auth::logout();
		return Redirect::to('/');
	}
	public function getIndex()
	{
		$title = "Inicio administrador | NombreDeLaTienda";
		return View::make('admin.index')->with('title',$title);
	}
	public function getNewItem()
	{
		$title = "Nuevo articulo | NombreDeLaTienda";
		$phon = Phones::where('deleted','=',0)
		->get();
		return View::make('admin.newItem')
		->with('title',$title)
		->with('phon',$phon);
	}

	public function postNewItem()
	{
		$input = Input::all();

		$rules = array(
			'cat'    		 => 'required',
			'item_cod'  	 => 'required|unique:items',
			'item_nomb' 	 => 'required|min:4',
			'item_desc' 	 => 'required|min:4',
            'item_precio'	 => 'required',
            'color'  		 => 'required',
            'item_stock'	 => 'required',
			'img1'			 => 'required|image',
		);
		$msg = array(
			'required' => 'El campo :attribute es obligatorio',
			'min'	   => 'El campo :attribute es muy corto(a)',
			'unique'   => 'El campo :attribute debe ser unico',
			'image'    => 'El campo :attribute debe ser una imagen',
		);
		$attr = array(
			'cat'        => 'categoría',
			'item_precio'=> 'precio',
			'item_cod'   => 'artículo',
			'item_nomb'  => 'artículo',
			'item_desc'  => 'artículo',
			'img1' 		 => 'Imagen principal',
			'item_stock' => 'Stock',
		);
		$validation = Validator::make($input, $rules, $msg, $attr);
		if ($validation->fails()) {
			return Redirect::back()->withErrors($validation)->withInput();
		}else
		{
			$item = new Items;
			$item->item_marc  = $input['cat']; 
			$item->item_cod   = $input['item_cod'];
			$item->item_nomb  = $input['item_nomb'];
			$item->item_desc  = $input['item_desc'];
            $item->item_prec  = $input['item_precio'];
			$item->save();

			$id = $item->id;
			$color = new Colores;
			$color->item_id 	= $id;
			$color->nombre  	= $input['color'];
			$color->item_stock  = $input['item_stock'];
			$color->save();
			if(Input::has('item_colorNuevo') && Input::has('item_stockNuevo'))
			{
				$colorNew = Input::get('item_colorNuevo');
				$stockNew = Input::get('item_stockNuevo');
				foreach ($colorNew as $i => $c) {
					if(!empty($c) && !empty($stockNew[$i]))
					{
						$color = new Colores;
						$color->item_id 	= $id;
						$color->nombre  	= $c;
						$color->item_stock  = $stockNew[$i];
						$color->save();
					}
				}
			}
			$img = Input::file('img1');
			$this->saveImage($id,$img);

			return Redirect::to('articulo/nuevo-articulo/continuar/'.$id);	
		}
	}
	public function getContinueNew($id)
	{
		$title = "Agregar imagenes";
		return View::make('admin.continueNew')
		->with('title',$title)
		->with('id',$id);
		
	}
	public function getImagesNew($id)
	{
		$title = "Cargar imagenes";
		return View::make('admin.newImage')
		->with('title',$title)
		->with('id',$id);
		;
	}
	public function post_upload()
	{

		$input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$messages = array(
			'image' => 'Todos los archivos deben ser imagenes',
			'max'	=> 'Las imagenes deben ser de menos de 3Mb'
		);
		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{
			return Response::make($validation)->withErrors($validation);
		}
		$id 	 = Input::get('art_id');
		$file 	 = Input::file('file');
		$this->saveImage($id,$file);
		$images = Images::where('item_id','=',$id)->orderBy('id','DESC')->first();
        return Response::json(array('image' => $images->id));
	}
	public function postDeleteImg()
	{
		$id 		= Input::get('image');
		$img = Images::find($id);
		$img->deleted = 1;
		File::delete('images/items/'.$img->image);
		$img->save();
		
		return Response::json(array('type' => 'success','msg' => 'Imagen eliminada satisfactoriamente'));
	}
	public function postDeleteImgMdf()
	{
		$id 		= Input::get('id');
		$img = Images::find($id);
		$img->deleted = 1;
		File::delete('images/items/'.$img->image);
		$img->save();
		
		return Response::json(array('type' => 'success','msg' => 'Imagen eliminada satisfactoriamente'));
	}
	public function getShowArt()
	{
		$title = "Articulos";
		$art = Items::get(array(
			'item_cod',
			'item_nomb',
			'id',
			'deleted'
		));
		return View::make('admin.showArt')
		->with('title',$title)
		->with('art',$art);
	}
	public function getMdfItem($id)
	{
		$title 	  = 'Modificar articulo';
		$item 	  = Items::find($id);
		$marcas   = Phones::where('deleted','=',0)->get();
		$colores  = Colores::where('item_id','=',$item->id)->where('deleted','=',0)->get();
		$imagenes = Images::where('item_id','=',$item->id)->where('deleted','=',0)->get();
		return View::make('admin.mdfItem')
		->with('title',$title)
		->with('item',$item)
		->with('colores',$colores)
		->with('images',$imagenes)
		->with('marcas',$marcas);
	}
	public function postMdfItem($id)
	{
		$inp = Input::all();
		$rules = array(
			'cat'    		 => 'required',
			'item_cod'  	 => 'required',
			'item_nomb' 	 => 'required|min:4',
			'item_desc' 	 => 'required|min:4',
            'item_precio'	 => 'required',
		);
		$msg = array(
			'required' => 'El campo no debe estar vacio',
			'min' 	   => 'El campo es muy corto'
		);
		$validator = Validator::make($inp, $rules, $msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}
		$item = Items::find($id);
		$item->item_cod  	= $inp['item_cod'];
		$item->item_nomb 	= $inp['item_nomb'];
		$item->item_desc 	= $inp['item_desc'];
		$item->item_prec	= $inp['item_precio'];
		if ($item->save()) {
			Session::flash('success', 'Articulo modificado satisfactoriamente.');
			return Redirect::back();
		}else
		{
			Session::flash('dager', 'Error al modificar el articulo.');
			return Redirect::back();
		}
	}
	public function postElimItemColor()
	{
		$id = Input::get('id');
		$colores = Colores::find($id);
		$colores->deleted = 1;
		if ($colores->save()) {
			return Response::json(array('type' => 'success','msg' => 'Color eliminado satisfactoriamente'));
		}
	}
	public function postModifyItemColors()
	{
		$inp = Input::all();

		foreach($inp['item_colorNuevo'] as $i => $c)
		{
			if (!empty($c) && !empty($inp['item_stockNuevo'][$i])) {
				$color = Colores::find($i);
				if(!is_null($color))
				{
					$color->nombre 		= $c;
					$color->item_stock  = $inp['item_stockNuevo'][$i];
					$color->save();
				}else
				{
					$color = new Colores;
					$color->item_id		= $inp['item_id'];
					$color->nombre 		= $c;
					$color->item_stock  = $inp['item_stockNuevo'][$i];
					$color->save();
				}
			}

		}
		return Redirect::back();
	}
	public function getNewMarca()
	{
		$title ="Nueva Marca";
		return View::make('admin.newCat')
		->with('title',$title);
	}
	public function postNewMarca()
	{
		$input = Input::all();
		$rules = array(
			'name_cat' => 'required',
		);
		$msg = array('required' => 'El campo es obligatorio');
		$validator = Validator::make($input, $rules, $msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$phon = new Phones;
		$phon->nombre = $input['name_cat'];
		if ($phon->save()) {
			Session::flash('success', 'Marca creada satisfactoriamente.');
			return Redirect::to('marcas/ver-marcas');
		}else
		{
			Session::flash('error', 'Error al guardar la nueva marca.');
			return Redirect::back();
		}
	}
	public function getModifyCat()
	{
		$title = "Ver categorías";
		$cat = Phones::where('deleted','=',0)->get();
		return View::make('admin.showCat')
		->with('title',$title)
		->with('cat',$cat);
	}
	public function getModifyCatById($id)
	{
		$phon = Phones::find($id);
		$title ="Modificar categoria: ".$phon->nombre;
		return View::make('admin.mdfCat')
		->with('title',$title)
		->with('phon',$phon);
	}
	public function postModifyCatById($id)
	{
		$input = Input::all();
		$rules = array(
			'name_cat' => 'required',
		);
		$msg = array('required' => 'El campo es obligatorio');
		$validator = Validator::make($input, $rules, $msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
		$phon = Phones::find($id);
		$phon->nombre = $input['name_cat'];
		if ($phon->save()) {
			Session::flash('success', 'Marca modificada satisfactoriamente.');
			return Redirect::to('marcas/ver-marcas');
		}else
		{
			Session::flash('error', 'Error al modificar la Marca.');
			return Redirect::back();
		}
	}
	
	public function getNewAdmin()
	{
		$title = "Crear nuevo administrador";
		return View::make('admin.newAdmin')->with('title',$title);
	}
	public function postNewAdmin()
	{
		$input = Input::all();
		$rules = array(
			'adminUser' => 'required|unique:usuario,username',
			'pass' 		=> 'required|min:8',
			'pass2' 	=> 'required|same:pass'
		);		
		$messages = array(
			'required' => ':attribute es obligatorio',
			'min'	   => ':attribute debe tener al menos 8 caracteres',
			'same'	   => ':attribute no coincide',
			'unique'   => ':attribute debe ser unico'
		);
		$attributes = array(
			'adminUser'  => 'El campo nombre de administrador',
			'pass'  	 => 'El campo contraseña nueva',
			'pass2'  	 => 'El campo repetir contraseña',
			'adminUser'  => 'El campo nombre de usuario'
		);
		$validator = Validator::make($input, $rules, $messages, $attributes);
		if ($validator->fails()) {
			return Redirect::to('administrador/crear-nuevo')->withErrors($validator)->withInput();
		}
		$user = new User;
		$user->username = $input['adminUser'];
		$user->password = Hash::make($input['pass']);
		$user->email    = $input['adminUser'].'@NombreDeLaTienda';
		$user->role     = 1;

		if ($user->save()) {
			$data = array(
				'username' => $input['adminUser'],
				'createBy' => Auth::user()->username
			);
			Mail::send('emails.newAdmin', $data, function ($message) use ($input){
				    $message->subject('Correo creacion de usuario NombreDeLaTienda');
				    $message->to('someemail@NombreDeLaTienda');
				});
			Session::flash('success', 'El usuario fue creado satisfactoriamente');
			return Redirect::to('administrador/crear-nuevo');
		}else
		{
			Session::flash('error', 'El usuario no e pudo crear.');
			return Redirect::to('administrador/crear-nuevo');
		}
	}
	public function getNewSlide()
	{
		$title = "Nueva imagen de fondo";
		$url = 'administrador/nueva-imagen/procesar';
		$url2 = 'administrador/nuevas-imagenes/procesar';
		return View::make('admin.newSlide')
		->with('title',$title)
		->with('url',$url)
		->with('url2',$url2);
	}
	public function getNewSlide2()
	{
		$title = "Nuevo slide";
		$url  = 'administrador/nuevo-slide/procesar';
		$url2 = 'administrador/nuevos-slides/procesar';
		return View::make('admin.newSlide')
		->with('title',$title)
		->with('url',$url)
		->with('url2',$url2);
	}
	public function postNewSlide()
	{
		$input = Input::all();
		$rules = array(
		    'img' => 'image|max:2000',
		);
		$messages = array(
			'image' => 'Todos los archivos deben ser imagenes',
			'max'	=> 'Las imagenes deben ser de menos de 3Mb'
		);
		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{
			return Redirect::to('administrador/nuevo-slide')->withErrors($validation);
		}
		$file = Input::file('img');
		$images = new Slides;
		if (file_exists('images/slides-top/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/slides-top/'.$miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/slides-top/",$miImg);
            $img = Image::make('images/slides-top/'.$miImg);
            $img->interlace()
	           ->save('images/slides-top/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $miImg;
            	$images->pos   = 1;
            }
		}else
		{
			$file->move("images/slides-top/",$file->getClientOriginalName());
			$img = Image::make('images/slides-top/'.$file->getClientOriginalName());
            $img->interlace()
            ->save('images/slides-top/'.$file->getClientOriginalName());
            $images->image = $file->getClientOriginalName();
            $images->pos   = 1;
		}
		if($images->save())
		{
			Session::flash('success','Imagen guardada correctamente');
			return Redirect::to('administrador/editar-slides');
		}else
		{
			Session::flash('danger','Error al guardar la imagen');
			return Redirect::to('administrador/nuevo-slide');
		}

	}
	public function post_upload_slides()
	{
		$input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$messages = array(
			'image' => 'Todos los archivos deben ser imagenes',
			'max'	=> 'Las imagenes deben ser de menos de 3Mb'
		);
		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{
			return Response::make($validation)->withErrors($validation);
		}
		$file = Input::file('file');
		$images = new Slides;
		if (file_exists('images/slides-top/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/slides-top/'.$miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/slides-top/",$miImg);
            $img = Image::make('images/slides-top/'.$miImg)
	           ->interlace()
	           ->save('images/slides-top/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $miImg;
            	$images->pos   = 1;
            }
		}else
		{
			$file->move("images/slides-top/",$file->getClientOriginalName());
			$img = Image::make('images/slides-top/'.$file->getClientOriginalName())->interlace()
           ->save('images/slides-top/'.$file->getClientOriginalName());
           $images->image = $file->getClientOriginalName();
           $images->pos   = 1;
		}
		$images->save();
        return Response::json(array('image' => $images->id));

        if( $upload_success ) {
        	return Response::json('success', 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	public function postNewSlide2()
	{
		$input = Input::all();
		$rules = array(
		    'img' => 'image|max:2000',
		);
		$messages = array(
			'image' => 'Todos los archivos deben ser imagenes',
			'max'	=> 'Las imagenes deben ser de menos de 3Mb'
		);
		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{
			return Redirect::to('administrador/nuevo-slide')->withErrors($validation);
		}
		$file = Input::file('img');
		$images = new Slides;
		if (file_exists('images/slides-top/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/slides-top/'.$miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/slides-top/",$miImg);
            $img = Image::make('images/slides-top/'.$miImg);
            $img->interlace()
	           ->save('images/slides-top/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $miImg;
            	$images->pos   = 2;
            }
		}else
		{
			$file->move("images/slides-top/",$file->getClientOriginalName());
			$img = Image::make('images/slides-top/'.$file->getClientOriginalName());
            $img->interlace()
            ->save('images/slides-top/'.$file->getClientOriginalName());
            $images->image = $file->getClientOriginalName();
            $images->pos   = 2;
		}
		if($images->save())
		{
			Session::flash('success','Imagen guardada correctamente');
			return Redirect::to('administrador/editar-slides');
		}else
		{
			Session::flash('danger','Error al guardar la imagen');
			return Redirect::to('administrador/nuevo-slide');
		}

	}
	public function post_upload_slides2()
	{
		$input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$messages = array(
			'image' => 'Todos los archivos deben ser imagenes',
			'max'	=> 'Las imagenes deben ser de menos de 3Mb'
		);
		$validation = Validator::make($input, $rules, $messages);

		if ($validation->fails())
		{
			return Response::make($validation)->withErrors($validation);
		}
		$file = Input::file('file');
		$images = new Slides;
		if (file_exists('images/slides-top/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/slides-top/'.$miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/slides-top/",$miImg);
            $img = Image::make('images/slides-top/'.$miImg)
	           ->interlace()
	           ->save('images/slides-top/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$images->image = $miImg;
            	$images->pos   = 2;
            }
		}else
		{
			$file->move("images/slides-top/",$file->getClientOriginalName());
			$img = Image::make('images/slides-top/'.$file->getClientOriginalName())->interlace()
           ->save('images/slides-top/'.$file->getClientOriginalName());
           $images->image = $file->getClientOriginalName();
           $images->pos   = 2;
		}
		$images->save();
        return Response::json(array('image' => $images->id));

        if( $upload_success ) {
        	return Response::json('success', 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	public function postDeleteSlide()
	{
		$file 		= Input::get('name');
		$id     	= Input::get('id');
		$img = Slides::find($id);
		$img->deleted = 1;
		File::delete('images/slides-top/'.$img->image);
		$img->save();
		return Response::json(array('llego' => 'llego'));
	}

	public function getEditSlides()
	{
		$title = 'Editar slides';
		$slides = Slides::where('deleted','=',0)->get();
		return View::make('admin.editSlides')->with('title',$title)->with('slides',$slides);
	}
	public function postEditSlides()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$st = Input::get('status');
			$slide = Slides::find($id);
			if ($st == 1) {
				$slide->active = 0;
			}else
			{
				$slide->active = 1;
			}
			if($slide->save())
			{
				return Response::json(array('type' => 'success','msg' => 'Slide activado satisfactoriamente'));
			}else
			{
				return Response::json(array('type' =>'danger','msg' =>'Error al activar el slide'));
			}
		}
	}
	public function postElimSlides()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$slides = Slides::find($id);
			File::delete('images/slides-top/'.$slides->image);
			$slides->deleted = 1;
			if($slides->save())
			{
				return Response::json(array('type' => 'success','msg' => 'Slide eliminado satisfactoriamente'));
			}else
			{
				return Response::json(array('type' =>'danger','msg' =>'Error al eliminar el slide'));
			}

		}
	}
	public function postElimItem()
	{
		$id = Input::get('id');
		$item = Items::find($id);
		$item->deleted = 1;
		if($item->save())
		{
			return Response::json(array('type' => 'success','msg' => 'Articulo eliminado satisfactoriamente'));
		}else
		{
			return Response::json(array('type' =>'danger','msg' =>'Error al eliminar el articulo'));
		}
	}
	public function postReactItem()
	{
		$id = Input::get('id');
		$item = Items::find($id);
		$misc = Misc::where('item_id','=',$id)->first();
		$img  = Images::where('misc_id','=',$misc->id)->get();
		$item->deleted = 0;
		$misc->deleted = 0;
		foreach ($img as $i) {
			$i->deleted = 0;
			$i->save();
		}
		
		if($item->save() && $misc->save())
		{
			return Response::json(array('type' => 'success','msg' => 'Articulo eliminado satisfactoriamente'));
		}else
		{
			return Response::json(array('type' =>'danger','msg' =>'Error al eliminar el articulo'));
		}
	}
	
	public function postMdfMisc()
	{
		$inp = Input::all();
		$misc = Misc::find($inp['misc']);

		if (!empty($inp['talla'])) {
			$misc->item_talla = $inp['talla'];
		}
		if (!empty($inp['color'])) {
			$misc->item_color = $inp['color'];
		}if(!empty($inp['item_stock']))
		{
			$misc->item_stock = $inp['item_stock'];
		}
		if (!empty($inp['item_stock'])) {
			$misc->item_stock = $inp['item_stock'];
		}
		if($misc->save())
		{
			Session::flash('success', 'Articulo modificado satisfactoriamente.');
			return Redirect::back();
		}else
		{
			Session::flash('dager', 'Error al modificar el articulo.');
			return Redirect::back();
		}

	}
	public function postElimImg()
	{
		$id = Input::get('id');
		$img = Images::find($id);
		$img->deleted = 1;
		if($img->save())
		{
			$image = $img->image;
			File::delete('images/items/'.$image);
			return Response::json(array('type' => 'success','msg' => 'Imagen borrada satisfactoriamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al guardar la imagen.'));
		}
	}
	public function changeItemImagen()
	{
		$id   	= Input::get('item_id');
		$file 	= Input::file('file');
		$img_id = Input::get('id'); 
		$imagen = Images::find($img_id);
		if (file_exists('images/items/'.$id.'/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/items/'.$id.'/'. $miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/items/".$id,$miImg);
            $blank = Image::make('images/blank.jpg');

            $img = Image::make('images/items/'.$id.'/'.$miImg);
           if ($img->width() > $img->height()) {
            	$img->widen(900);
            }else
            {
            	$img->heighten(1200);
            }
            
	        $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/items/'.$id.'/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$imagen->image = $id.'/'.$miImg;
            }
		}else
		{
			$file->move("images/items/".$id,$file->getClientOriginalName());
			$blank = Image::make('images/blank.jpg');
			$img = Image::make('images/items/'.$id.'/'.$file->getClientOriginalName());
            if ($img->width() > $img->height()) {
            	$img->widen(900);
            }else
            {
            	$img->heighten(1200);
            }

            $blank->insert($img,'center')
           ->interlace()
           ->save('images/items/'.$id.'/'.$file->getClientOriginalName());
           $imagen->image = $id.'/'.$file->getClientOriginalName();
		}
		if($imagen->save())
		{
			Session::flash('success', 'Imagen modificada correctamente.');
			return Redirect::back();
		}else
		{
			Session::flash('danger', 'Error al modificar la imagen.');
			return Redirect::back();
		}
	}
	public function getPayment()
	{
		$title = "Pagos | NombreDeLaTienda";
		$fac = Facturas::join('usuario','usuario.id','=','facturas.user_id')
		->leftJoin('departamento','departamento.id','=','usuario.department')
		->leftJoin('bancos','bancos.id','=','facturas.banco')
		->leftJoin('sucursal','sucursal.id','=','facturas.dir')
		->where('pagada','=',-1)->orderBy('facturas.id','DESC')
		->get(
			array(
				'usuario.id as user_id',
				'usuario.username',
				'usuario.dir as user_dir',
				'usuario.nombre',
				'usuario.apellido',
				'usuario.telefono',
				'usuario.email',
				'departamento.nombre as dep_name',
				'sucursal.nombre as sucursal',
				'facturas.*',
				'bancos.banco'
			)
		);
		$facNot  = Facturas::join('direcciones','direcciones.id','=','facturas.dir')
		->join('usuario','usuario.id','=','facturas.user_id')
		
		->where('facturas.deleted','=',0)
		->where('facturas.created_at','<=',date('Y-m-d',(time()-(86400*5))))
		->where('pagada','=',0)->orderBy('facturas.id','DESC')
		->get(
			array(
				'usuario.id as user_id',
				'usuario.username',
				'usuario.dir as user_dir',
				'usuario.nombre',
				'usuario.apellido',
				'usuario.telefono',
				'usuario.email',
				
				'facturas.*',
				'direcciones.email',
				'direcciones.dir as dir_name',
			)
		);
		return View::make('admin.showPayment')
		->with('title',$title)
		->with('fac',$fac)
		->with('facNot',$facNot);
	}
	public function getPurchases($id)
	{
		$title = "Ver factura | NombreDeLaTienda";

		$fac = Facturas::find($id);
		$x 	 = FacturaItem::where('factura_id','=',$id)->sum('item_qty');
		$aux = FacturaItem::where('factura_id','=',$id)->get(array('item_id','item_qty'));
		$i = 0;
		foreach ($aux as $a) {
			$b = Items::find($a->item_id);
			$b->qty = $a->item_qty;
			$aux = Misc::where('item_id','=',$a->item_id)->where('deleted','=',0)->first();
			$item[$i] = $b;
			$i++;

		}
		$total = 0;
		return View::make('admin.showFactura')
		->with('title',$title)
		->with('total',$total)
		->with('items',$item)
		->with('id',$id);
	}
	public function postPaymentAprove()
	{
		$id  = Input::get('id');
		$fac = Facturas::find($id);
		$fac->pagada = 1;
		$user = User::find($fac->user_id);
		if($fac->save())
		{
			$data = array(
				'username' => Auth::user()->username,
				'fac'  	   => $id,
				'fecha'	   => date('d-m-Y',time())
			);
			Mail::send('emails.aprob', $data, function ($message) use ($id,$user){
				    $message->subject('Correo de aviso niaboutique.com');
				    $message->to($user->email);
			});
			return Response::json(array('type' => 'success','msg' => 'Pago Aprobado correctamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al aprobar el pago.'));
		}
	}
	public function postPaymentElim()
	{
		$id = Input::get('id');
		$motivo = Input::get('motivo');
		$fac = Facturas::find($id);
		$fi  = FacturaItem::where('factura_id','=',$fac->id)->get();
		foreach ($fi as $f) {
			$item = Misc::where('item_id','=',$f->item_id)
			->where('item_talla','=',$f->item_talla)
			->where('item_color','=',$f->item_color)
			->first();
			$item->item_stock = $item->item_stock+$f->item_qty;
			$item->save();

		}
		$fac->deleted = 1;
		$fac->save();
		$user = User::find($fac->user_id);
		if ($fac->save()) {
			$data = array(
				'username' => Auth::user()->username,
				'fac'  	   => $id,
				'fecha'	   => date('d-m-Y',time()),
				'motivo'   => $motivo,
			);
			Mail::send('emails.reject', $data, function ($message) use ($id,$motivo,$user){
				    $message->subject('Correo de aviso niaboutique.com');
				    $message->to($user->email);
			});
			return Response::json(array('type' => 'success','msg' => 'Pago eliminado correctamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al eliminar el pago.'));
		}
	}
	public function postPaymentReject()
	{
		$id = Input::get('id');
		$motivo = Input::get('motivo');
		$fac = Facturas::find($id);
		$fac->pagada = 0;
		$user = User::find($fac->user_id);
		if ($fac->save()) {
			$data = array(
				'username' => Auth::user()->username,
				'fac'  	   => $id,
				'fecha'	   => date('d-m-Y',time()),
				'motivo'   => $motivo,
			);
			Mail::send('emails.reject', $data, function ($message) use ($id,$motivo,$user){
				    $message->subject('Correo de aviso NombreDeLaTienda');
				    $message->to($user->email);
			});
			return Response::json(array('type' => 'success','msg' => 'Pago Rechazado correctamente.'));
		}else
		{
			return Response::json(array('type' => 'danger','msg' => 'Error al Rechazar el pago.'));
		}
	}
	public function getPaymentAproved()
	{
		$title = "Pagos aprobados";
		$title = "Pagos | NombreDeLaTienda";
		$fac = Facturas::join('direcciones','direcciones.id','=','facturas.dir')
		->join('usuario','usuario.id','=','facturas.user_id')
		
		->leftJoin('bancos','bancos.id','=','facturas.banco')
		->where('pagada','=',1)->orderBy('facturas.id','DESC')
		->get(
			array(
				'usuario.id as user_id',
				'usuario.username',
				'usuario.dir as user_dir',
				'usuario.nombre',
				'usuario.apellido',
				'usuario.telefono',
				'usuario.email',
				
				'facturas.*',
				'direcciones.email',
				'direcciones.dir as dir_name',
				'bancos.banco'
			)
		);
		$type = "apr";
		return View::make('admin.showPayment')
		->with('title',$title)
		->with('fac',$fac)
		->with('type',$type);
	}
	public function getNewBank()
	{
		$title = "Nuevo banco";
		return View::make('admin.newBank')
		->with('title',$title);
	}
	public function postNewBank()
	{
		$inp 	= Input::all();
		$rules  = array(
			'banco' 		=> 'required',
			'numCuenta'		=> 'required',
			'tipoCuenta'	=> 'required',
			'url'	=> 'required',

			'img'			=> 'required|image|max:3000'
		);

		$msg 	= array(
			'required'	=> 'El campo es obligatorio',
			'image'		=> 'El archivo debe ser una imagen',
			'max'		=> 'El archivo no debe tener mas de 3Mb'
		);
		$validator = Validator::make($inp,$rules,$msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$banco = new Bancos;
		$banco->banco 		= $inp['banco'];
		$banco->num_cuenta	= $inp['numCuenta'];
		$banco->tipo 		= $inp['tipoCuenta'];
		$banco->tipo 		= $inp['tipoCuenta'];
		$banco->link 		= $inp['url'];

		$file = Input::file('img');
		if (file_exists('images/bancos/'.$file->getClientOriginalName())) {
			//guardamos la imagen en public/imgs con el nombre original
            $i = 0;//indice para el while
            //separamos el nombre de la img y la extensión
            $info = explode(".",$file->getClientOriginalName());
            //asignamos de nuevo el nombre de la imagen completo
            $miImg = $file->getClientOriginalName();
            //mientras el archivo exista iteramos y aumentamos i
            while(file_exists('images/bancos/'. $miImg)){
                $i++;
                $miImg = $info[0]."(".$i.")".".".$info[1];              
            }
            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
            $file->move("images/bancos/",$miImg);
            $blank = Image::make('images/b200.jpg');

            $img = Image::make('images/bancos/'.$miImg);
            if ($img->width() > $img->height()) {
            	$img->widen(300);
            }else
            {
            	$img->heighten(300);
            }
            if ($img->width() > 300) {
	            	$img->widen(300);
	            }
	        $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/bancos/'.$miImg);
            if($miImg != $file->getClientOriginalName()){
            	$banco->imagen = $miImg;
            }
		}else
		{
			$file->move("images/bancos/",$file->getClientOriginalName());
			$blank = Image::make('images/b200.jpg');
			$img = Image::make('images/bancos/'.$file->getClientOriginalName());
            if ($img->width() > $img->height()) {
            	$img->widen(300);
            }else
            {
            	$img->heighten(300);
            }
            if ($img->width() > 300) {
	            	$img->widen(300);
	            }
            $blank->insert($img,'center')
           ->interlace()
           ->save('images/bancos/'.$file->getClientOriginalName());
           $banco->imagen = $file->getClientOriginalName();
		}
		if ($banco->save()) {
			Session::flash('success', 'Banco creado satisfactoriamente');
			return Redirect::to('administrador/editar-banco');
		}else
		{
			Session::flash('error','Error al crear el banco');
			return Redirect::back();
		}
	}
	public function getEditBank()
	{
		$title = "Editar bancos";
		$bancos = Bancos::where('deleted','=',0)->get();
		return View::make('admin.editBanks')
		->with('title',$title)
		->with('bancos',$bancos);
	}
	public function getEditBankId($id)
	{
		$title ="Editar banco";
		$banco = Bancos::find($id);
		return View::make('admin.editBankSelf')
		->with('title',$title)
		->with('banco',$banco);
	}
	public function postEditBankId($id)
	{
		$inp 	= Input::all();
		$rules  = array(
			'banco' 		=> 'required',
			'numCuenta'		=> 'required',
			'tipoCuenta'	=> 'required',
			'url'			=> 'required'
		);

		$msg 	= array(
			'required'	=> 'El campo es obligatorio'
		);
		$validator = Validator::make($inp,$rules,$msg);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$banco 				= Bancos::find($id);
		$banco->banco 		= $inp['banco'];
		$banco->num_cuenta	= $inp['numCuenta'];
		$banco->tipo 		= $inp['tipoCuenta'];
		$banco->link 		= $inp['url'];

		if (Input::hasFile('img')) {
			$file = Input::file('img');
			if (file_exists('images/bancos/'.$file->getClientOriginalName())) {
				//guardamos la imagen en public/imgs con el nombre original
	            $i = 0;//indice para el while
	            //separamos el nombre de la img y la extensión
	            $info = explode(".",$file->getClientOriginalName());
	            //asignamos de nuevo el nombre de la imagen completo
	            $miImg = $file->getClientOriginalName();
	            //mientras el archivo exista iteramos y aumentamos i
	            while(file_exists('images/bancos/'. $miImg)){
	                $i++;
	                $miImg = $info[0]."(".$i.")".".".$info[1];              
	            }
	            //guardamos la imagen con otro nombre ej foto(1).jpg || foto(2).jpg etc
	            $file->move("images/bancos/",$miImg);
	            $blank = Image::make('images/b200.jpg');

	            $img = Image::make('images/bancos/'.$miImg);
	            if ($img->width() > $img->height()) {
	            	$img->widen(300);
	            }else
	            {
	            	$img->heighten(300);
	            }
	            if ($img->width() > 300) {
	            	$img->widen(300);
	            }
		        $blank->insert($img,'center')
		           ->interlace()
		           ->save('images/bancos/'.$miImg);
	            if($miImg != $file->getClientOriginalName()){
	            	$banco->imagen = $miImg;
	            }
			}else
			{
				$file->move("images/bancos/",$file->getClientOriginalName());
				$blank = Image::make('images/b200.jpg');
				$img = Image::make('images/bancos/'.$file->getClientOriginalName());
	            if ($img->width() > $img->height()) {
	            	$img->widen(300);
	            }else
	            {
	            	$img->heighten(300);
	            }
                    if ($img->width() > 300) {
	            	$img->widen(300);
	            }
	            $blank->insert($img,'center')
	           ->interlace()
	           ->save('images/bancos/'.$file->getClientOriginalName());
	           $banco->imagen = $file->getClientOriginalName();
			}
		}
		if ($banco->save()) {
			Session::flash('success', 'Banco creado satisfactoriamente');
			return Redirect::to('administrador/editar-banco');
		}else
		{
			Session::flash('error','Error al crear el banco');
			return Redirect::back();
		}
	}
	public function postElimBank()
	{
		if (Request::ajax()) {
			$id = Input::get('id');
			$banco = Bancos::find($id);
			$banco->deleted = 1;
			if ($banco->save()) {
				return Response::json(array('type' => 'success','msg' => 'Banco eliminado satisfactoriamente'));
			}else
			{
				return Response::json(array('type' => 'danger','msg' => 'Error al eliminar el banco'));
			}
		}
	}
	public function newCategoriaMdf()
	{
		$input = Input::all();
		$rules = array(
			'item_stock' 	=> 'required|min:1',
			'talla' 		=> 'required',
			'color' 		=> 'required'
		);
		$msg = array('required' => 'El campo :attribute es obligatorio');
		$validator = Validator::make($input, $rules,$msg);
		if ($validator->fails()) {
			return Redirect::back()->withInput()->withErrors($validator);
		}
		$misc = new Misc;
		$misc->item_id 	  = $input['art'];
		$misc->item_talla = $input['talla'];
		$misc->item_color = $input['color'];
		$misc->item_stock = $input['item_stock'];
		if ($misc->save()) {
			Session::flash('success', 'Categorai añadida satisfactoriamente');
			return Redirect::to('administrador/editar-articulo/'.$misc->item_id);
		}else
		{
			Session::flash('danger', 'error al articulo satisfactoriamente');
			return Redirect::back();
		}
	}
	public function getNewPass()
	{
		$title = "Cambiar contraseña";
		return View::make('admin.newPass')
		->with('title',$title);
	}
	public function getNewMisc($id)
	{
		$title = "Nueva Caracteristica";
		$item = Items::find($id);
		$misc = Misc::where('item_id','=',$item->id)->get();
		
		$item->misc = $misc;

		$cat = Cat::where('deleted','=',0)->get();
		$tallas = Tallas::where('deleted','=',0)->get();
		$colors = Colores::where('deleted','=',0)->get();
		return View::make('admin.newMisc')
		->with('title',$title)
		->with('item',$item)
		->with('cat',$cat)
		->with('tallas',$tallas)
		->with('colores',$colors);
	}
	public function getNewImgPos($id)
	{
		$title ="Cambiar posición de las imagenes";

		$item = Items::find($id);
		$misc = Misc::where('item_id','=',$item->id)->get(array('id'));
		$images = array();
		$j = 0;

		foreach ($misc as $m) {
			$x = Images::where('misc_id','=',$m->id)->where('deleted','=',0)->get(array('id','misc_id','image','order'));
			foreach ($x as $y) {
				$aux = new stdClass;
				$aux->id      = $y->id;
				$aux->misc_id = $y->misc_id;
				$aux->image   = $y->image;
				$aux->order   = $y->order;
				$images[$j]  = $aux;
				
				$j++;
			}
		}
		for($i = 0;$i < count($images);$i++)
		{
			for ($j=0; $j < count($images)-1 ; $j++) { 
				if ($images[$j]->order > $images[$j+1]->order) {
					$bub = new stdClass;
					$bub 				= $images[$j+1];
					$images[$j+1] 		= $images[$j];
					$images[$j] 		= $bub;	
				}
			}
		}
		
		return View::make('admin.changeImagePos')
		->with('title',$title)
		->with('item',$images);

	}
	public function postChangePost()
	{
		$id = Input::get('ids');
		$i = 0;
		foreach ($id as $k) {
			$img = Images::find($id[$i]);
			$img->order = $i+1;
			$img->save();
			$i++;
		}
		$x = 0;
		
		return Response::json(array('type' => 'success','msg' => 'Imagenes cambiadas de posición satisfactoriamente.'));
	}
}