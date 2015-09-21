@extends('layouts.default')

@section('content')


	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li class="active">Shopping Cart</li>
				</ol>
			</div>
			<div class="table-responsive cart_info">
				@if(Session::has('danger'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					{{ Session::get('danger') }}
				</div>
				@endif
				<table class="table table-condensed table-centered">
					<thead>
						<tr class="cart_menu">
							<td class="image">Codigo</td>
							<td class="description">Status</td>
							<td class="price">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($fac as $f)
						<tr class="" >
							<td class="cart_description">
								<p>{{ $f->id }}</p>
							</td>
							<td class="">
								@if($f->status == 0)
									<p class="text-danger"><i class="fa fa-exclamation"></i> Pago Pendiente</p>
								@elseif($f->status == 1)
									<p class="text-info"><i class="fa fa-clock-o"></i> Esperando Aprobación</p>
								@elseif($f->status == 2)
									<p class="text-success"><i class="fa fa-check"></i> Aprobado</p>
								@endif
							</td>
							<td class="cart_total">
								<p>${{ $f->total }}</p>
							</td>
							<td class="">
								@if($f->status == 0)
									<a href="{{ URL::to('telefono/compra/procesar/'.$f->id) }}" class="btn btn-default">Pagar</a>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->
@stop