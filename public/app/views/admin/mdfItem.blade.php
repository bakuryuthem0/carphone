@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			@if(Session::has('danger'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p class="textoPromedio">{{ Session::get('danger') }}</p>
				</div>
			@elseif(Session::has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p class="textoPromedio">{{ Session::get('success') }}</p>
				</div>
			@endif
			<h3>Modificación de articulo</h3>
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingOne">
			      <h4 class="panel-title">
			        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
			          Información del articulo
			        </a>
			      </h4>
			    </div>
			    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
			      <div class="panel-body">
			        <form method="POST" action="{{ URL::to('administrador/modificar-articulo') }}">
						<input type="hidden" name="item" value="{{ $item->id }}">
						<div class="col-xs-6 inputForm">
							<label class="textoPromedio">(*) Codigo del articulo</label>
							<input type="text" name="item_cod" value="{{ $item->item_cod }}" class="form-control">
							@if ($errors->has('item_cod'))
								 @foreach($errors->get('item_cod') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
						<div class="col-xs-6 inputForm">
							<label class="textoPromedio">(*) Nombre de articulo</label>
							<input type="text" name="item_nomb" value="{{ $item->item_nomb }}" class="form-control">
							@if ($errors->has('item_nomb'))
								 @foreach($errors->get('item_nomb') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
						<div class="col-xs-12 inputForm">	
							<label class="textoPromedio">(*) Descripción del artículo</label>
							<textarea class="form-control editor" name="item_desc" placeholder="Descripción del artículo">{{ $item->item_desc }}</textarea>
							@if ($errors->has('item_desc'))
								 @foreach($errors->get('item_desc') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
						<div class="col-xs-12">
							<p class="bg-info textoPromedio" style="padding:0.5em;">En caso de no desear cambiar la categoria y la sub-categoria, omita estos campos</p>
						</div>
						<div class="col-xs-6 inputForm">	
							<label class="textoPromedio">(*) Categoría del artículo</label>
							<?php $arr = array(
										'' => 'Seleccione la Categoría');
										 ?>
								@foreach ($cat as $c)
									<?php $arr = $arr+array($c->id => $c->cat_desc);  ?>
								@endforeach
								
								{{ Form::select('cat',$arr,Input::old('cat'),array('class' => 'form-control catx','requied' => 'required')
									)}}
								
							@if ($errors->has('cat'))
								 @foreach($errors->get('cat') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio ">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
						<div class="col-xs-6 inputForm">	
							<label class="textoPromedio">Sub-categoría del artículo</label>
							<select name="subcat" class="form-control subcat">
								<option value="">Seleccione la sub-categoria</option>
							</select>					
							@if ($errors->has('subcat'))
								 @foreach($errors->get('subcat') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio ">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
						<div class="col-xs-12 inputForm">	
							<label class="textoPromedio">(*) Precio del artículo</label>
							{{ Form::text('item_precio', $item->item_precio, array('class' => 'form-control','placeholder' => 'Precio del artículo')) }}
							@if ($errors->has('item_precio'))
								 @foreach($errors->get('item_precio') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio ">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
						<div class="clearfix"></div>
						<div class="col-xs-12">
							<button class="btn btn-success" style="margin-top:1em;">Enviar</button>
							<input type="hidden" name="item" value="{{ $item->id }}">
						</div>
					</form>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingTwo">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
			          Crear nueva caracteristica.
			        </a>
			      </h4>
			    </div>
			    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
			      <div class="panel-body">
			        <div class="col-xs-12 formulario">
						<a href="{{ URL::to('administrador/nueva-caracteristica/'.$item->id) }}" class="btn btn-primary">
							Ir
						</a>
					</div>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingThree">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
			          Caracteristicas del articulo
			        </a>
			      </h4>
			    </div>
			    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
			      <div class="panel-body">
			    	   <div class="col-xs-12" style="margin-top:2em;padding:0px;">
							<div class="col-xs-12 contdeColor">
								<div class="col-xs-12">
									<p class="bg-info textoPromedio" style="padding:0.5em;">En caso de no desear cambiar la talla y el color, omita estos campos</p>
									<p class="bg-info textoPromedio" style="padding:0.5em;">Los cambios deben realizarce de uno en vez</p>
								</div>
								@foreach($item->misc as $m)
								<form method="POST" action="{{ URL::to('administrador/modificar-miscelania') }}">
									<div class="col-xs-12 inputForm" style="margin-top: 5em;">	
									<label class="textoPromedio">(*) Cantidad de artículos</label>
									{{ Form::text('item_stock', $m->item_stock, array('class' => 'form-control','placeholder' => 'Cantidad de artículos')) }}
									@if ($errors->has('item_stock'))
										 @foreach($errors->get('item_stock') as $err)
										 	<div class="alert alert-danger">
										 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
										 		<p class="textoPromedio ">{{ $err }}</p>
										 	</div>
										 @endforeach
									@endif
									</div>
									<div class="col-xs-6 inputForm">
										<label class="textoPromedio">Seleccione la talla</label>
										<select name="talla" class="form-control" required>
											<option value="">Seleccione una talla</option>
											@foreach ($tallas as $talla)
												@if($talla->id == $m->item_talla)
												<option value="{{ $talla->id }}" selected>{{ strtoupper($talla->talla_nomb).' - '.ucfirst($talla->talla_desc) }}</option>
												@else
												<option value="{{ $talla->id }}">{{ strtoupper($talla->talla_nomb).' - '.ucfirst($talla->talla_desc) }}</option>
												@endif
											@endforeach
											</select>
									</div>
									<div class="col-xs-6 inputForm">
										<label class="textoPromedio">Seleccione El color</label>
										<select name="color" class="form-control" required>
											<option value="">Seleccione una talla</option>
											@foreach ($colores as $color)
												@if($color->id == $m->item_color)
												<option value="{{ $color->id }}" selected>{{ ucfirst($color->color_desc) }}</option>
												@else
												<option value="{{ $color->id }}">{{ ucfirst($color->color_desc) }}</option>
												@endif
											@endforeach
											</select>
										<input type="hidden" name="misc" value="{{ $m->id }}">
										<input type="hidden" name="item" value="{{ $item->id }}">
									</div>
									
									<div class="col-xs-12">
										<button class="btn btn-primary" style="margin-top:1em;">Cambiar</button>
									</div>
								</form>
								@endforeach
							</div>
						</div>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading" role="tab" id="headingThree">
			      <h4 class="panel-title">
			        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
			          Modificar Imagenes
			        </a>
			      </h4>
			    </div>
			    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
			      <div class="panel-body">
			    	  <div class="col-xs-12" style="margin-top:2em;padding:0px;">
						<div class="col-xs-12 contdeColor">
							<div class="col-xs-12">
								<p class="bg-info textoPromedio" style="padding:0.5em;">Recuerde que para modificar las imagenes, debe de ser de una en vez. </p>
							</div>
							<div class="col-xs-12 formulario">
								<a href="{{ URL::to('administrador/cambiar-posicion/'.$item->id) }}" class="btn btn-primary">
									Cambiar orden de las imagenes.
								</a>
							</div>
							<div class="clearfix"></div>
							<div class="alert responseDanger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<table class="table table-hover tablaImages">
								<tbody>
									@foreach($item->img as $img) 
										@foreach($img as $i)
										<tr>
											<td>
												<img src="{{ asset('images/items/'.$i->image) }}" class="imageMdfAdmin image_{{ $i->id }}" data-src="{{ asset('images/items/'.$i->image) }}">
											</td>
											<td><form method="POST" action="{{ URL::to('administrador/cambiar-imagen') }}" enctype="multipart/form-data"><div class="fileUpload btn btn-primary">
												    <span>Cambiar</span>
												    
												    	<input type="file" name="file" class="upload" data-target=".image_{{ $i->id }}" />
												    	<input type="hidden" name="id" value="{{ $i->id }}">
												    	<input type="hidden" name="item_id" value="{{ $item->id }}">
												   
												</div> </form></td>
											<td><button class="btn btn-danger btn-elim-img" value="{{ $i->id }}" id="elim_{{ $i->id }}" data-toggle="modal" data-target="#modalElim">Eliminar</button></td>
										</tr>
										@endforeach
									@endforeach
								</tbody>
							</table>
						</div>
					</div> 
			      </div>
			    </div>
			  </div>
			</div>
			
			
			
		</div>
	</div>


<div class="modal fade" id="modalElim">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">¿Seguro desea eliminar esta imagen?</h4>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-eliminar-image">Eliminar</button>
			</div>
		</div>
	</div>
</div>

@stop

@section('postscript')
<script>

	CKEDITOR.disableAutoInline = true;

	$( document ).ready( function() {
		$( '.editor' ).ckeditor(); // Use CKEDITOR.replace() if element is <textarea>.
	    //Para navegadores antiguos
	} );
//Este string contiene una imagen de 1px*1px color blanco
window.imagenVacia = '';

window.mostrarVistaPrevia = function mostrarVistaPrevia(esto) {

    var Archivos, Lector;

    Archivos = esto[0].files;
    if (Archivos.length > 0) {

        Lector = new FileReader();
        Lector.onloadend = function(e) {
            var origen, tipo;

            //Envia la imagen a la pantalla
            origen = e.target; //objeto FileReader
            //Prepara la información sobre la imagen
            tipo = window.obtenerTipoMIME(origen.result.substring(0, 30));

            
            
            //Si el tipo de archivo es válido lo muestra, 
            //sino muestra un mensaje 
            if (tipo !== 'image/jpeg' && tipo !== 'image/png' && tipo !== 'image/gif') {
                jQuery(esto.data('target')).attr('src', $(esto.data('target')).data('src'));
                alert('El formato de imagen no es válido: debe seleccionar una imagen JPG, PNG o GIF.');
            } else {
                jQuery(esto.data('target')).attr('src', origen.result);
                window.obtenerMedidas();
            }

        };
        Lector.onerror = function(e) {
            console.log(e)
        }
        Lector.readAsDataURL(Archivos[0]);

    } else {
        var objeto = esto;
        objeto.replaceWith(objeto.val('').clone());
        jQuery(esto.data('target')).attr('src',$(esto.data('target')).data('src'));
        
        
    };


};

//Lee el tipo MIME de la cabecera de la imagen
window.obtenerTipoMIME = function obtenerTipoMIME(cabecera) {
    return cabecera.replace(/data:([^;]+).*/, '\$1');
}

//Obtiene las medidas de la imagen y las agrega a la 

window.obtenerMedidas = function obtenerMedidas() {
    jQuery('<img/>').bind('load', function(e) {

    }).attr('src', jQuery('.image_6').attr('src'));
}

jQuery(document).ready(function() {

    //El input del archivo lo vigilamos con un "delegado"
    jQuery('.upload').on('change', function(e) {

        window.mostrarVistaPrevia($(this));
    });

    //El botón Cancelar lo vigilamos normalmente

});
</script>

@stop