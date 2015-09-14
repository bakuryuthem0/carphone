@extends('layouts.admin')

@section('content')
{{ HTML::style('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css') }}
<div class="row">
	<div class="container">
		<div class="col-xs-12 contCentrado contdeColor">
			<div class="col-xs-12">
				<legend>Seleccione las caracteristicas del articulo</legend>
				<p class="bg-warning textoPromedio" style="padding:0.5em;"><i class="fa fa-exclamation-triangle"></i>En caso de error si ya subio las imagenes no las resuba solo llene los campos.</p>
			</div>
			<form class="formCart" method="POST">
			<div class="col-xs-12 inputForm">	
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
			</form>
			<div class="col-xs-12 inputForm">
                <legend style="text-align:center;">Agregar las imágenes.</legend>
                <p class="textoPromedio">Arrastre imágenes en el cuadro o presione en él para así cargar las imágenes.</p>
                <p class="textoPromedio">Recuerde que posee un límite para 8 imágenes adicionales.</p>
                <div id="dropzone">
                    <form action="{{ URL::to('administrador/nuevo-articulo/imagenes/procesar') }}" method="POST" class="dropzone textoPromedio" id="my-awesome-dropzone">
                        <div class="dz-message">
                            Arrastre o presione aquí para subir su imagen.
                        </div>
                        <input type="hidden" name="art_id" class="art_id" value="{{ $id }}">
                    </form>
                    
                </div>
            </div>
			<div class="col-xs-12">
				<button class="btn btn-primary contNew">Nueva caracteristica</button>
				<button class="btn btn-success contSave">Guardar y continuar</button>
			</div>
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
{{ HTML::script('js/dropzone.js') }}
<script type="text/javascript">
    Dropzone.autoDiscover = false;
// or disable for specific dropzone:
// Dropzone.options.myDropzone = false;
    var myDropzone = new Dropzone("#my-awesome-dropzone");
    myDropzone.on("success", function(resp){
    	var response = JSON.parse(resp.xhr.response);
    	
    	$('.dz-preview:last-child').children('.dz-remove').attr({'data-info-value':response.image,'id':response.image})
    });
    myDropzone.on("removedfile", function(file) {
    	var image = $(file._removeLink).attr('id');

        if(file.xhr){

            $(function() {
              // Now that the DOM is fully loaded, create the dropzone, and setup the
              // event listeners
                var url = JSON.parse(file.xhr.response);
                var imagepath = url.url;
                $.ajax({
                    url: '../../imagenes/eliminar',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                    	'name' 		: file.name,
                    	'misc_id' 	: $('#misc_id').val(),
                    	'image'		: image,
                    	'id'	  	: $('#art_id').val()
                    },
                    success:function(response)
                    {
                        console.log(response)
                    }
                })

                
                })
            }
    })
    
</script>
@stop