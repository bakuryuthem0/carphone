@extends('layouts.admin')

@section('content')

<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="col-xs-8 contForm contdeColor contCentrado" style="margin-top:2em;">
				@if (Session::has('error'))
				<div class="col-xs-6">
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('error') }}</p>
					</div>
				</div>
				<div class="clearfix"></div>
				@endif
				<div class="col-xs-12 textoNegro">
					<div class="col-xs-12">
						<legend>Nueva sub-categoría</legend>
						<p class="textoPromedio">Llene el siguiente formulario para registrar una nueva sub-categorías.</p>
						<hr>
					</div>						
				</div>
				<form action="{{ URL::to('sub-categoria/nueva/enviar') }}" id="formRegister" method="POST" enctype="multipart/form-data">
					<div class="col-xs-12 formulario textoNegro">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Categoría:</p>
						</div>
						<div class="col-xs-12 inputRegister">
							<select name="cat" class="form-control cat inputForm inputFondoNegro" required>
								<option value="">Seleccione una categoría</option>
								@foreach($cat as $c)
									<option value="{{ $c->id }}">{{ $c->cat_desc }}</option>
								@endforeach
							</select>
							@if ($errors->has('name_color'))
								 @foreach($errors->get('name_color') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario textoNegro">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Nombre de la sub-categoría:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Nombre para las busquedas(sin acentro)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('name_subcat', Input::old('name_subcat'),array('data-trigger' => "blur",'class' => 'form-control cat_nomb inputForm inputFondoNegro','placeholder' => 'Nombre de la categoria',)) }}
							@if ($errors->has('name_subcat'))
								 @foreach($errors->get('name_subcat') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario textoNegro">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Título de la sub-categoría:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Título para mostrar la sub-categoría (puede tener acentro)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('desc_subcat',Input::old('desc_subcat'),array('class' => 'form-control inputForm cat_desc inputFondoNegro','placeholder' => 'Título de la categoría')) }}
							@if ($errors->has('desc_subcat'))
								 @foreach($errors->get('desc_subcat') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario textoNegro">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Imagen de portada:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Debe seleccionar una imagen</p>
						</div>
						<div class="col-xs-12 inputRegister">
							<input type="file" name="img" class="textoPromedio">
							@if ($errors->has('img'))
								 @foreach($errors->get('img') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-6 imgLiderUp">
							<input type="submit" id="enviar" name="enviar" value="Enviar" class="btn btn-success btnAlCien">
							<input type="reset" value="Borrar" class="btn btn-warning btnWarningRegister btnAlCien" >
						</div>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop