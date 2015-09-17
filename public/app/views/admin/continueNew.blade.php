@extends('layouts.admin')

@section('content')
{{ HTML::style('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css') }}
<div class="row">
	<div class="container">
		<div class="col-xs-12 contCentrado contDeColor">
			<div class="col-xs-12">
				<legend>Seleccione las caracteristicas del articulo</legend>
			</div>
			<div class="col-xs-12 inputForm">
                <legend style="text-align:center;">Agregar las imágenes.</legend>
                <p class="textoPromedio">Arrastre imágenes en el cuadro o presione en él para así cargar las imágenes.</p>
                <p class="textoPromedio">Recuerde que posee un límite para 8 imágenes adicionales.</p>
                <div id="dropzone">
                    <form action="{{ URL::to('articulo/nuevo-articulo/imagenes/procesar') }}" method="POST" class="dropzone textoPromedio" id="my-awesome-dropzone">
                        <div class="dz-message">
                            Arrastre o presione aquí para subir su imagen.
                        </div>
                        <input type="hidden" name="art_id" class="art_id" value="{{ $id }}">
                    </form>
                    
                </div>
            </div>
			<div class="col-xs-12">
				<a href="{{ URL::to('articulo/ver-articulos') }}" class="btn btn-success contSave">Continuar</a>
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
    myDropzone.addRemoveLinks = true;
    myDropzone.on("success", function(resp){
        var id = JSON.parse(resp.xhr.response).image
        console.log(id)
    	$(resp._removeLink).css('color','blue').attr('data-dz-remove',id);
    });
    myDropzone.on("removedfile", function(file) {
    	var image = $(file._removeLink).attr('data-dz-remove');

        if(file.xhr){

            $(function() {
              // Now that the DOM is fully loaded, create the dropzone, and setup the
              // event listeners
                var url = JSON.parse(file.xhr.response);
                var imagepath = url.url;
                $.ajax({
                    url: 'http://localhost/carphone/public/articulo/imagenes/eliminar',
                    type: 'POST',
                    dataType: 'json',
                    data: {
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