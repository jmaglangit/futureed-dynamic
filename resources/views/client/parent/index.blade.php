@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManagePaymentController as payment" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="teacher.setActive('list')" >
			
		</div>
	</div>

@stop
	
@section('scripts')

@stop