@extends('layouts.admin')

@section('content')


@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-8 contCentrado">
			<h3>Editar bancos</h3>
			<div class="alert responseDanger textoPromedio" style="text-align:center;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
			<table class="table table-hover">
				<thead>
					<tr class="textoPromedio">
						<th>Banco</th>
						<th>Numero de cuenta</th>
						<th>Tipo de cuenta</th>
						<th>Modificar</th>
						<th>Eliminar</th>
					</tr>
				</thead>
				<tbody>
					@foreach($bancos as $b)
					<tr class="textoPromedio">
						<td>{{ $b->banco }}</td>
						<td>{{ $b->num_cuenta }}</td>
						<td>{{ $b->tipo }}</td>
						<td><a href="{{ URL::to('administrador/editar-banco/'.$b->id) }}" class="btn btn-warning btn-xs">Modificar</a></td>
						<td><button class="btn btn-danger btn-xs btnElimBank" value="{{ $b->id }}">Eliminar</button></td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop