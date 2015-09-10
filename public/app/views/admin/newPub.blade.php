@extends('layouts.admin')

@section('content')

<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-6 contdeColor contCentrado">
				@if(Session::has('success'))
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('success') }}</p>
					</div>
				@elseif(Session::has('danger'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p class="textoPromedio">{ Session::get('danger') }}</p>
				</div>
				@endif
				<legend>Nueva Publicidad</legend>
				<p class="bg-info textoPromedio" style="padding:0.5em;">Elija la publicidad que desea editar</p>
				<p class="bg-danger textoPromedio" style="padding:0.5em;"><i class="fa fa-exclamation-triangle"></i> Recuerde que esta accion cambiara la publicidad anterior</p>
				<div class="bg-primary textoPromedio contOptionA" style="padding:0.5em;">
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".grande" style="color:white;">Publicidad principal </a>
					</div>
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".izquierda" style="color:white;">Publicidad izquierda </a>
					</div>
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".derecha" style="color:white;">Publicidad derecha</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="grande imagesSlidesOption textoPromedio">
					<form method="POST" action="{{ URL::to('administrador/nueva-publicidad/procesar') }}" enctype="multipart/form-data">
						<label>Imagen:</label>
						<input type="file" name="img">
						@if ($errors->has('img'))
							 @foreach($errors->get('img') as $err)
							 	<div class="alert alert-danger error">
							 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 		<p class="">{{ $err }}</p>
							 	</div>
							 @endforeach
						@endif
						<br>
						<p class="bg-info " style="padding:0.5em;">Introduzca el codigo del articulo</p>
						<label>Articulo:</label>
						<input type="text" name="item" placeholder="Codigo del articulo" class="form-control">
						@if ($errors->has('item'))
							 @foreach($errors->get('item') as $err)
							 	<div class="alert alert-danger error">
							 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 		<p class="">{{ $err }}</p>
							 	</div>
							 @endforeach
						@endif
						<button class="btn btn-success btn-xs" style="margin-top:1em;">Enviar</button>
						<input type="hidden" name="position" value="top">
					</form>
				</div>
				<div class="izquierda imagesSlidesOption textoPromedio">
					<form method="POST" action="{{ URL::to('administrador/nueva-publicidad/procesar') }}" enctype="multipart/form-data">
						<label>Imagen:</label>
						<input type="file" name="img">
						@if ($errors->has('img'))
							 @foreach($errors->get('img') as $err)
							 	<div class="alert alert-danger error">
							 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 		<p class="">{{ $err }}</p>
							 	</div>
							 @endforeach
						@endif
						<br>
						<p class="bg-info " style="padding:0.5em;">Introduzca el codigo del articulo</p>
						<label>Articulo:</label>
						<input type="text" name="item" placeholder="Codigo del articulo" class="form-control">
						@if ($errors->has('item'))
							 @foreach($errors->get('item') as $err)
							 	<div class="alert alert-danger error">
							 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 		<p class="">{{ $err }}</p>
							 	</div>
							 @endforeach
						@endif
						<button class="btn btn-success btn-xs" style="margin-top:1em;">Enviar</button>
						<input type="hidden" name="position" value="left">
					</form>
				</div>
				<div class="derecha imagesSlidesOption textoPromedio">
					<form method="POST" action="{{ URL::to('administrador/nueva-publicidad/procesar') }}" enctype="multipart/form-data">
						<label>Imagen:</label>
						<input type="file" name="img">
						@if ($errors->has('img'))
							 @foreach($errors->get('img') as $err)
							 	<div class="alert alert-danger error">
							 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 		<p class="">{{ $err }}</p>
							 	</div>
							 @endforeach
						@endif
						<br>
						<p class="bg-info " style="padding:0.5em;">Introduzca el codigo del articulo</p>
						<label>Articulo:</label>
						<input type="text" name="item" placeholder="Codigo del articulo" class="form-control">
						@if ($errors->has('item'))
							 @foreach($errors->get('item') as $err)
							 	<div class="alert alert-danger error">
							 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							 		<p class="">{{ $err }}</p>
							 	</div>
							 @endforeach
						@endif
						<button class="btn btn-success btn-xs" style="margin-top:1em;">Enviar</button>
						<input type="hidden" name="position" value="right">
					</form>
				</div>
				
				<div class="bg-primary textoPromedio volver" style="padding:0.5em;margin-top:1em;">
					
					<div class="col-xs-12">
						<a href="#"style="color:white;">Volver</a>
					</div>
					<div class="clearfix"></div>
				</div>

			</div>
		</div>
	</div>
</div>

@stop