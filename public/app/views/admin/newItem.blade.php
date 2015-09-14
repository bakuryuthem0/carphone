@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12 contCentrado contDeColor">
			<form method="POST" action="{{ URL::to('administrador/nuevo-articulo/enviar') }}">
			<legend>Nuevo articulo</legend>
			<p class="textoPromedio">(*) Campo obligatorio</p>
			<hr>
			<div class="col-xs-6 inputForm">
				<label class="textoPromedio">(*) Código del artículo</label>
				{{ Form::text('item_cod', Input::old('item_cod'), array('class' => 'form-control','placeholder' => 'Código del artículo')) }}
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
				<label class="textoPromedio">(*) Nombre del artículo</label>
				{{ Form::text('item_nomb', Input::old('item_nomb'), array('class' => 'form-control','placeholder' => 'Nombre del artículo')) }}
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
				<textarea class="form-control editor" name="item_desc" placeholder="Descripción del artículo">{{ Input::old('item_desc') }}</textarea>
				@if ($errors->has('item_desc'))
					 @foreach($errors->get('item_desc') as $err)
					 	<div class="alert alert-danger">
					 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					 		<p class="textoPromedio">{{ $err }}</p>
					 	</div>
					 @endforeach
				@endif
			</div>
			<div class="col-xs-6 inputForm">	
				<label class="textoPromedio">(*) Categoría del artículo</label>
				<?php $arr = array(
							'' => 'Seleccione la Categoría');
							 ?>
					@foreach ($phon as $c)
						<?php $arr = $arr+array($c->id => $c->nombre);  ?>
					@endforeach
					
					{{ Form::select('cat',$arr,Input::old('cat'),array('class' => 'form-control cat','requied' => 'required')
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
				{{ Form::text('item_precio_dol', Input::old('item_precio_dol'), array('class' => 'form-control','placeholder' => 'Precio del artículo')) }}
				@if ($errors->has('item_precio_dol'))
					 @foreach($errors->get('item_precio_dol') as $err)
					 	<div class="alert alert-danger">
					 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					 		<p class="textoPromedio ">{{ $err }}</p>
					 	</div>
					 @endforeach
				@endif
			</div>
			<div class="col-xs-12">
				<p class="bg-info textoPromedio" style="padding:0.5em;">Una vez que haga click en continuar, el artículo se creara y podrá agregar los detalles</p>
				<button class="btn btn-success">Continuar</button>
			</div>
			</form>

			
			<div class="clearfix"></div>
		</div>
	</div>
</div>

@stop

@section('postscript')
<script>

	CKEDITOR.disableAutoInline = true;

	$( document ).ready( function() {
		$( '.editor' ).ckeditor(); // Use CKEDITOR.replace() if element is <textarea>.
	} );

</script>

@stop