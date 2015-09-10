@extends('layouts.admin')
@section('content')
<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="contCentrado col-xs-6 contdeColor" style="margin-top:2em;">
				<form action="{{ URL::to('administrador/iniciar-sesion/autenticar') }}" method="POST">
					@if (Session::has('error'))
					<div class="col-xs-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="textoPromedio">{{ Session::get('error') }}</p>
						</div>
					</div>
					<div class="clearfix"></div>
					@endif
					<div class="col-xs-12">
						<label for="username" class="textoPromedio">Nombre de usuario:</label>
						{{ Form::text('username','', array('class'=>'form-control','required' => 'required')) }}
					</div>
					<div class="clearfix"></div>
					<div class="col-xs-12">
						<label for="pass" class="textoPromedio">Contraseña</label>
						<input type="password" name="password" class="form-control" required>
					</div>
					
					<div class="col-xs-12">
						<label for="remember" class="textoPromedio">¿Recordar?</label>
						<input type="checkbox" name="remember">
					</div>
					<div class="col-xs-12">
						<input type="submit" name="enviar" value="Enviar" class="btn btn-primary">
					</div>
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	
</div>
@stop