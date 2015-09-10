@extends('layouts.admin')

@section('content')
{{ HTML::style('https://rawgit.com/enyo/dropzone/master/dist/dropzone.css') }}
    <div class="container contenedorUnico">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-8 col-sm-offset-2 contAnaranjado">
                    <legend style="text-align:center;">Subir imágenes restantes</legend>
                    <p class="textoPromedio">Arrastre imágenes en el cuadro o presione en él para así cargar las imágenes restantes.</p>
                    <p class="textoPromedio">Recuerde que posee un límite para 7 imágenes adicionales.</p>
                    <div id="dropzone">
                        <form action="{{ URL::to('administrador/nuevo-articulo/imagenes/procesar') }}" method="POST" class="dropzone textoPromedio" id="my-awesome-dropzone">
                            <div class="dz-message">
                                Arrastre o presione aquí para subir su imagen.
                            </div>
                            <input type="hidden" name="id" value="{{ $id }}">
                        </form>
                        <a class="btn btn-primary" href="{{ URL::to('publicacion/habitual/previsualizar/'.$id) }}" id="enviarImagenes" style="margin:2em auto;display:block;">Continuar</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@stop

@section('postscript')
{{ HTML::script('js/dropzone.js') }}
<script type="text/javascript">
    Dropzone.autoDiscover = false;
// or disable for specific dropzone:
// Dropzone.options.myDropzone = false;
    var myDropzone = new Dropzone("#my-awesome-dropzone");

    myDropzone.on("removedfile", function(file) {
        if(file.xhr){

            $(function() {
              // Now that the DOM is fully loaded, create the dropzone, and setup the
              // event listeners
                var url = JSON.parse(file.xhr.response);
                var imagepath = url.url;
                $.ajax({
                    url: 'publicacion/habitual/enviar/imagenes/eliminar',
                    type: 'POST)',
                    dataType: 'json',
                    data: {name :  file.name},
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