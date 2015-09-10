@extends('layouts.admin')

@section('content')

<div class="container contenedorUnico">
	<div class="row">
		<div class="col-xs-12">
			
			<div class="col-xs-8 contForm contdeColor contCentrado" style="margin-top:2em;">
				@if (Session::has('error'))
				<div class="col-xs-6">
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<p class="textoPromedio">{{ Session::get('error') }}</p>
					</div>
				</div>
				<div class="clearfix"></div>
				@endif
				<div class="col-xs-12">
					<div class="col-xs-12">
						<legend>Modificación de la sub-categoría</legend>
						<p class="textoPromedio">Llene el siguiente formulario para modificar la sub-categorías.</p>
						<hr>
					</div>						
				</div>
				<form action="{{ URL::to('administrador/ver-sub-categoria/modificar/'.$subcat->id) }}" id="formRegister" method="POST" enctype="multipart/form-data">
					<div class="col-xs-12 formulario">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Categoría:</p>
						</div>
						<div class="col-xs-12 inputRegister">
							<select name="cat" class="form-control cat inputForm inputFondoNegro" required>
								<option value="">Seleccione una categoría</option>
								@foreach($cat as $c)
									@if($subcat->cat_id == $c->id)
									<option value="{{ $c->id }}" selected>{{ $c->cat_desc }}</option>
									@else
									<option value="{{ $c->id }}">{{ $c->cat_desc }}</option>
									@endif
								@endforeach
							</select>
							@if ($errors->has('name_color'))
								 @foreach($errors->get('name_color') as $err)
								 	<div class="alert alert-danger">
								 		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								 		<p class="textoPromedio">{{ $err }}</p>
								 	</div>
								 @endforeach
							@endif
						</div>
					</div>
					<div class="col-xs-12 formulario">
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Nombre de la sub-categoría:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Nombre para las busquedas(sin acentro)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('name_subcat', $subcat->sub_nomb,array('data-trigger' => "blur",'class' => 'form-control cat_nomb inputForm inputFondoNegro','placeholder' => 'Nombre de la categoria',)) }}
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
						<div class="col-xs-12 inputRegister">
							<p class="textoPromedio">Título de la sub-categoría:</p>
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Título para mostrar la sub-categoría (puede tener acentro)</p>
						</div>
						<div class="col-xs-12 inputRegister">
							{{ Form::text('desc_subcat',$subcat->sub_desc,array('class' => 'form-control inputForm cat_desc inputFondoNegro','placeholder' => 'Título de la categoría')) }}
							@if ($errors->has('desc_cat'))
								 @foreach($errors->get('desc_cat') as $err)
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
							<p class="bg-info textoPromedio" style="padding:0.5em;text-align:center;">* Debe seleccionar una imagen</p>
						</div>
						<div class="col-xs-12 inputRegister">
							<div class="table-responsive">
								<table class="table table-hover">
									<thead>
										<tr>
											<th>Imagen actual</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><img src="{{ asset('images/categorias/'.$subcat->img) }}" class="imgActual" data-src="{{ asset('images/categorias/'.$subcat->img) }}"></td>
											<td style="vertical-align:middle;"><input type="file" name="img" class="textoPromedio changeImg"></td>
										</tr>
									</tbody>
								</table>
							</div>
							@if ($errors->has('img'))
								 @foreach($errors->get('img') as $err)
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

@section('postscript')
<script>

//Este string contiene una imagen de 1px*1px color blanco
window.imagenVacia = '';

window.mostrarVistaPrevia = function mostrarVistaPrevia(esto) {

    var Archivos, Lector;

    Archivos = esto[0].files;
    if (Archivos.length > 0) {

        Lector = new FileReader();
        Lector.onloadend = function(e) {
            var origen, tipo;

            //Envia la imagen a la pantalla
            origen = e.target; //objeto FileReader
            //Prepara la información sobre la imagen
            tipo = window.obtenerTipoMIME(origen.result.substring(0, 30));

            
            
            //Si el tipo de archivo es válido lo muestra, 
            //sino muestra un mensaje 
            if (tipo !== 'image/jpeg' && tipo !== 'image/png' && tipo !== 'image/gif') {
                jQuery('.imgActual').attr('src', $('.imgActual').data('src'));
                alert('El formato de imagen no es válido: debe seleccionar una imagen JPG, PNG o GIF.');
            } else {
                jQuery('.imgActual').attr('src', origen.result);
                window.obtenerMedidas();
            }

        };
        Lector.onerror = function(e) {
            console.log(e)
        }
        Lector.readAsDataURL(Archivos[0]);

    } else {
        var objeto = esto;
        objeto.replaceWith(objeto.val('').clone());
        jQuery('.imgActual').attr('src',$('.imgActual').data('src'));
        
        
    };


};

//Lee el tipo MIME de la cabecera de la imagen
window.obtenerTipoMIME = function obtenerTipoMIME(cabecera) {
    return cabecera.replace(/data:([^;]+).*/, '\$1');
}

//Obtiene las medidas de la imagen y las agrega a la 

window.obtenerMedidas = function obtenerMedidas() {
    jQuery('<img/>').bind('load', function(e) {

    }).attr('src', jQuery('.image_6').attr('src'));
}

jQuery(document).ready(function() {

    //El input del archivo lo vigilamos con un "delegado"
    jQuery('.changeImg').on('change', function(e) {

        window.mostrarVistaPrevia($(this));
    });

    //El botón Cancelar lo vigilamos normalmente

});
</script>

@stop