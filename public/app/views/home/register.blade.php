@extends('layouts.default')

@section('content')
<section id="contenedor"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-10 contCentrado contDeColor">
					<div class="login-form"><!--login form-->
						<legend><h2>Registro de Usuario</h2></legend>
						<div class="alert responseAjax">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
						<form method="POST" action="{{ URL::to('registrarse/enviar') }}" class="form-register">
							<fieldset>
								<label for="">Nombre de usuario</label>
								<input type="text" name="user" placeholder="Usuario" class="login-input form-control register-input username" value="{{ Input::old('user') }}">
								@if ($errors->has('user'))
								 @foreach($errors->get('user') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
							</fieldset>
							<br>
							<fieldset>
								<label for="">Contraseña</label>
								<input type="password" name="pass" placeholder="Contraseña" class="login-input form-control register-input password" value="{{ Input::old('pass') }}">
								@if ($errors->has('pass'))
								 @foreach($errors->get('pass') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
							</fieldset>
							<fieldset>
								<label for="">Repita la Contraseña</label>
								<input type="password" name="pass_confirmation" placeholder="Contraseña" class="login-input form-control register-input password2" value="{{ Input::old('pass_confirmation') }}">
								@if ($errors->has('pass2'))
								 @foreach($errors->get('pass2') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
							</fieldset>
							<fieldset>
								<label for="">Email</label>
								<input type="email" name="email" placeholder="Usuario" class="login-input form-control register-input email" value="{{ Input::old('email') }}">
								@if ($errors->has('email'))
								 @foreach($errors->get('email') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
							</fieldset>
						</form>
						<button class="btn btn-default register">Enviar</button>
							
					</div><!--/login form-->
				</div>
				
			</div>
		</div>
	</section><!--/form-->
@stop