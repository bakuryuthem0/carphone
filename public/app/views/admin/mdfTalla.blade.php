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
				@endif
				<div class="col-xs-12 textoNegro">
					<div class="col-xs-12">
						<legend>Nueva Talla</legend>
						<p class="textoPromedio">Llene el siguiente formulario para registrar una nueva talla.</p>
						<hr>
					</div>						
				</div>
				<form action="{{ URL::to('talla/modificar/enviar/'.$talla->id) }}" id="formRegister" method="POST" enctype="multipart/form-data">
					<div class="col-xs-12 formulario textoNegro">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Talla:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Talla en letra(S/M/L)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('name_talla', $talla->talla_nomb,array('data-trigger' => "blur",'class' => 'form-control cat_nomb inputForm inputFondoNegro','placeholder' => 'Talla',)) }}
							@if ($errors->has('name_talla'))
								 @foreach($errors->get('name_talla') as $err)
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
							<p class="textoPromedio">Descripción de la talla:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* pequeña descripción de la talla EJ: Talla pequeña </p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('desc_talla',$talla->talla_desc,array('class' => 'form-control inputForm cat_desc inputFondoNegro','placeholder' => 'Descripción de la talla')) }}
							@if ($errors->has('desc_talla'))
								 @foreach($errors->get('desc_talla') as $err)
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