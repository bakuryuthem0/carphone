@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12 contCentrado contDeColor">
			<form method="POST" action="{{ URL::to('articulo/nuevo/enviar') }}" enctype="multipart/form-data">
				<legend>Nuevo articulo</legend>

				<p class="textoPromedio">(*) Campo obligatorio</p>
				@if(Session::has('error'))
				<div class="alert">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('error') }}
				</div>
				@endif
				<hr>
				<div class="col-xs-12 col-md-6 inputForm">
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
				<div class="col-xs-12 col-md-6 inputForm">	
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
				<div class="col-xs-12 col-md-6 inputForm">	
					<label class="textoPromedio">(*) Marca del artículo</label>
					<?php $arr = array(
								'' => 'Seleccione la Marca');
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
				
				<div class="col-xs-12 col-md-6 inputForm">	
					<label class="textoPromedio">(*) Precio del artículo</label>
					{{ Form::text('item_precio', Input::old('item_precio'), array('class' => 'form-control','placeholder' => 'Precio del artículo')) }}
					@if ($errors->has('item_precio'))
						 @foreach($errors->get('item_precio') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio ">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 col-md-6 inputForm">	
					<label class="textoPromedio">(*) Color</label>
					{{ Form::text('color', Input::old('color'), array('class' => 'form-control','placeholder' => 'Precio del artículo')) }}
					@if ($errors->has('color'))
						 @foreach($errors->get('color') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio ">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 col-md-6 inputForm">	
					<label class="textoPromedio">(*) Cantidad de artículos</label>
					{{ Form::text('item_stock', Input::old('item_nomb'), array('class' => 'form-control','placeholder' => 'Cantidad de artículos')) }}
					@if ($errors->has('item_stock'))
						 @foreach($errors->get('item_stock') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio ">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 col-md-12 inputForm">	
					<label class="textoPromedio">Imagen Principal</label>
					<input type="file" name="img1">
					@if ($errors->has('img1'))
						 @foreach($errors->get('img1') as $err)
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