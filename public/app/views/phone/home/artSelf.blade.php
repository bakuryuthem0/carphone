@extends('layouts.default')

@section('content')

<div class="row">
	<div class="col-xs-12">
		<div class="col-xs-12 col-md-10 contCentrado contDeColor">
			<legend>{{ $item->item_nomb.' - '.$item->item_cod }}</legend>
			<div class="row formulario">
				<div class="col-xs-12 col-md-4 textoPromedio contDescItem">
					<div class="col-xs-12" style="word-break: break-word;">
						<label class="description">Descripción</label>
						{{ $item->item_desc }}
						<a href="{{ URL::previous() }}" class="btn btn-success btn-volver">Volver</a>
					</div>
				</div>
				<div class="col-xs-12 col-md-4 contImageItem">
					<a href="{{ asset('images/items/'.$item->imgPrinc->image) }}" class="fancybox" data-fancybox-group="gallery">
						<img src="{{ asset('images/items/'.$item->imgPrinc->image) }}" class="imgPrinc">
					</a>
				</div>
				<div class="col-xs-12 col-md-4 textoPromedio contPrecItem">
					<div class="col-xs-12">
						<h3 class="precio">Precio: $. {{ $item->item_prec }}</h3>
					</div>
					<div class="col-xs-12 formulario">
						<label>Colores Disponibles</label>
						<ul class="colores">
							@foreach($item->colores as $c)
								<li>{{ $c['nombre'].': '.$c['item_stock'].' en stock' }}</li>
							@endforeach
						</ul>
						<input type="hidden" class="values" value="{{ $item->id }}" data-misc-id="">
					</div>
					@if(Auth::check() && Auth::user()->role != 1)
					<div class="col-xs-12 formulario">
						<button class="btn btn-danger btnAgg" data-toggle="modal" data-target="#addCart" data-cod-value="{{ $item->item_cod }}" data-price-value="{{ $item->item_precio}}" data-name-value="{{ $item->item_nomb }}" value="{{ $item->id }}">Agregar al carrito.</button>
					</div>
					@else
					<div class="col-xs-12 formulario">
						<button class="btn btn-danger" data-toggle="modal" data-target="#loginModal">Agregar al carrito.</button>
					</div>
					@endif
				</div>
			</div>
			<div class="col-xs-12 contImagesMini">
				@foreach($item->images as $i)
				<a href="{{ asset('images/items/'.$i['image']) }}" class="fancybox" data-fancybox-group="gallery">
					<img src="{{ asset('images/items/'.$i['image']) }}" class="imgMini">
				</a>
				@endforeach
			</div>
			<div class="hidden contDescMovil textoPromedio">
				<div class="col-xs-12" style="word-break: break-word;">
					<label class="description">Descripción</label>
					{{ $item->item_desc }}
					
					<a href="{{ URL::previous() }}" class="btn btn-volver">Volver</a>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
@stop

@section('postscript')
 <!-- Add mousewheel plugin (this is optional) -->
  {{ HTML::script('js/fancybox/lib/jquery.mousewheel.js') }}

  <!-- Add fancyBox -->
  {{ HTML::style('js/fancybox/source/jquery.fancybox.css?v=2.1.5',array('media' => 'screen')) }}
  {{ HTML::script('js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5') }}

  <!-- Optionally add helpers - button, thumbnail and/or media -->
  {{ HTML::style('js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5',array('media' => 'screen')) }}
  
  {{ HTML::script('js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5') }}
  {{ HTML::script('js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6') }}
  {{ HTML::script('js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7') }}
  {{ HTML::style('js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7',array('media' => 'screen')) }}
  <!-- Online <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.isotope/2.2.1/isotope.pkgd.min.js"></script> -->
  <script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
@stop