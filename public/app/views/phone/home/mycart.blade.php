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
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image">Item</td>
							<td class="description"></td>
							<td class="price">Price</td>
							<td class="quantity">Quantity</td>
							<td class="total">Total</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach(Cart::content() as $c)
						<tr class="cartItem" id="item_{{ $c->id.$c->options['color'] }}">
							<td class="cart_product">
								<a href=""><img src="{{ $c->options['img'] }}" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{ $c->name }}</a></h4>
								<p>Codigo: {{ $c->options['cod'] }}</p>
							</td>
							<td class="cart_price">
								<p>${{ $c->price }}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									<a class="cart_quantity_down btn-rest" href="#!" data-id="{{ $c->id }}" data-color="{{ $c->options['color'] }}" data-target="#qty_{{ $c->id.$c->options['color'] }}"> - </a>
									<input class="cart_quantity_input" id="qty_{{ $c->id.$c->options['color'] }}" type="text" name="quantity" value="{{ $c->qty }}" autocomplete="off" size="2" data-initial-val="{{ $c->qty }}">
									<a class="cart_quantity_up btn-add " href="#!" data-id="{{ $c->id }}" data-color="{{ $c->options['color'] }}" data-target="#qty_{{ $c->id.$c->options['color'] }}"> + </a>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">${{ $c->subtotal }}</p>
							</td>
							<td class="cart_delete">
								<button class="cart_quantity_delete removeItem" value="{{ $c->id }}" data-target="#item_{{ $c->id.$c->options['color'] }}" data-color="{{ $c->options['color'] }}">	<i class="fa fa-times"></i>
								</button>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</section> <!--/#cart_items-->

	<section id="do_action">
		<div class="container">
			<div class="heading">
				<h3>What would you like to do next?</h3>
				<p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
			</div>
			<div class="row">
				<!-- <div class="col-sm-6">
					<div class="chose_area">
						<ul class="user_option">
							<li>
								<input type="checkbox">
								<label>Use Coupon Code</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Use Gift Voucher</label>
							</li>
							<li>
								<input type="checkbox">
								<label>Estimate Shipping & Taxes</label>
							</li>
						</ul>
						<ul class="user_info">
							<li class="single_field">
								<label>Country:</label>
								<select>
									<option>United States</option>
									<option>Bangladesh</option>
									<option>UK</option>
									<option>India</option>
									<option>Pakistan</option>
									<option>Ucrane</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
								
							</li>
							<li class="single_field">
								<label>Region / State:</label>
								<select>
									<option>Select</option>
									<option>Dhaka</option>
									<option>London</option>
									<option>Dillih</option>
									<option>Lahore</option>
									<option>Alaska</option>
									<option>Canada</option>
									<option>Dubai</option>
								</select>
							
							</li>
							<li class="single_field zip-field">
								<label>Zip Code:</label>
								<input type="text">
							</li>
						</ul>
						<a class="btn btn-default update" href="">Get Quotes</a>
						<a class="btn btn-default check_out" href="">Continue</a>
					</div>
				</div>-->
				<div class="col-sm-6">
					<div class="total_area">
						<ul>
							<li>Sub Total del Carrito<span class="totalCart">{{ Cart::total() }}</span></li>
						</ul>
							<a class="btn btn-default check_out comprarBtn" href="{{ URL::to('telefono/compra/procesar') }}">Comprar</a>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#do_action-->
	<!-- Modal -->
	<div class="modal fade" id="eraseItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content contDeColor">
				<legend><h2>¿Seguro desea quitar el artículo?</h2></legend>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger">Borrar</button>
			</div>
		</div>
	</div>
@stop