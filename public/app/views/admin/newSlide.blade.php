@extends('layouts.admin')

@section('content')
{{ HTML::style('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css') }}
<div class="row">
	<div class="container">
		<div class="col-xs-12">
			<div class="col-xs-6 contdeColor contCentrado">
				<legend>Nuevo slide</legend>
				<p class="bg-info textoPromedio" style="padding:0.5em;">Recuerde que las imagenes para el slider debe ser de almenos 1290*800 pixels</p>
				<div class="bg-primary textoPromedio contOptionA" style="padding:0.5em;">
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".single" style="color:white;">Unico slide </a>
					</div>
					<div class="col-xs-12">
						<a href="#" class="optionA" data-target=".multiple" style="color:white;">Multiples slides</a>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="single imagesSlidesOption textoPromedio">
					<form method="POST" action="{{ URL::to($url) }}" enctype="multipart/form-data">

						<label>Slide:</label>
						<input type="file" name="img">
						<button class="btn btn-success btn-xs" style="margin-top:1em;">Enviar</button>
					</form>
				</div>
				<div class="multiple imagesSlidesOption">
					<div id="dropzone">
	                    <form action="{{ URL::to($url2) }}" method="POST" class="dropzone textoPromedio" id="my-awesome-dropzone">
	                        <div class="dz-message">
	                            Arrastre o presione aquí para subir su imagen.
	                        </div>
	                    </form>
	                    
	                </div>
	                <a href="{{ URL::to('administrador/editar-slides') }}" class="btn btn-success">Continuar</a>
				</div>
				<div class="bg-primary textoPromedio volver" style="padding:0.5em;margin-top:1em;">
					
					<div class="col-xs-12">
						<a href="#"style="color:white;">Volver</a>
					</div>
					<div class="clearfix"></div>
				</div>

			</div>
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
                    url: 'nuevos-slides/eliminar',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                    	'name' 		: file.name,
                    	'id'		: image,
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