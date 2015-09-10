@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-8 contCentrado contdeColor">
			<h3>Nuevo banco</h3>
			<form method="POST" action="{{ URL::to('administrador/agregar-bancos/enviar') }}" enctype="multipart/form-data">
				<div class="col-xs-12 formulario textoPromedio">
					<label>Banco</label>
					<input type="text" name="banco" class="form-control">
					@if ($errors->has('banco'))
						 @foreach($errors->get('banco') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 formulario textoPromedio">
					<label>Link del banco</label>
					<input type="text" name="url" class="form-control">
					@if ($errors->has('url'))
						 @foreach($errors->get('url') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 formulario textoPromedio">
					<label>Numero de cuenta</label>
					<input type="text" name="numCuenta" class="form-control">
					@if ($errors->has('numCuenta'))
						 @foreach($errors->get('numCuenta') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 formulario textoPromedio">
					<label>Tipo de cuenta</label>
					<input type="text" name="tipoCuenta" class="form-control">
					@if ($errors->has('tipoCuenta'))
						 @foreach($errors->get('tipoCuenta') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 formulario textoPromedio">
					<label>Imagen del banco</label>
					<input type="file" name="img">
					@if ($errors->has('img'))
						 @foreach($errors->get('img') as $err)
						 	<div class="alert alert-danger">
						 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						 		<p class="textoPromedio">{{ $err }}</p>
						 	</div>
						 @endforeach
					@endif
				</div>
				<div class="col-xs-12 formulario">
					<button class="btn btn-success">
						Enviar
					</button>
				</div>
			</form>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
@stop