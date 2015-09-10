@extends('layouts.admin')
@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12 contdeColor">
			<legend>Factura N°: {{ $id }}</legend>
      @if(Session::has('danger'))
        <div class="alert alert-danger">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <p class="textoPromedio">{{ Session::get('danger') }}</p>
        </div>
      @endif
			       <table class="table table-hover tableCarrito">
               <tr class="textoPromedio">
                  <th>Código</th>
                  
                  <th>
                   Artículo
                  </th>
                  <th>
                    Cantidad
                  </th>
                  <th>
                    Precio Unitario
                  </th>
                  <th>
                    Sub-total
                  </th>
                </tr>
                @foreach($items as $cart)
                <tr class="textoPromedio carItems" id="{{ $cart->id }}">
                  <td>
                    {{ $cart->item_cod }}
                  </td>
                  
                  <td class="carItem">
                    {{ $cart->item_nomb }}
                  </td>
                  <td class="carItem columnCant">
                    {{ $cart->qty }}
                  </td>
                  <td class="carItem">
                    {{ $cart->item_precio }}
                  </td>
                  <td class="carItem" id="input{{ $cart->id }}_subtotal">
                    {{ $cart->qty*$cart->item_precio }}
                  </td>
                  <?php $total = $total+($cart->qty*$cart->item_precio); ?>
                </tr>
              @endforeach
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td><h3>Total:</h3></td>
                <td><h3 class="precio">{{ $total }}</h3></td>
              </tr>
            </table>
		</div>

	</div>
</div>
@stop