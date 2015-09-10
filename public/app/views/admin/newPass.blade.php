@extends('layouts.admin')

@section('content')

<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="col-xs-8 contCentrado" style="margin-top:2em;">
				@if (Session::has('error'))
				<div class="col-xs-6">
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('error') }}</p>
					</div>
				</div>
				<div class="clearfix"></div>
				@elseif(Session::has('success'))
				<div class="col-xs-12">
					<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('success') }}</p>
					</div>
				</div>
				@endif
				<div class="col-xs-12 textoNegro">
						<legend>Cambiar contraseña</legend>
						<p class="textoPromedio">Un correo sera enviado al administrador.</p>
						<hr>
				</div>
				<form action="{{ URL::to('administrador/cambiar-contraseña/enviar') }}" method="POST">
					<div class="col-xs-12">
						<p class="textoPromedio">Un email le sera enviado con su nueva contraseña.</p>
					</div>
					<div class="col-xs-12 formulario">
						<label for="passnew" class="textoPromedio">Contraseña Actual:</label>
						<input type="password" name="passnew" class="form-control" required>
					</div>
					<div class="col-xs-12 formulario">
						<label for="pass" class="textoPromedio">Nueva Contraseña: </label>
						<input type="password" name="password" class="form-control" required>
					</div>
					<div class="col-xs-12 formulario">
						<label for="pass" class="textoPromedio">Nueva Contraseña: </label>
						<input type="password" name="password_re" class="form-control" required>
					</div>
					
					<div class="col-xs-12">
						<input type="submit" name="enviar" value="{{ Lang::get('lang.btn_send') }}" class="btn btn-primary">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop