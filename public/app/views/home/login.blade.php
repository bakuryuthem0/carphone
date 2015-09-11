@extends('layouts.default')

@section('content')
	<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-6 contCentrado contDeColor">
					<div class="login-form"><!--login form-->
						<legend><h2>Inicie Sesion en su cuenta</h2></legend>
						@if(Session::has('success'))
							<div class="alert alert-success">
								<p>{{ Session::get('success') }}</p>
							</div>
						@endif
						<div class="alert responseAjax">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						</div>
							<fieldset>
								<label for="">Usuario</label>
								<input type="text" placeholder="Usuario" class="login-input form-control username">
							</fieldset>
							<br>
							<fieldset>
								<input type="password" placeholder="Contraseña" class="login-input form-control password">
							</fieldset>
							<span class="checkbox">
								<input type="checkbox" class="checkbox checkbox-login"> 
								Recordar
							</span>
							<button type="submit" class="btn btn-default login">Login</button>
							<br>
							<br>
							<a href="{{ URL::to('registrarse') }}">¿No Tienes cuenta? Registrate</a>
							<br>
							<a href="">¿Olvidaste tu contraseña?</a>
					</div><!--/login form-->
				</div>
				
			</div>
		</div>
	</section><!--/form-->
@stop