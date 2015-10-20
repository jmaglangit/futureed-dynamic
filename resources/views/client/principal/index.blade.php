@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con">
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
		<div class="wrapr"></div>
	</div>
@stop
	
@section('scripts')

@stop