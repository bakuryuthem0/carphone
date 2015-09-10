@extends('layouts.admin')

@section('content')
<div class="modal fade" id="elimFac" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
				<div class="modal-body">
						<legend>Rechazar pago</legend>
					</div>
				<div class="modal-footer " style="text-align:center;">
					<div class="alert responseDanger">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					</div>
					<p class="textoPromedio">¿Seguro que desea rechazar este pago?</p>
					<textarea name="motivo" class="form-control" id="motivo"></textarea>
					<button class="btn btn-success envReject" style="margin-top:2em;">Rechazar</button>	
				</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="container">
		<div class="col-xs-12">
			@if(Session::has('success'))
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<p class="textoPromedio">{{ Session::get('success') }}</p>
			</div>
			@endif
			<div class="alert responseDanger" style="text-align:center;">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			</div>
			<h3>Pagos realizados</h3>
			<div class="clearfix"></div>
			<form action="#" method="get">
					<!-- USE TWITTER TYPEAHEAD JSON WITH API TO SEARCH -->
					<input class="form-control" id="buscar-usuario" name="q" placeholder="Busqueda general" required>
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-search"></i>
					</span>
			</form>
			<table id="tablesorter" class="tablesorter table table-striped table-condensed table-vertical-middle table-super-condensed table-bordered table-list-search table-hover">
				<thead>
					<tr>
						<th class="textoPromedio">Codigo de factura</th>
						<th class="textoPromedio">Datos del usuario</th>
						<th class="textoPromedio">Datos de la transacción</th>
						<th class="textoPromedio">Bouche</th>

						<th class="textoPromedio">email</th>
						<th class="textoPromedio">Dirección</th>
						<th class="textoPromedio">Factura</th>
					</tr>
				</thead>
				<tbody>
					@foreach($fac as $f)
					<tr class="textoPromedio">
						<td>{{ $f->id }}</td>
						<td class="textoMedio noMovil">
							<button class="btn btn-primary btn-xs ver" data-toggle="modal" data-target="#showUserData" value="{{ $f->id }}">
								Ver
							</button>
						</td>
						
						<input type="hidden" class="username-{{ $f->id }}" value="{{ $f->username }}">
						<input type="hidden" class="name-{{ $f->id }}" value="{{ $f->nombre.' '.$f->apellido }}">
						<input type="hidden" class="email-{{ $f->id }}" value="{{ $f->email }}">
						<input type="hidden" class="dir-{{ $f->id }}" value="{{ $f->user_dir }}">
						<input type="hidden" class="phone-{{ $f->id }}" value="{{ $f->telefono }}">
						<input type="hidden" class="est-{{ $f->id }}" value="{{ $f->dep_name }}">
						<td class="textoMedio noMovil">
							<button class="btn btn-primary btn-xs verTransData" data-toggle="modal" data-target="#showTransData" value="{{ $f->id }}">
								Ver
							</button>
						</td>
						
						<input type="hidden" class="bank-{{ $f->id }}" value="{{ $f->banco_name }}">
						<input type="hidden" class="bank2-{{ $f->id }}" value="{{ $f->banco_ext }}">
						<input type="hidden" class="fech-{{ $f->id }}" value="{{ $f->fech_trans }}">
						<td>
							<a href="{{ asset('images/pagos/'.$f->num_trans) }}" class="fancybox"><img src="{{ asset('images/pagos/'.$f->num_trans) }}"></a>
						</td>
						<td>{{ $f->email }}</td>
						<td>{{ $f->dir_name }}</td>
						
						<td><a href="{{ URL::to('administrador/ver-factura/'.$f->id) }}" target="_blank" class="btn btn-info btn-xs">Ver</a></td>
						@if(!isset($type))

						<td><button class="btn btn-success btn-xs aprov-fac" value="{{ $f->id }}">Aprobar</button></td>
						<td><button class="btn btn-danger btn-xs reject-fac" value="{{ $f->id }}" data-toggle="modal" data-target="#elimFac">Rechazar</button></td>
						
						@endif

						
					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal fade" id="showUserData" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Datos del usuario.</h4>
			</div>
			<div class="modal-body">
				<div class="col-xs-12" style="margin-top:3em;">
					<p class="textoPromedio"><label>Nombre de usuario</label></p>
					<p class="textoPromedio usernameModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Nombre y apellido</label></p>
					<p class="textoPromedio nameModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Email</label></p>
					<p class="textoPromedio emailModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Dirección</label></p>
					<p class="textoPromedio dirModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Telefono</label></p>
					<p class="textoPromedio phoneModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Departamento</label></p>
					<p class="textoPromedio pagWebModal">

					</p>
				</div>
				
			</div>
			<div class="modal-footer " style="text-align:center;">
				
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="showTransData" tabindex="-1" role="dialog" aria-labelledby="modalForggo" aria-hidden="true">
	<div class="forgotPass modal-dialog imgLiderUp">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalLabel">Datos de la transacción.</h4>
			</div>
			<div class="modal-body">
				<div class="col-xs-12" style="margin-top:3em;">
					<p class="textoPromedio"><label>Banco de destino</label></p>
					<p class="textoPromedio bankeModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Banco emisor</label></p>
					<p class="textoPromedio bankemisorModal">

					</p>
				</div>
				<div class="col-xs-12">
					<p class="textoPromedio"><label>Fecha de transacción</label></p>
					<p class="textoPromedio fechTransModal">

					</p>
				</div>
				
				
			</div>
			<div class="modal-footer " style="text-align:center;">
				
			</div>
		</div>
	</div>
</div>
@stop
@section('postscript')
<script type="text/javascript">
	$(document).ready(function() {
		$(".fancybox").fancybox();
	});
</script>
@stop