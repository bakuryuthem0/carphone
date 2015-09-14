@extends('layouts.admin')

@section('content')

<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="col-xs-8 contCentrado contDeColor" style="margin-top:2em;">
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
						<legend>Nueva marca</legend>
						<p class="textoPromedio">Llene el siguiente formulario para registrar una nueva marcas.</p>
						<hr>
					</div>						
				</div>
				<form action="{{ URL::to('marca/nueva/enviar') }}" id="formRegister" method="POST" enctype="multipart/form-data">
					<div class="col-xs-12 formulario textoNegro">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Nombre de la marca:</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('name_cat', Input::old('name_cat'),array('data-trigger' => "blur",'class' => 'form-control cat_nomb inputForm inputFondoNegro','placeholder' => 'Nombre de la marca',)) }}
							@if ($errors->has('name_cat'))
								 @foreach($errors->get('name_cat') as $err)
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
						</div>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop