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
			        <form method="POST" action="{{ URL::to('articulo/editar-articulo/'.$item->id.'/enviar') }}">
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
						<div class="col-xs-12 inputForm">	
							<label class="textoPromedio">(*) Categoría del artículo</label>
							<select name="cat" class="form-control">
								@foreach($marcas as $m)
									@if($m->id == $item->item_marc)
										<option value="{{ $m->id }}" selected>{{ $m->nombre }}</option>
									@else
										<option value="{{ $m->id }}">{{ $m->nombre }}</option>
									@endif
								@endforeach
							</select>
							@if ($errors->has('cat'))
								 @foreach($errors->get('cat') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio ">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
						
						<div class="col-xs-12 inputForm">	
							<label class="textoPromedio">(*) Precio del artículo</label>
							{{ Form::text('item_precio', $item->item_prec, array('class' => 'form-control','placeholder' => 'Precio del artículo')) }}
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
			    	   		<p class="alert bg-info"><i class="fa fa-exclamation-triangle"></i> En caso de que no desee modificar una categoría, omitir el campo</p>
			    	   		<div class="alert responseDanger">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							</div>
							<form method="post" action="{{ URL::to('articulo/modificar-colores') }}" class="elimColorForm">
							@foreach($colores as $c)
							<div class="newColor col-xs-12 contdeColor" id="item_{{ $c->id }}">
								<div class="col-xs-12 col-md-4 inputForm contColorClon">	
									<label class="textoPromedio">Color</label>
									<input name="item_colorNuevo[{{ $c->id }}]" type="text" class="inputColor form-control" placeholder="Precio del artículo" value="{{ $c->nombre }}">
								</div>
								<div class="col-xs-12 col-md-4 inputForm contStockClon">	
									<label class="textoPromedio">Cantidad de artículos</label>
									<input name="item_stockNuevo[{{ $c->id }}]" type="text" class="inputStock form-control" placeholder="Cantidad de artículos" value="{{ $c->item_stock }}">
								</div>
								<div class="col-xs-12 col-md-4 inputForm contDelButton">	
									<button type="button" class="btn btn-default elimBtn" data-toggle="modal" data-target="#modalElim" data-url="{{ URL::to('articulo/color/eliminar') }}" value="{{ $c->id }}"><i class="fa fa-times"></i> Borrar</button>
								</div>
							</div>
							@endforeach
							</form>
							<div class="col-xs-12">
								<div class="col-xs-12">
									<button class="btn btn-success btnSendColors">Enviar</button>
								</div>
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
							<table class="table table-hover tablaImages table-centered">
								<thead>
									<th>
										Id
									</th>
									<th>
										Imagen
									</th>
									<th>
										Cambiar
									</th>
									<th>
										Eliminar
									</th>
								</thead>
								<tbody>
									@foreach($images as $i)
										<tr>
											<td>{{ $i->id }}</td>
											<td><img src="{{ asset('images/items/'.$i->image) }}" class="imgItem"></td>
											<td><a href="{{ URL::to('articulo/editar-imagen/'.$i->id) }}" class="btn btn-xs btn-warning">Cambiar</a></td>
											<td><button class="btn btn-xs btn-danger elimBtn" data-toggle="modal" data-target="#modalElim" data-url="{{ URL::to('articulo/imagenes/eliminar') }}" value="{{ $i->id }}">Eliminar</button></td>
										</tr>
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
				<button type="button" class="btn btn-danger envElim">Eliminar</button>
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
</script>

@stop