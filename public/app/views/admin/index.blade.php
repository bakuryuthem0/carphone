@extends('layouts.admin')

@section('content')
<div class="row">
	<div class="container">
		<div class="col-xs-12">
			@if(Session::has('success'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<p class="textoPromedio">{{ Session::get('success') }}</p>
				</div>
			@endif
		</div>
	</div>
</div>
@stop